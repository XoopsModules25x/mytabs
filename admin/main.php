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

//require_once __DIR__ . '/header.php';
//require_once __DIR__ . '/admin_header.php';
require_once __DIR__ . '/admin_header.php';

$pageblockHandler = xoops_getModuleHandler('pageblock');
$tabHandler       = xoops_getModuleHandler('tab');
$pageHandler      = xoops_getModuleHandler('page');

$moduleHandler = xoops_getHandler('module');

if (isset($_REQUEST['pageid'])) {
    $pageid = (int)$_REQUEST['pageid'];
} else {
    $criteria = new CriteriaCompo();
    $criteria->setSort('pagetitle');
    $criteria->setOrder('DESC');
    $criteria->setLimit(1);
    $page   = $pageHandler->getObjects($criteria);
    $pageid = !empty($page) ? $page[0]->getVar('pageid') : 0;
}

$page = $pageHandler->get($pageid);

if (count($_POST) > 0) {
    switch ($_POST['doaction']) {
        case 'setpriorities':
            if (isset($_POST['pri'])) {
                foreach ($_POST['pri'] as $id => $priority) {
                    $block = $pageblockHandler->get($id);
                    $block->setVar('priority', $priority);
                    $pageblockHandler->insert($block);
                }
            }
            if (isset($_POST['tabpri'])) {
                foreach ($_POST['tabpri'] as $id => $priority) {
                    $tab = $tabHandler->get($id);
                    $tab->setVar('tabpriority', $priority);
                    $tabHandler->insert($tab);
                }
            }
            if (isset($_POST['place'])) {
                foreach ($_POST['place'] as $id => $placement) {
                    $block = $pageblockHandler->get($id);
                    $block->setVar('placement', $placement);
                    $pageblockHandler->insert($block);
                }
            }
            break;
        case 'delete':
            if (isset($_POST['markedblocks'])) {
                foreach ($_POST['markedblocks'] as $id) {
                    $block = $pageblockHandler->get($id);
                    $pageblockHandler->delete($block);
                }
            }
            if (isset($_POST['markedtabs'])) {
                foreach ($_POST['markedtabs'] as $id) {
                    $tab = $tabHandler->get($id);
                    $tabHandler->delete($tab);
                    $blocks = $pageblockHandler->getObjects(new Criteria('tabid', $id));
                    foreach ($blocks as $block) {
                        $pageblockHandler->delete($block);
                    }
                }
            }
            break;
    }
}
$adminObject = \Xmf\Module\Admin::getInstance();
xoops_cp_header();
$adminObject->displayNavigation(basename(__FILE__));

$blocks          = $pageblockHandler->getBlocks($pageid, 0, '', '', false);
$allblocks       = $pageblockHandler->getAllBlocks();
$allcustomblocks = $pageblockHandler->getAllCustomBlocks();
$allblocks       = $allblocks + $allcustomblocks;

$has_tabs   = false;
$tabs_array = array();
$criteria   = new Criteria('tabpageid', $pageid);
$criteria->setSort('tabpriority');
$criteria->setOrder('ASC');
$tabs = $tabHandler->getObjects($criteria);
foreach ($tabs as $tab) {
    $tabs_array[$tab->getVar('tabid')]['title']    = $tab->getVar('tabtitle');
    $tabs_array[$tab->getVar('tabid')]['priority'] = $tab->getVar('tabpriority');
    $tabs_array[$tab->getVar('tabid')]['groups']   = $tab->getVar('tabgroups');
    $tabs_array[$tab->getVar('tabid')]['note']     = $tab->getVar('tabnote');
    $tabs_array[$tab->getVar('tabid')]['link']     = $tab->getVar('tablink');
    $tabs_array[$tab->getVar('tabid')]['rev']      = $tab->getVar('tabrev');

    $showalways = $tab->getVar('tabshowalways');
    if ($showalways == 'no') {
        $tabs_array[$tab->getVar('tabid')]['unvisible'] = true;
    } elseif ($showalways == 'yes') {
        $tabs_array[$tab->getVar('tabid')]['visible'] = true;
    } elseif ($showalways == 'time') {
        $check = $tab->isVisible();
        if ($check) {
            $tabs_array[$tab->getVar('tabid')]['timebased'] = true;
        } else {
            $tabs_array[$tab->getVar('tabid')]['unvisible'] = true;
        }
    }
    $has_tabs = true;
}

$has_blocks        = false;
$has_left_blocks   = false;
$has_center_blocks = false;
$has_right_blocks  = false;
foreach (array_keys($blocks) as $tabid) {
    foreach ($blocks[$tabid] as $block) {
        $blocks_array[$tabid][] = $block->toArray();
        $has_blocks             = true;
        $block_placement        = $block->getVar('placement');
        if ($block_placement = 'left') {
            $has_left_blocks = true;
        }
        if ($block_placement = 'center') {
            $has_center_blocks = true;
        }
        if ($block_placement = 'right') {
            $has_right_blocks = true;
        }
    }
}

$has_pages = false;
$criteria  = new CriteriaCompo();
$criteria->setSort('pagetitle');
$criteria->setOrder('ASC');
$pagelist = $pageHandler->getObjects($criteria, true);
foreach (array_keys($pagelist) as $i) {
    $pages[$i] = $pagelist[$i]->getVar('pagetitle');
    $has_pages = true;
}

$has_placements = false;
$placement      = '<select name="tabid">';
$tabs           = $tabHandler->getObjects(new Criteria('tabpageid', $pageid), false);
foreach ($tabs as $tab) {
    $placement      .= '<option value="' . $tab->getVar('tabid') . '">' . $tab->getVar('tabtitle') . '</option>';
    $has_placements = true;
}
$placement .= '</select>&nbsp;';

$grouplistHandler = xoops_getHandler('group');
$grouplist        = $grouplistHandler->getObjects(null, true);

foreach (array_keys($grouplist) as $i) {
    $groups[$i] = $grouplist[$i]->getVar('name');
}

if ($page) {
    $xoopsTpl->assign('pagename', $page->getVar('pagetitle'));
}

if ($has_blocks) {
    $xoopsTpl->assign('blocks', $blocks_array);
    $xoopsTpl->assign('left_blocks', $has_left_blocks);
    $xoopsTpl->assign('center_blocks', $has_center_blocks);
    $xoopsTpl->assign('right_blocks', $has_right_blocks);
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

$xoopsTpl->display('db:mytabs_admin_page.tpl');

require_once __DIR__ . '/admin_footer.php';
//xoops_cp_footer();
