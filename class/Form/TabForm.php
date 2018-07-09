<?php namespace XoopsModules\Mytabs\Form;

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

// defined('XOOPS_ROOT_PATH') || die("XOOPS root path not defined");

require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

/**
 * Class TabForm
 * @package XoopsModules\Mytabs\Form
 */
class TabForm extends \XoopsThemeForm
{
    /**
     * @param $target
     */
    public function createElements($target)
    {
        $this->addElement(new \XoopsFormText(_AM_MYTABS_TITLE, 'tabtitle', 35, 255, $target->getVar('tabtitle', 'e')));

        $this->addElement(new \XoopsFormDateTime(_AM_MYTABS_PUBLISHDATE, 'tabfromdate', 15, $target->getVar('tabfromdate', 'e')));

        $this->addElement(new \XoopsFormDateTime(_AM_MYTABS_ENDDATE, 'tabtodate', 15, $target->getVar('tabtodate', 'e')));

        $always_select = new \XoopsFormSelect(_AM_MYTABS_ALWAYSSHOW . ':', 'tabalwayson', $target->getVar('tabshowalways', 'e'));
        $always_select->addOption('yes', _AM_MYTABS_ALWAYS);
        $always_select->addOption('time', _AM_MYTABS_TIMEBASED);
        $always_select->addOption('no', _AM_MYTABS_OFF);
        $this->addElement($always_select);

        $this->addElement(new \XoopsFormText(_AM_MYTABS_PRIORITY . ':', 'tabpriority', 4, 5, $target->getVar('tabpriority', 'e')));

        $note = new \XoopsFormText(_AM_MYTABS_NOTE . ':', 'tabnote', 50, 255, $target->getVar('tabnote', 'e'));
        $this->addElement($note);

        $this->addElement(new \XoopsFormSelectGroup(_AM_MYTABS_GROUPS, 'tabgroups', true, $target->getVar('tabgroups'), 8, true));

        $link = new \XoopsFormText(_AM_MYTABS_LINK . ':', 'tablink', 50, 255, $target->getVar('tablink', 'e'));
        $this->addElement($link);

        $rev = new \XoopsFormText(_AM_MYTABS_REV . ':', 'tabrev', 50, 255, $target->getVar('tabrev', 'e'));
        $this->addElement($rev);

        if (!$target->isNew()) {
            $this->addElement(new \XoopsFormHidden('tabid', $target->getVar('tabid')));
        }

        $this->addElement(new \XoopsFormHidden('tabpageid', $target->getVar('tabpageid')));
        $this->addElement(new \XoopsFormHidden('op', 'save'));

        $tray = new \XoopsFormElementTray('');
        $tray->addElement(new \XoopsFormButton('', 'submit', _AM_MYTABS_OK, 'submit'));

        $cancel = new \XoopsFormButton('', 'cancel', _AM_MYTABS_CANCEL, 'button');
        $cancel->setExtra("onclick=\"self.location='main.php?pageid=" . $target->getVar('tabpageid') . "';\"");
        $tray->addElement($cancel);

        $this->addElement($tray);
    }
}
