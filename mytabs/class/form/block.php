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

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

class MytabsBlockForm extends XoopsThemeForm
{
    function createElements($target)
    {

        if ($target->isNew()) {
            $this->addElement(new XoopsFormText(_AM_MYTABS_TITLE, 'title', 35, 255, $target->block->getVar('title', 'e')));
        } else {
            $this->addElement(new XoopsFormText(_AM_MYTABS_TITLE, 'title', 35, 255, $target->getVar('title', 'e')));
        }

        $options = $target->block->getOptions();
        if ($options) {
            $this->addElement(new XoopsFormLabel(_AM_MYTABS_OPTIONS, $options));
        }

        // DATE
        $this->addElement(new XoopsFormDateTime(_AM_MYTABS_PUBLISHDATE, 'fromdate', 15, $target->getVar('fromdate', 'e')));
        $this->addElement(new XoopsFormDateTime(_AM_MYTABS_ENDDATE, 'todate', 15, $target->getVar('todate', 'e')));

        $always_select = new XoopsFormSelect(_AM_MYTABS_ALWAYSSHOW.":","alwayson",$target->getVar('showalways', 'e'));
        $always_select->addOption("yes",_AM_MYTABS_ALWAYS);
        $always_select->addOption("time",_AM_MYTABS_TIMEBASED);
        $always_select->addOption("no",_AM_MYTABS_OFF);
        $this->addElement($always_select);

        $placement = new XoopsFormSelect(_AM_MYTABS_PLACEMENT.":","tabid",$target->getVar('tabid', 'e'));
        $tab_handler = xoops_getmodulehandler('tab');
        $tabs = $tab_handler->getObjects(new Criteria('tabpageid', $target->getVar('pageid')));
        foreach ($tabs as $tab){
            $placement->addOption($tab->getVar('tabid'),$tab->getVar('tabtitle'));
        }
        $this->addElement($placement);

        $block_placement = new XoopsFormSelect(_AM_MYTABS_BLOCK_PLACEMENT . ":", "placement", $target->getVar('placement', 'e'));
        $block_placement->addOption("left", _AM_MYTABS_LEFT);
        $block_placement->addOption("center", _AM_MYTABS_CENTER);
        $block_placement->addOption("right", _AM_MYTABS_RIGHT);
        $this->addElement($block_placement);

        $this->addElement(new XoopsFormText(_AM_MYTABS_PRIORITY . ":", "priority", 4, 5, $target->getVar('priority', 'e')));

        $cachetime = new XoopsFormSelect(_AM_MYTABS_CACHETIME, 'pbcachetime', $target->getVar('pbcachetime', 'e'));
        $cache_options = array('0' => _NOCACHE,
                               '30' => sprintf(_SECONDS, 30),
                               '60' => _MINUTE,
                               '300' => sprintf(_MINUTES, 5),
                               '1800' => sprintf(_MINUTES, 30),
                               '3600' => _HOUR,
                               '18000' => sprintf(_HOURS, 5),
                               '86400' => _DAY,
                               '259200' => sprintf(_DAYS, 3),
                               '604800' => _WEEK
        );
        $cachetime->addOptionArray($cache_options);
        $this->addElement($cachetime);
        $this->addElement(new XoopsFormRadioYN(_AM_MYTABS_CACHEBYURL, 'cachebyurl', $target->getVar('cachebyurl', 'e')));

        $note = new XoopsFormText(_AM_MYTABS_NOTE . ":","note",50, 255, $target->getVar('note', 'e'));
        $this->addElement($note);

        $this->addElement(new XoopsFormSelectGroup(_AM_MYTABS_GROUPS, 'groups', true, $target->getVar('groups'), 8, true));

        if (!$target->isNew()) {
            $this->addElement(new XoopsFormHidden("pageblockid", $target->getVar('pageblockid')));
        }

        $this->addElement(new XoopsFormHidden("blockid", $target->getVar('blockid')));
        $this->addElement(new XoopsFormHidden("pageid", $target->getVar('pageid')));
        $this->addElement(new XoopsFormHidden("op", "save"));

        $tray = new XoopsFormElementTray("");
        $tray->addElement(new XoopsFormButton("", "submit", _AM_MYTABS_OK, "submit"));

        $cancel = new XoopsFormButton("","cancel", _AM_MYTABS_CANCEL, "button");
        $cancel->setExtra("onclick=\"self.location='main.php?pageid=" . $target->getVar('pageid') . "';\"");
        $tray->addElement($cancel);

        $this->addElement($tray);
    }
}
