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

class MytabsPage extends XoopsObject
{
    /**
     * constructor
     */
    public function __construct()
    {
        $this->initVar('pageid', XOBJ_DTYPE_INT);
        $this->initVar('pagetitle', XOBJ_DTYPE_TXTBOX, '');
    }

    /**
     * Get the form for adding or editing pages
     *
     * @return MytabsPageForm
     */
    public function getForm()
    {
        require_once XOOPS_ROOT_PATH . '/modules/mytabs/class/form/page.php';
        $form = new MytabspageForm('Page', 'pageform', 'page.php');
        $form->createElements($this);

        return $form;
    }
}

class MytabsPageHandler extends XoopsPersistableObjectHandler
{
    /**
     * constructor
     * @param XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'mytabs_page', 'MytabsPage', 'pageid', 'pagetitle');
    }
}
