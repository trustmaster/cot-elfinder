<?php
/* ====================
[BEGIN_COT_EXT]
Code=elfinder
Name=elFinder
Category=files-media
Description=Web file manager with Finder-like interface
Version=2.0-rc1-1.0
Date=2012-05-15
Author=Studio 42, http://elfinder.org
Copyright=Copyright (C) Studio 42
Notes=BSD License
SQL=
Auth_guests=
Lock_guests=W12345A
Auth_members=RW
Lock_members=12345
Requires_plugins=elrte
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
folder=01:string::datas/files:Root folder for files (with CHMOD 775/777)
public=02:radio::0:Enable &quot;public&quot; folder for all users
filter=03:select:blacklist,whitelist:blacklist:Filename filter mode
blacklist=04:text::asp|aspx|bin|cgi|exe|htm|html|jar|php|php4|php5|pl|py|rb|sh|shtml|xhtml:Extensions blacklist (separated with pipe '|')
whitelist=05:text::7z|avi|bmp|doc|docx|flv|gif|jpeg|jpg|mkv|mov|mp3|mpeg|mpg|odt|ogg|ogv|pdf|png|rar|txt|wav|zip:Extensions whitelist (separated with pipe '|')
quotas=06:radio::0:Enable user groups disk quotas
[END_COT_EXT_CONFIG]
==================== */

defined('COT_CODE') or die('Wrong URL');

?>