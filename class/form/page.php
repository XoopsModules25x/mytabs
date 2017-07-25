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

// defined('XOOPS_ROOT_PATH') || die("XOOPS root path not defined");

require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

class MytabspageForm extends XoopsThemeForm
{
    public function createElements($target)
    {
        $this->addElement(new XoopsFormText(_AM_MYTABS_TITLE, 'pagetitle', 35, 255, $target->getVar('pagetitle', 'e')));

        if (!$target->isNew()) {
            $this->addElement(new XoopsFormHidden('pageid', $target->getVar('pageid')));
        }
        $this->addElement(new XoopsFormHidden('op', 'save'));

        $tray = new XoopsFormElementTray('');
        $tray->addElement(new XoopsFormButton('', 'submit', _AM_MYTABS_OK, 'submit'));

        $cancel = new XoopsFormButton('', 'cancel', _AM_MYTABS_CANCEL, 'button');
        $cancel->setExtra("onclick=\"self.location='main.php?pageid=" . $target->getVar('pageid') . "';\"");
        $tray->addElement($cancel);

        $this->addElement($tray);
    }
}
