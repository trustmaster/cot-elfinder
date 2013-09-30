<?php
/**
 * English language file
 *
 * @package elfinder
 * @version 1.0
 * @author Trustmaster
 * @copyright (c) Cotonti Team 2012
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$L['plu_title'] = 'File manager';
$L['cfg_quotas'] = array('Enable user groups disk quotas', !$cot_plugins_active['pfs'] ? '<b>Note:</b> user groups disk quotas is used only with `<a href="'.cot_url('admin','m=extensions&a=details&mod=pfs').'">PFS</a>` plugin installed. Now it is disabled.' : '');

?>
