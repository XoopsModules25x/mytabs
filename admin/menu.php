<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @package         Mytabs
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: menu.php 0 2009-11-14 18:47:04Z trabis $
 */
 
defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

$dirname = basename(dirname(dirname(__FILE__)));
$module_handler = xoops_gethandler('module');
$module = $module_handler->getByDirname($dirname);
$pathIcon32 = $module->getInfo('icons32');

//xoops_loadLanguage('admin', $dirname);

$adminmenu = array();

$i = 1;
$adminmenu[$i]["title"] = _MI_MYTABS_ADMMENU0;
$adminmenu[$i]["link"] = 'admin/index.php';
$adminmenu[$i]["icon"] = $pathIcon32.'/home.png';

$i++;
$adminmenu[$i]['title'] = _MI_MYTABS_ADMMENU1;
$adminmenu[$i]['link'] = "admin/main.php";
$adminmenu[$i]["icon"] = $pathIcon32.'/manage.png';

$i++;
$adminmenu[$i]['title'] = _MI_MYTABS_ADMMENU2;
$adminmenu[$i]['link'] = "admin/about.php";
$adminmenu[$i]["icon"] = $pathIcon32.'/about.png';
