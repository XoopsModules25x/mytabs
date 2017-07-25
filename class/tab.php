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
 * @version         $Id: tab.php 0 2009-11-14 18:47:04Z trabis $
 */

class MytabsTab extends XoopsObject
{
    /**
     * constructor
     */
    function __construct()
    {
        $this->initVar("tabid", XOBJ_DTYPE_INT);
        $this->initVar("tabpageid", XOBJ_DTYPE_INT);
        $this->initVar('tabtitle', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('tablink', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('tabrev', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar("tabpriority", XOBJ_DTYPE_INT,0);
        $this->initVar('tabshowalways', XOBJ_DTYPE_TXTBOX, 'yes');
        $this->initVar('tabfromdate', XOBJ_DTYPE_INT);
        $this->initVar('tabtodate', XOBJ_DTYPE_INT);
        $this->initVar('tabnote', XOBJ_DTYPE_TXTAREA, '');
        $this->initVar('tabgroups', XOBJ_DTYPE_ARRAY, serialize(array(XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_USERS)));
    }

    /**
     * Return whether this block is visible now
     *
     * @return bool
     */
    function isVisible()
    {
        return ($this->getVar('tabshowalways') == "yes" || ($this->getVar('tabshowalways') == "time" && $this->getVar('tabfromdate') <= time() && $this->getVar('tabtodate') >= time()));
    }

    /**
     * Get the form for adding or editing tabs
     *
     * @return MytabsTabForm
     */
    function getForm()
    {
        include_once XOOPS_ROOT_PATH . '/modules/mytabs/class/form/tab.php';
        $form = new MytabsTabForm('Tab', 'tabform', 'tab.php');
        $form->createElements($this);

        return $form;
    }

    function getTabTitle()
    {
        $title = $this->getVar('tabtitle');

        // PM detection and conversion
        if (preg_match('/{pm_new}/i', $title)
        || preg_match('/{pm_readed}/i', $title)
        || preg_match('/{pm_total}/i', $title)
        ) {
            if (is_object($GLOBALS['xoopsUser'])) {
                $new_messages = 0;
                $old_messages = 0;
                $som = 0;
                $user_id = 0;
                $user_id = $GLOBALS['xoopsUser']->getVar('uid');
                $pm_handler =& xoops_gethandler('privmessage');
                $criteria_new = new CriteriaCompo(new Criteria('read_msg', 0));
                $criteria_new->add(new Criteria('to_userid', $GLOBALS['xoopsUser']->getVar('uid')));
                $new_messages = $pm_handler->getCount($criteria_new);
                $criteria_old = new CriteriaCompo(new Criteria('read_msg', 1));
                $criteria_old->add(new Criteria('to_userid', $GLOBALS['xoopsUser']->getVar('uid')));
                $old_messages = $pm_handler->getCount($criteria_old);
                $som =  $old_messages +  $new_messages;
                if ($new_messages > 0) {
                    $title = preg_replace('/\{pm_new\}/',    '(<span style="color: rgb(255, 0, 0); font-weight: bold;">'.$new_messages.'</span>)', $title);
                }
                if ($old_messages > 0) {
                    $title = preg_replace('/\{pm_readed\}/', '(<span style="color: rgb(255, 0, 0); font-weight: bold;">'.$old_messages.'</span>)', $title);
                }
                if ($old_messages > 0) {
                    $title = preg_replace('/\{pm_total\}/',  '(<span style="color: rgb(255, 0, 0); font-weight: bold;">'.$som.'</span>)'         , $title);
                }
            }
            $title = preg_replace('/\{pm_new\}/',    '', $title);
            $title = preg_replace('/\{pm_readed\}/', '', $title);
            $title = preg_replace('/\{pm_total\}/',  '', $title);
        }

        return trim($title);
    }

    function getTabLink()
    {
        $link = $this->getVar('tablink');
        if ($link == '') return $link;

        $user_id = $GLOBALS['xoopsUser'] ? $GLOBALS['xoopsUser']->getVar('uid') : 0;
        // Link type, taken from multimenu module
        if ((preg_match("/mailto:/i", $link))  ||
        (preg_match("#http://#i", $link))  ||
        (preg_match("#https://#i", $link)) ||
        (preg_match("#file://#i", $link))  ||
        (preg_match("#ftp://#i", $link))){

            $link = preg_replace('/\{user_id\}/', $user_id, $link);
        } else {
            $link = XOOPS_URL."/".$link;
            $link = preg_replace('/\{user_id\}/', $user_id, $link);
        }

        return $link;
    }

}

class MytabsTabHandler extends XoopsPersistableObjectHandler
{
    /**
     * constructor
     */
    function __construct(&$db)
    {
        parent::__construct($db, "mytabs_tab", 'MytabsTab', "tabid", "tabtitle");
    }
}
