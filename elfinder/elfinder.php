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
$mkup_skin = cot_rc('code_rc_css_file', array('url' => $cfg['plugins_dir'] . '/elrte/css/smoothness/jquery-ui-1.8.13.custom.css'));
$mkup_theme = cot_rc('code_rc_css_file', array('url' => $cfg['plugins_dir'] . '/elfinder/css/elfinder.min.css'));
$mkup_theme2 = cot_rc('code_rc_css_file', array('url' => $cfg['plugins_dir'] . '/elfinder/css/theme.css'));
cot_rc_link_footer($cfg['plugins_dir'] . '/elrte/js/jquery-ui-1.8.13.custom.min.js');
cot_rc_link_footer($cfg['plugins_dir'] . '/elfinder/js/elfinder.min.js');
if (file_exists($mkup_lang))
{
	cot_rc_link_footer($mkup_lang);
}
cot_rc_embed_footer('$(document).ready(function() {
	$("head").append(\''.$mkup_skin.'\');
	$("head").append(\''.$mkup_theme.'\');
	$("head").append(\''.$mkup_theme2.'\');
	var elf = $(\'#elfinder\').elfinder({
		lang: \'$lang\',
		url : \'index.php?r=elfinder&_ajax=1&x='.$sys['xk'].'\'
	}).elfinder(\'instance\');
});');

$plugin_title = 'elFinder';
$plugin_body = '<div id="elfinder"></div>';

?>
