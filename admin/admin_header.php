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
 */

require_once __DIR__ . '/../../../include/cp_header.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/../include/functions.php';

global $xoopsModule;
$pathIcon16 = \Xmf\Module\Admin::iconUrl('', 16);
$pathIcon16 = \Xmf\Module\Admin::iconUrl('', 32);

$xoopsModuleAdminPath = $GLOBALS['xoops']->path('www/' . $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin'));
require_once "{$xoopsModuleAdminPath}/moduleadmin.php";

$myts = \MyTextSanitizer::getInstance();

if ($xoopsUser) {
    $modulepermHandler = xoops_getHandler('groupperm');
    if (!$modulepermHandler->checkRight('module_admin', $xoopsModule->getVar('mid'), $xoopsUser->getGroups())) {
        redirect_header(XOOPS_URL, 1, _NOPERM);
    }
} else {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
}

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    require_once XOOPS_ROOT_PATH . '/class/template.php';
    $xoopsTpl = new \XoopsTpl();
}

$xoopsTpl->assign('pathImageIcon', $pathIcon16);
//xoops_cp_header();

//Load languages
xoops_loadLanguage('admin', $xoopsModule->getVar('dirname'));
xoops_loadLanguage('modinfo', $xoopsModule->getVar('dirname'));
xoops_loadLanguage('main', $xoopsModule->getVar('dirname'));
