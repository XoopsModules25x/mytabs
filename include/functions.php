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
 * @version         $Id: functions.php 0 2009-11-14 18:47:04Z trabis $
 */
defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

function mytabs_blockShow($pageid, $tabid, $placement = '', $remove = '')
{
    $block = array();
    $visblocks = array();

    $blocks_handler = xoops_getmodulehandler('pageblock', 'mytabs');
    $blocks = $blocks_handler->getBlocks($pageid, $tabid, $placement, $remove);

    $groups = $GLOBALS['xoopsUser'] ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

    foreach (array_keys($blocks) as $key) {
        foreach ($blocks[$key] as $thisblock) {
            if ($thisblock->isVisible() && array_intersect($thisblock->getVar('groups'), $groups)) {
                $visblocks[] = $thisblock;
            }
        }
    }

    $count = count($visblocks);

    for ($i = 0; $i < $count; $i++) {
        $logger_name = $visblocks[$i]->getVar('title') . "(" . $visblocks[$i]->getVar('pageblockid') . ")";
        $GLOBALS['xoopsLogger']->startTime($logger_name);
        $thisblock = $visblocks[$i]->render($GLOBALS['xoopsTpl'], $tabid . '_' . $visblocks[$i]->getVar('pageblockid'));
        if ($thisblock != false) {
            if (strlen($thisblock['title']) > 0){
                if ($thisblock['title'][0] == '-') {
                    $thisblock['title'] = '';
                }
            }
            $block[] = $thisblock;
        }
        $GLOBALS['xoopsLogger']->stopTime($logger_name);

    }

    return $block;
}
