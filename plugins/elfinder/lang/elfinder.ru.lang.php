<?php
/**
 * Russian language file
 *
 * @package elfinder
 * @version 1.0
 * @author Trustmaster
 * @copyright (c) Cotonti Team 2012
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

$L['plu_title'] = 'Файловый менеджер';
$L['cfg_folder'] = array('Корневая папка для файлов (с CHMOD 775/777)');
$L['cfg_public'] = array('Включить папку &quot;Для всех&quot;');
$L['cfg_filter'] = array('Режим фильтра имен файлов');
$L['cfg_filter_params'] = array('Черный список', 'Белый список');
$L['cfg_blacklist'] = array('Черный список расширений (разделенных |)');
$L['cfg_whitelist'] = array('Белый список расширений (разделенных |)');
$L['cfg_quotas'] = array('Включить дисковые квоты групп пользователей', !$cot_plugins_active['pfs'] ? '<b>Обратите внимание</b>, что ограничение согласно квотам будет работать только установленном плагине `<a href="'.cot_url('admin','m=extensions&a=details&mod=pfs').'">PFS</a>`. Сейчас он отключен.' : '');

?>
