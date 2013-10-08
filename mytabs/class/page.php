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
 * @version         $Id: page.php 0 2009-11-14 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

class MytabsPage extends XoopsObject
{
    /**
     * constructor
     */
    function __construct()
    {
        $this->initVar("pageid", XOBJ_DTYPE_INT);
        $this->initVar('pagetitle', XOBJ_DTYPE_TXTBOX, '');
    }
    /**
     * Get the form for adding or editing pages
     *
     * @return MytabsPageForm
     */
    function getForm()
    {
        include_once XOOPS_ROOT_PATH . '/modules/mytabs/class/form/page.php';
        $form = new MytabsPageForm('Page', 'pageform', 'page.php');
        $form->createElements($this);
        return $form;
    }
}

class MytabsPageHandler extends XoopsPersistableObjectHandler
{
    /**
     * constructor
     */
    function __construct(&$db)
    {
        parent::__construct($db, "mytabs_page", 'MytabsPage', "pageid", "pagetitle");
    }
}
?>