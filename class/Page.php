<?php namespace XoopsModules\Mytabs;

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

use XoopsModules\Mytabs;

// defined('XOOPS_ROOT_PATH') || die("XOOPS root path not defined");

/**
 * Class Page
 * @package XoopsModules\Mytabs
 */
class Page extends \XoopsObject
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
     * @return Mytabs\Form\PageForm
     */
    public function getForm()
    {
//        require_once XOOPS_ROOT_PATH . '/modules/mytabs/class/form/page.php';
        $form = new Mytabs\Form\PageForm('Page', 'pageform', 'page.php');
        $form->createElements($this);

        return $form;
    }
}
