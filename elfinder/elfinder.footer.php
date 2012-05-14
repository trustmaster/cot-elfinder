<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=footer.tags
[END_COT_EXT]
==================== */

/**
 * elFinder JavaScript connector
 *
 * @package elfinder
 * @version 1.0
 * @author Trustmaster
 * @copyright Copyright (c) Cotonti Team 2012
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$parser = !empty($sys['parser']) ? $sys['parser'] : $cfg['parser'];
if ($cot_textarea_count > 0 && cot_plugin_active('elrte') && $parser == 'html')
{
	// Language selection
	global $lang;
	$mkup_lang = $cfg['plugins_dir']."/elfinder/js/i18n/elfinder.$lang.js";

	// Load resources
	$mkup_theme = cot_rc('code_rc_css_file', array('url' => $cfg['plugins_dir'] . '/elfinder/css/elfinder.min.css'));
	$mkup_theme2 = cot_rc('code_rc_css_file', array('url' => $cfg['plugins_dir'] . '/elfinder/css/theme.css'));
	cot_rc_link_footer($cfg['plugins_dir'] . '/elfinder/js/elfinder.min.js');
	if (file_exists($mkup_lang))
	{
		cot_rc_link_footer($mkup_lang);
	}
	cot_rc_embed_footer('$(document).ready(function() {
		$("head").append(\''.$mkup_theme.'\');
		$("head").append(\''.$mkup_theme2.'\');
	});');
}

?>
