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

require_once __DIR__ . '/admin_header.php';

if (isset($_REQUEST['op'])) {
    $op = $_REQUEST['op'];
} else {
    redirect_header('main.php', 1, _NOPERM);
}

$pageHandler = xoops_getModuleHandler('page');

switch ($op) {
    case 'save':
        if (!isset($_POST['pageid'])) {
            $page = $pageHandler->create();
        } elseif (!$page = $pageHandler->get($_POST['pageid'])) {
            $page = $pageHandler->create();
        }

        $page->setVar('pagetitle', $_POST['pagetitle']);

        if ($pageHandler->insert($page)) {
            redirect_header('main.php?pageid=' . $page->getVar('pageid'), 1, _AM_MYTABS_SUCCESS);
        }
        break;

    case 'new':
    case 'edit':
        $adminObject = \Xmf\Module\Admin::getInstance();
        xoops_cp_header();
        $adminObject->displayNavigation('main.php');

        if ('new' === $op) {
            $page = $pageHandler->create();
            $page->setVar('pagetitle', $_REQUEST['pagetitle']);
        } else {
            $page = $pageHandler->get($_REQUEST['pageid']);
        }
        $pageid = $page->getVar('pageid');

        echo '<a href="main.php">' . _AM_MYTABS_HOME . '</a>&nbsp;';

        $form = $page->getForm();
        echo $form->render();

        require_once __DIR__ . '/admin_footer.php';
        break;

    case 'delete':
        $obj = $pageHandler->get($_REQUEST['pageid']);
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if ($pageHandler->delete($obj)) {
                $tabHandler = xoops_getModuleHandler('tab');
                $tabs       = $tabHandler->getObjects(new \Criteria('tabpageid', $_REQUEST['pageid']));
                foreach ($tabs as $tab) {
                    $tabHandler->delete($tab);
                }
                $pageblockHandler = xoops_getModuleHandler('pageblock');
                $blocks           = $pageblockHandler->getObjects(new \Criteria('pageid', $_REQUEST['pageid']));
                foreach ($blocks as $block) {
                    $pageblockHandler->delete($block);
                }
                redirect_header('main.php', 3, sprintf(_AM_MYTABS_DELETEDSUCCESS, $obj->getVar('pagetitle')));
            } else {
                xoops_cp_header();
                echo implode('<br>', $obj->getErrors());
                require_once __DIR__ . '/admin_footer.php';
            }
        } else {
            xoops_cp_header();
            xoops_confirm(['ok' => 1, 'pageid' => $_REQUEST['pageid'], 'op' => 'delete'], 'page.php', sprintf(_AM_MYTABS_RUSUREDEL, $obj->getVar('pagetitle')));
            require_once __DIR__ . '/admin_footer.php';
        }
        break;
}
