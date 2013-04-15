<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=standalone
[END_COT_EXT]
==================== */

/**
 * elFinder standalone file manager
 *
 * @package elfinder
 * @version 1.0
 * @author Trustmaster
 * @copyright Copyright (c) Cotonti Team 2012
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

// Language selection
global $lang;
$mkup_lang = $cfg['plugins_dir']."/elfinder/js/i18n/elfinder.$lang.js";

// Load resources
cot_rc_link_footer('lib/jquery-ui/js/jquery-ui-1.10.2.custom.min.js');
cot_rc_link_footer($cfg['plugins_dir'] . '/elfinder/js/elfinder.min.js');
if (file_exists($mkup_lang))
{
	cot_rc_link_footer($mkup_lang);
}

cot_rc_embed_footer('$(document).ready(function() {
	var elf = $(\'#elfinder\').elfinder({
		lang: \''.$lang.'\',
		url : \'index.php?r=elfinder&_ajax=1&x='.$sys['xk'].'\'
	}).elfinder(\'instance\');
});');

$plugin_title = 'elFinder';
$plugin_body = '<div id="elfinder"></div>';
