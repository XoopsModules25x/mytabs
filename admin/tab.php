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

$tabHandler = xoops_getModuleHandler('tab');

switch ($op) {
    case 'save':
        if (!isset($_POST['tabid'])) {
            $tab = $tabHandler->create();
        } elseif (!$tab = $tabHandler->get($_POST['tabid'])) {
            $tab = $tabHandler->create();
        }

        $tab->setVar('tabpageid', $_POST['tabpageid']);
        $tab->setVar('tabtitle', $_POST['tabtitle']);
        $tab->setVar('tablink', $_POST['tablink']);
        $tab->setVar('tabrev', $_POST['tabrev']);
        $tab->setVar('tabpriority', $_POST['tabpriority']);
        $tab->setVar('tabshowalways', $_POST['tabalwayson']);
        $tab->setVar('tabfromdate', strtotime($_POST['tabfromdate']['date']) + $_POST['tabfromdate']['time']);
        $tab->setVar('tabtodate', strtotime($_POST['tabtodate']['date']) + $_POST['tabtodate']['time']);
        $tab->setVar('tabnote', $_POST['tabnote']);
        $tab->setVar('tabgroups', $_POST['tabgroups']);

        if ($tabHandler->insert($tab)) {
            redirect_header('main.php?pageid=' . $tab->getVar('tabpageid'), 1, _AM_MYTABS_SUCCESS);
        }
        break;

    case 'new':
    case 'edit':
        $adminObject = \Xmf\Module\Admin::getInstance();
        xoops_cp_header();
        $adminObject->displayNavigation('main.php');

        if ($op == 'new') {
            $tab = $tabHandler->create();
            $tab->setVar('tabpageid', $_REQUEST['pageid']);
            $tab->setVar('tabtitle', $_POST['tabtitle']);
            $tab->setVar('tabfromdate', time());
            $tab->setVar('tabtodate', time());
        } else {
            $tab = $tabHandler->get($_REQUEST['tabid']);
        }
        $pageid = $tab->getVar('tabpageid');

        echo "<a href=\"main.php\">" . _AM_MYTABS_HOME . '</a>&nbsp;';

        if ($pageid > 0) {
            $pageHandler = xoops_getModuleHandler('page');
            $page        = $pageHandler->get($pageid);
            echo '&raquo;&nbsp;';
            echo "<a href=\"main.php?pageid=" . $pageid . "\">" . $page->getVar('pagetitle') . '</a>';
        }

        $form = $tab->getForm();
        echo $form->render();

        require_once __DIR__ . '/admin_footer.php';
        break;

    case 'delete':
        $obj = $tabHandler->get($_REQUEST['tabid']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ($tabHandler->delete($obj)) {
                $pageblockHandler = xoops_getModuleHandler('pageblock');
                $blocks           = $pageblockHandler->getObjects(new Criteria('tabid', $_REQUEST['tabid']));
                foreach ($blocks as $block) {
                    $pageblockHandler->delete($block);
                }
                redirect_header('main.php?pageid=' . $obj->getVar('tabpageid'), 3, sprintf(_AM_MYTABS_DELETEDSUCCESS, $obj->getVar('tabtitle')));
            } else {
                xoops_cp_header();
                echo implode('<br>', $obj->getErrors());
                require_once __DIR__ . '/admin_footer.php';
            }
        } else {
            xoops_cp_header();
            xoops_confirm(['ok' => 1, 'tabid' => $_REQUEST['tabid'], 'op' => 'delete'], 'tab.php', sprintf(_AM_MYTABS_RUSUREDEL, $obj->getVar('tabtitle')));
            require_once __DIR__ . '/admin_footer.php';
        }
        break;
}
