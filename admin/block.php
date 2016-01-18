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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @package         Mytabs
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: block.php 0 2009-11-14 18:47:04Z trabis $
 */

require dirname(__FILE__) . '/header.php';

if (isset($_REQUEST['op'])){
    $op = $_REQUEST['op'];
} else {
    redirect_header('main.php', 1, _NOPERM);
    exit;
}

$pageblock_handler = xoops_getmodulehandler('pageblock');

switch ($op) {
    case "save":

        if (!isset($_POST['pageblockid'])) {
            $block = $pageblock_handler->create();
        } else if (!$block = $pageblock_handler->get($_POST['pageblockid'])){
            $block = $pageblock_handler->create();
        }

        $block->setVar('pageid', $_POST['pageid']);
        $block->setVar('blockid', $_POST['blockid']);
        $block->setVar('title', $_POST['title']);

        if (isset($_POST['options']) && (count($_POST['options']) > 0)) {
            $options = $_POST['options'];
            $count = count($options);
            for ($i = 0; $i < $count; $i++) {
                if (is_array($options[$i])) {
                    $options[$i] = implode(',', $options[$i]);
                }
            }
            $block->setVar('options', implode('|', $options));
        } else {
            $block->setVar('options', '');
        }

        $block->setVar('tabid', $_POST['tabid']);
        $block->setVar('priority', $_POST['priority']);
        $block->setVar('showalways', $_POST['alwayson']);
        $block->setVar('placement', $_POST['placement']);
        $block->setVar('fromdate', strtotime($_POST['fromdate']['date']) + $_POST['fromdate']['time']);
        $block->setVar('todate', strtotime($_POST['todate']['date']) + $_POST['todate']['time']);
        $block->setVar('pbcachetime', $_POST['pbcachetime']);
        $block->setVar('cachebyurl', $_POST['cachebyurl']);
        $block->setVar('note', $_POST['note']);
        $block->setVar('groups', $_POST['groups']);

        if ($pageblock_handler->insert($block)) {
            redirect_header('main.php?pageid='.$block->getVar('pageid'), 1, _AM_MYTABS_SUCCESS);
            exit;
        }
        break;

    case "new":
    case "edit":

        xoops_cp_header();
        mytabs_adminmenu(0);

        if ($op == "new") {
            $block = $pageblock_handler->create();
            $block->setVar('pageid', $_REQUEST['pageid']);
            $block->setVar('tabid', $_POST['tabid']);
            $block->setVar('blockid', $_POST['blockid']);
            $block->setVar('fromdate', time());
            $block->setVar('todate', time());
            $block->setBlock($_POST['blockid']);
        } else {
            $block = $pageblock_handler->get($_REQUEST['pageblockid']);
            $block->setBlock();
        }
        $pageid = $block->getVar('pageid');

        echo "<a href=\"main.php\">" . _AM_MYTABS_HOME . "</a>&nbsp;";

        if ($pageid > 0) {
            $page_handler = xoops_getmodulehandler('page');
            $page = $page_handler->get($pageid);
            echo "&raquo;&nbsp;";
            echo "<a href=\"main.php?pageid=" . $pageid . "\">" . $page->getVar("pagetitle") . "</a>";
        }

        $form = $block->getForm();
        echo $form->render();

        xoops_cp_footer();
        break;

    case "delete":
        $obj = $pageblock_handler->get($_REQUEST['pageblockid']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ($pageblock_handler->delete($obj)) {
                redirect_header('main.php?pageid=' . $obj->getVar('pageid'), 3, sprintf(_AM_MYTABS_DELETEDSUCCESS, $obj->getVar('title')));
            } else {
                xoops_cp_header();
                echo implode('<br />', $obj->getErrors());
                xoops_cp_footer();
            }
        } else {
            xoops_cp_header();
            xoops_confirm(array('ok' => 1, 'pageblockid' => $_REQUEST['pageblockid'], 'op' => 'delete'), 'block.php', sprintf(_AM_MYTABS_RUSUREDEL, $obj->getVar('title')));
            xoops_cp_footer();
        }
        break;
}
