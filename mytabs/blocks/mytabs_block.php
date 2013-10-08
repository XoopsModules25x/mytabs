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
 * @version         $Id: mytabs_block.php 0 2009-11-14 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

function b_mytabs_block_show($options)
{
    global $xoTheme, $xoopsTpl;
    $block = array();
    $vistabs = array();
    static $alluniqueids = array();
    if (in_array($options[6],$alluniqueids)) {
        return array();
    } else {
        $alluniqueids[] = $options[6];
    }

    $pageid = $options[0];

    include_once XOOPS_ROOT_PATH . '/modules/mytabs/include/functions.php';

    $tab_handler = xoops_getmodulehandler('tab','mytabs');
    $criteria = new Criteria('tabpageid', $pageid);
    $criteria->setSort('tabpriority');
    $criteria->setOrder('ASC');
    $tabs = $tab_handler->getObjects($criteria);

    if (count($tabs) == 0) return $block;

    $groups = $GLOBALS['xoopsUser'] ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

    foreach ($tabs as $tab) {
        if ($tab->isVisible() && array_intersect($tab->getVar('tabgroups'), $groups)) {
            $vistabs[] = $tab;
        }
    }

    $tabsmenu = '<ul class="tabs-nav">';
    $selected = ' class="tabs-selected"';
    $hascontent = false;
    $hasmenu = false;
    $i = 0;
    foreach ($vistabs as $tab){
        $placements = array();
        $width = 0;
        $block['tabs'][$i]['id'] = $tab->getVar('tabid');
        $tab_blocks = mytabs_blockShow($pageid, $tab->getVar('tabid'), '', $options[6]);

        foreach ($tab_blocks as $thisblock) {
            $block['tabs'][$i][$thisblock['placement']][] = $thisblock;
            $placements[$thisblock['placement']] = true;
        }

        $count = count($placements);
        $block['tabs'][$i]['width'] = ($count != 0) ? intval(100 / $count) : 100;

        //for the menu
        $link = $tab->getTabLink();
        $title = $tab->getTabTitle();
        $rev = $tab->getVar('tabrev');

        if ($count != 0 || ($count == 0 && ($link != '' || $rev != ''))) {
            $link = ($link != '') ? $link : '#';
            $rev = ($rev != '') ? ' rev="' . $rev . '" ' : '';
            $rel = ' rel="tab-' . $tab->getVar('tabid') . '-' . $options[6] . '"';
            $tabsmenu .= '<li><a href="' . $link.'"' . $rel . $rev . $selected . '><span>' . $title . '</span></a></li>';
            $selected = '';
            $hasmenu = true;
        }

        $i++;
    }

    if (!$hasmenu) {
        return array();
    }

    $tabsmenu .= '</ul><br style="clear: left" />';

    $block['tabsmenu'] = $tabsmenu;
    $block['width'] = $options[1];
    $block['height'] = $options[2];
    $options[3] = file_exists(XOOPS_ROOT_PATH.'/modules/mytabs/menus/' . $options[3] . '/style.css') ? $options[3]: 'mytabsdefault';
    $block['class'] = $options[3];
    $block['persist'] = $options[4];
    $block['milisec'] = $options[5];
    $block['uniqueid'] = $options[6];
    $block['showblockstitle'] = $options[7];
    $block['onmouseover'] = $options[8];
    $block['hidetabs'] = $options[9];
    $block['placements'] = array('left', 'center', 'right');

    $xoTheme->addStylesheet(XOOPS_URL . '/modules/mytabs/menus/' . $options[3] . '/style.css');
    $xoTheme->addScript(XOOPS_URL . '/modules/mytabs/jscript/tabcontent.js');

    return $block;
}

function b_mytabs_block_edit($options)
{
    if (!$options[6] || (isset($_GET['op']) && $_GET['op'] == 'clone')) $options[6] = time();
    $criteria = new CriteriaCompo();
    $criteria->setSort('pagetitle');
    $criteria->setOrder('ASC');
    $page_handler = xoops_getmodulehandler('page', 'mytabs');
    $pages = $page_handler->getObjects($criteria);
    if(!$pages) {
        $form = "<a href='" . XOOPS_URL . "/modules/mytabs/admin/main.php'>" . _MB_MYTABS_CREATEPAGEFIRST . "</a>";
        return $form;
    }

    $form = "<b>" . _MB_MYTABS_PAGE . "</b>&nbsp;<select name='options[0]'>";
    foreach ($pages as $page){
        $form .= "<option value='" . $page->getVar('pageid') . "'";
        if ($options[0] == $page->getVar('pageid')) {
            $form .= " selected='selected'";
        }
        $form .= '>' . $page->getVar('pagetitle') . "</option>\n";
    }
    $form .= "</select>\n<br /><br />";

    $form .= "<b>" . _MB_MYTABS_WIDTH . "</b>&nbsp;<input type='text' name='options[1]' value='" . $options[1] . "'/>&nbsp;&nbsp;<i>" . _MB_MYTABS_WIDTH_DSC . "</i><br /><br />";
    $form .= "<b>" . _MB_MYTABS_HEIGHT . "</b>&nbsp;<input type='text' name='options[2]' value='" . $options[2] . "'/>&nbsp;&nbsp;<i>" . _MB_MYTABS_HEIGHT_DSC . "</i><br /><br />";

    include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
    $menus = XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . '/modules/mytabs/menus/', '');
    $form .= "<b>" . _MB_MYTABS_CLASS . "</b>&nbsp;<select name='options[3]'>";
    foreach ($menus as $menu){
        if (file_exists(XOOPS_ROOT_PATH . '/modules/mytabs/menus/' . $menu . '/style.css')) {
            $form .= "<option value='".$menu."'";
            if ($options[3] == $menu) {
                $form .= " selected='selected'";
            }
            $form .= '>'.$menu."</option>\n";
        }
    }
    $form .= "</select>\n&nbsp;&nbsp;<i>" . _MB_MYTABS_CLASS_DSC . "</i><br /><br />";

    $form .= "<b>" . _MB_MYTABS_PERSIST . "</b>&nbsp;<input type='radio' name='options[4]' value='true'";
    if ($options[4] == 'true') {
        $form .= " checked='checked'";
    }
    $form .= ' />' . _YES;
    $form .= "<input type='radio' name='options[4]' value='false'";
    if ($options[4] == 'false') {
        $form .= " checked='checked'";
    }
    $form .= ' />' . _NO.'&nbsp;&nbsp;<i>' . _MB_MYTABS_PERSIST_DSC . '</i><br /><br />';

    $form .= "<b>" . _MB_MYTABS_MILISEC . "</b>&nbsp;<input type='text' name='options[5]' value='" . $options[5] . "'/>&nbsp;&nbsp;<i>" . _MB_MYTABS_MILISEC_DSC . "</i><br /><br />";

    $form .= "<b>" . _MB_MYTABS_UNIQUEID . "</b>&nbsp;<input type='text' name='options[6]' value='" . $options[6] . "'/>&nbsp;&nbsp;<i>" . _MB_MYTABS_UNIQUEID_DSC . "</i><br /><br />";

    $form .= "<b>" . _MB_MYTABS_BLOCKSTITLE . "</b>&nbsp;<input type='radio' name='options[7]' value='1'";
    if ($options[7] == '1') {
        $form .= " checked='checked'";
    }
    $form .= ' />'._YES;
    $form .= "<input type='radio' name='options[7]' value='0'";
    if ($options[7] == '0') {
        $form .= " checked='checked'";
    }
    $form .= ' />' . _NO . '&nbsp;&nbsp;<i>' . _MB_MYTABS_BLOCKSTITLE_DSC . '</i><br /><br />';

    $form .= "<b>". _MB_MYTABS_ONMOUSEOVER . "</b>&nbsp;<input type='radio' name='options[8]' value='1'";
    if ($options[8] == '1') {
        $form .= " checked='checked'";
    }
    $form .= ' />' . _YES;
    $form .= "<input type='radio' name='options[8]' value='0'";
    if ($options[8] == '0') {
        $form .= " checked='checked'";
    }
    $form .= ' />' . _NO . '&nbsp;&nbsp;<i>' . _MB_MYTABS_ONMOUSEOVER_DSC . '</i><br /><br />';

    $form .= "<b>" . _MB_MYTABS_HIDETABS . "</b>&nbsp;<input type='radio' name='options[9]' value='true'";
    if (!isset($options[9])) $options[9] = 'false';
    if ($options[9] == 'true') {
        $form .= " checked='checked'";
    }
    $form .= ' />' . _YES;
    $form .= "<input type='radio' name='options[9]' value='false'";
    if ($options[9] == 'false') {
        $form .= " checked='checked'";
    }
    $form .= ' />' . _NO . '&nbsp;&nbsp;<i>' . _MB_MYTABS_HIDETABS_DSC . '</i><br /><br />';

    return $form;
}
?>