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
 * @version         $Id: main.php 0 2009-11-14 18:47:04Z trabis $
 */

//require dirname(__FILE__) . '/header.php';
//include_once 'admin_header.php';
require dirname(__FILE__) . '/admin_header.php';

$pageblock_handler = xoops_getmodulehandler('pageblock');
$tab_handler = xoops_getmodulehandler('tab');
$page_handler = xoops_getmodulehandler('page');

$module_handler = xoops_gethandler('module');

if (isset($_REQUEST['pageid'])){
    $pageid = intval($_REQUEST['pageid']);
} else {
    $criteria = new CriteriaCompo();
    $criteria->setSort('pagetitle');
    $criteria->setOrder('DESC');
    $criteria->setLimit(1);
    $page = $page_handler->getObjects($criteria);
    $pageid = !empty($page) ? $page[0]->getVar('pageid') : 0;
}

$page = $page_handler->get($pageid);

if (sizeof($_POST)>0)
{
    switch($_POST['doaction']) {
        case 'setpriorities':
            if (isset($_POST['pri'])) {
                foreach ($_POST['pri'] as $id => $priority) {
                    $block = $pageblock_handler->get($id);
                    $block->setVar('priority', $priority);
                    $pageblock_handler->insert($block);
                }
            }
            if (isset($_POST['tabpri'])) {
                foreach ($_POST['tabpri'] as $id => $priority) {
                    $tab = $tab_handler->get($id);
                    $tab->setVar('tabpriority', $priority);
                    $tab_handler->insert($tab);
                }
            }
            if (isset($_POST['place'])) {
                foreach ($_POST['place'] as $id => $placement) {
                    $block = $pageblock_handler->get($id);
                    $block->setVar('placement', $placement);
                    $pageblock_handler->insert($block);
                }
            }
            break;
        case 'delete':
            if (isset($_POST['markedblocks'])){
                foreach ($_POST['markedblocks'] as $id) {
                    $block = $pageblock_handler->get($id);
                    $pageblock_handler->delete($block);
                }
            }
            if (isset($_POST['markedtabs'])){
                foreach ($_POST['markedtabs'] as $id) {
                    $tab = $tab_handler->get($id);
                    $tab_handler->delete($tab);
                    $blocks = $pageblock_handler->getObjects(new Criteria('tabid', $id));
                    foreach ($blocks as $block) {
                        $pageblock_handler->delete($block);
                    }
                }
            }
            break;
    }
}
$indexAdmin = new ModuleAdmin();
xoops_cp_header();
echo $indexAdmin->addNavigation('main.php');

$blocks = $pageblock_handler->getBlocks($pageid, 0, '','', false);
$allblocks = $pageblock_handler->getAllBlocks();
$allcustomblocks = $pageblock_handler->getAllCustomBlocks();
$allblocks = $allblocks + $allcustomblocks;

$has_tabs = false;
$tabs_array = array();
$criteria = new Criteria('tabpageid', $pageid);
$criteria->setSort('tabpriority');
$criteria->setOrder('ASC');
$tabs = $tab_handler->getObjects($criteria);
foreach ($tabs as $tab) {
    $tabs_array[$tab->getVar('tabid')]['title'] = $tab->getVar('tabtitle');
    $tabs_array[$tab->getVar('tabid')]['priority'] = $tab->getVar('tabpriority');
    $tabs_array[$tab->getVar('tabid')]['groups'] = $tab->getVar('tabgroups');
    $tabs_array[$tab->getVar('tabid')]['note'] = $tab->getVar('tabnote');
    $tabs_array[$tab->getVar('tabid')]['link'] = $tab->getVar('tablink');
    $tabs_array[$tab->getVar('tabid')]['rev'] = $tab->getVar('tabrev');

    $showalways = $tab->getVar('tabshowalways');
    if ($showalways == 'no') {
        $tabs_array[$tab->getVar('tabid')]['unvisible'] = true;
    } else if ($showalways == 'yes') {
        $tabs_array[$tab->getVar('tabid')]['visible'] = true;
    } else if ($showalways == 'time') {
        $check = $tab->isVisible();
        if ($check) {
            $tabs_array[$tab->getVar('tabid')]['timebased'] = true;
        } else {
            $tabs_array[$tab->getVar('tabid')]['unvisible'] = true;
        }
    }
    $has_tabs = true;
}

$has_blocks = false;
$has_left_blocks = false;
$has_center_blocks = false;
$has_right_blocks = false;
foreach (array_keys($blocks) as $tabid) {
    foreach ($blocks[$tabid] as $block) {
        $blocks_array[$tabid][] = $block->toArray();
        $has_blocks = true;
        $block_placement = $block->getVar('placement');
        if ($block_placement = 'left') $has_left_blocks = true;
        if ($block_placement = 'center') $has_center_blocks = true;
        if ($block_placement = 'right') $has_right_blocks = true;
    }
}

$has_pages = false;
$criteria = new CriteriaCompo();
$criteria->setSort('pagetitle');
$criteria->setOrder('ASC');
$pagelist = $page_handler->getObjects($criteria, true);
foreach (array_keys($pagelist) as $i) {
    $pages[$i] = $pagelist[$i]->getVar('pagetitle');
    $has_pages = true;
}

$has_placements = false;
$placement = '<select name="tabid">';
$tabs = $tab_handler->getObjects(new Criteria('tabpageid', $pageid), false);
foreach ($tabs as $tab) {
    $placement .='<option value="' . $tab->getVar('tabid') . '">' . $tab->getVar('tabtitle') . '</option>';
    $has_placements = true;
}
$placement .='</select>&nbsp;';

$grouplist_handler = xoops_gethandler('group');
$grouplist = $grouplist_handler->getObjects(null, true);

foreach (array_keys($grouplist) as $i) {
    $groups[$i] = $grouplist[$i]->getVar('name');
}

if ($page) {
    $xoopsTpl->assign('pagename', $page->getVar('pagetitle'));
}

if ($has_blocks) {
    $xoopsTpl->assign('blocks', $blocks_array);
    $xoopsTpl->assign('left_blocks',$has_left_blocks);
    $xoopsTpl->assign('center_blocks',$has_center_blocks);
    $xoopsTpl->assign('right_blocks',$has_right_blocks);
}

if ($has_tabs) {
    $xoopsTpl->assign('tabs', $tabs_array);
}

if ($has_placements) {
    $xoopsTpl->assign('placement', $placement);
}

if ($has_pages) {
    $xoopsTpl->assign('pagelist', $pages);
}

$xoopsTpl->assign('pageid', $pageid);
$xoopsTpl->assign('blocklist', $allblocks);
$xoopsTpl->assign('groups', $groups);

$xoopsTpl->display("db:mytabs_admin_page.html");

include "admin_footer.php";
//xoops_cp_footer();
