<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=ajax
[END_COT_EXT]
==================== */

/**
 * elFinder connector for Cotonti
 *
 * @package elfinder
 * @version 1.0
 * @author Trustmaster
 * @copyright Copyright (c) Cotonti Team 2012
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

// elFinder includes
require_once $cfg['plugins_dir'] . '/elfinder/php/elFinderConnector.class.php';
require_once $cfg['plugins_dir'] . '/elfinder/php/elFinder.class.php';
require_once $cfg['plugins_dir'] . '/elfinder/php/elFinderVolumeDriver.class.php';
require_once $cfg['plugins_dir'] . '/elfinder/php/elFinderVolumeLocalFileSystem.class.php';

// Cotonti uploads API
require_once cot_incfile('uploads');

// CKEditor integration
if (cot_import('ckeditor', 'G', 'BOL'))
{
	$tt = new XTemplate(cot_tplfile('elfinder.ckeditor', 'plug'));
	$tt->parse();
	$tt->out();
	exit;
}

if ($cfg['plugin']['elfinder']['quotas'] && $usr['auth_write'])
{
	// Get limits for current user
	$el_usr_limits = el_pfs_limits($usr['id']);
	$el_pfs_size = el_filesize($cfg['plugin']['elfinder']['folder'] . '/' . $usr['id']);
}

// Initialize elFinder roots
$el_roots = array();

// Attach user volume for registered users
if ($usr['id'] > 0)
{
	if (!file_exists($cfg['plugin']['elfinder']['folder'] . '/' . $usr['id']))
	{
		mkdir($cfg['plugin']['elfinder']['folder'] . '/' . $usr['id']);
	}
	$el_roots[] = array(
		'alias'			=> $L['Mypfs'],
		'driver'		=> 'LocalFileSystem',
		'path'			=> getcwd() . '/' . $cfg['plugin']['elfinder']['folder'] . '/' . $usr['id'] . '/',
		'URL'			=> $sys['abs_url'] . $cfg['plugin']['elfinder']['folder'] . '/' . $usr['id'] . '/',
		'accessControl' => 'el_access',
		'acceptedName'	=> 'el_checkname',
		'uploadMaxSize'	=> $cfg['plugin']['elfinder']['quotas'] ? $el_usr_limits[0].'K' : 0,
		'disabled' 		=> (!$usr['auth_write'] || $cfg['plugin']['elfinder']['quotas'] && $el_pfs_size >= $el_usr_limits[1]) ? explode(' ', 'mkdir mkfile rename duplicate upload rm paste') : array()
	);
}

// Attach root volume for admins
if ($usr['isadmin'])
{
	if (!file_exists($cfg['plugin']['elfinder']['folder'] . '/'))
	{
		mkdir($cfg['plugin']['elfinder']['folder'] . '/');
	}
	$el_roots[] = array(
		'alias'			=> $L['All'],
		'driver'		=> 'LocalFileSystem',
		'path'			=> getcwd() . '/' . $cfg['plugin']['elfinder']['folder'] . '/',
		'URL'			=> $sys['abs_url'] . $cfg['plugin']['elfinder']['folder'] . '/',
		'accessControl' => 'el_access',
		'acceptedName'	=> 'el_checkname'
	);
}

// Attach public volume if enabled
if ($cfg['plugin']['elfinder']['public'])
{
	if (!file_exists($cfg['plugin']['elfinder']['folder'] . '/public'))
	{
		mkdir($cfg['plugin']['elfinder']['folder'] . '/public');
	}
	$el_roots[] = array(
		'alias'			=> $L['Public'],
		'driver'		=> 'LocalFileSystem',
		'path'			=> getcwd() . '/' . $cfg['plugin']['elfinder']['folder'] . '/public/',
		'URL'			=> $sys['abs_url'] . $cfg['plugin']['elfinder']['folder'] . '/public/',
		'accessControl' => 'el_access',
		'acceptedName'	=> 'el_checkname',
		'uploadMaxSize'	=> $cfg['plugin']['elfinder']['quotas'] ? $el_usr_limits[0].'K' : 0,
		'disabled'		=> (!$usr['auth_write']) ? explode(' ', 'mkdir mkfile rename duplicate upload rm paste') : array()
	);
}


// Customize elFinder options
$el_opts = array(
	'roots' => $el_roots
);

// Run elFinder
$connector = new elFinderConnector(new elFinder($el_opts));
$connector->run();

/*
 * Helper Functions
 */

/**
 * Cotonti "accessControl" callback.
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function el_access($attr, $path, $data, $volume)
{
	global $cfg, $usr, $el_usr_limits, $el_pfs_size;

	// Hide files starting with dot
	if (strpos(basename($path), '.') === 0)
	{
		// set read+write to false, other (locked+hidden) set to true
		return !($attr == 'read' || $attr == 'write');
	}

	// Check write permission
	if ($attr == 'write' && !$usr['auth_write'])
	{
		return false;
	}

	return null; // let elFinder decide it itself
}

/**
 * Cotonti "acceptedName" callback
 * @param  string $name File name
 * @return bool         TRUE or FALSE
 */
function el_checkname($name)
{
	global $cfg;
	// Disallow .php parts in file names
	if (preg_match('#\.php\d*($|\.)#i', $name))
	{
		return false;
	}

	// Apply extensions policy
	if ($cfg['plugin']['elfinder']['filter'] == 'blacklist')
	{
		// Blacklist
		if (preg_match('#\.('.$cfg['plugin']['elfinder']['blacklist'].')$#i', $name))
		{
			return false;
		}
	}
	else
	{
		// Whitelist
		if (!preg_match('#\.('.$cfg['plugin']['elfinder']['whitelist'].')$#i', $name))
		{
			return false;
		}
	}
	return true;
}

/**
 * Recursive filesize calculator
 * @param  string $path File or directory path
 * @return int          File size in bytes
 */
function el_filesize($path)
{
	if (is_file($path))
	{
		return filesize($path);
	}
	$size = 0;
	$dp = opendir($path);
	while ($f = readdir($dp))
	{
		if ($f[0] != '.')
		{
			$size += el_filesize($path . '/' . $f);
		}
	}
	closedir($dp);
	return $size;
}

/**
 * Get Cotonti filesize limits
 *
 * @param int $userid User ID
 * @return array
 */
function el_pfs_limits($userid)
{
	global $db, $db_groups, $db_groups_users;

	$maxfile = 0;
	$maxtotal = 0;
	$sql = $db->query("SELECT MAX(grp_pfs_maxfile) AS maxfile, MAX(grp_pfs_maxtotal) AS maxtotal
	FROM $db_groups	WHERE grp_id IN (SELECT gru_groupid FROM $db_groups_users WHERE gru_userid=".(int)$userid.") LIMIT 1");
	if ($row = $sql->fetch())
	{
		$maxfile = min($row['maxfile'], cot_get_uploadmax());
		$maxtotal = $row['maxtotal'];
	}
	return array($maxfile, $maxtotal);
}

?>
