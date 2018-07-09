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
 * @author          The SmartFactory http://www.smartfactory.ca
 */

// defined('XOOPS_ROOT_PATH') || die("XOOPS root path not defined");

/**
 * Class About is a simple class that lets you build an about page
 * @author The SmartFactory <www.smartfactory.ca>
 */
class About
{
    public $_lang_aboutTitle;
    public $_lang_author_info;
    public $_lang_developer_lead;
    public $_lang_developer_contributor;
    public $_lang_developer_website;
    public $_lang_developer_email;
    public $_lang_developer_credits;
    public $_lang_module_info;
    public $_lang_module_status;
    public $_lang_module_release_date;
    public $_lang_module_demo;
    public $_lang_module_support;
    public $_lang_module_bug;
    public $_lang_module_submit_bug;
    public $_lang_module_feature;
    public $_lang_module_submit_feature;
    public $_lang_module_disclaimer;
    public $_lang_author_word;
    public $_lang_version_history;
    public $_lang_by;
    public $_tpl;

    /**
     * About constructor.
     * @param string $aboutTitle
     */
    public function __construct($aboutTitle = 'About')
    {
        xoops_loadLanguage('about', 'mytabs');
        $this->_aboutTitle = $aboutTitle;

        $this->_lang_developer_contributor = _AB_MYTABS_DEVELOPER_CONTRIBUTOR;
        $this->_lang_developer_website     = _AB_MYTABS_DEVELOPER_WEBSITE;
        $this->_lang_developer_email       = _AB_MYTABS_DEVELOPER_EMAIL;
        $this->_lang_developer_credits     = _AB_MYTABS_DEVELOPER_CREDITS;
        $this->_lang_module_info           = _AB_MYTABS_MODULE_INFO;
        $this->_lang_module_status         = _AB_MYTABS_MODULE_STATUS;
        $this->_lang_module_release_date   = _AB_MYTABS_MODULE_RELEASE_DATE;
        $this->_lang_module_demo           = _AB_MYTABS_MODULE_DEMO;
        $this->_lang_module_support        = _AB_MYTABS_MODULE_SUPPORT;
        $this->_lang_module_bug            = _AB_MYTABS_MODULE_BUG;
        $this->_lang_module_submit_bug     = _AB_MYTABS_MODULE_SUBMIT_BUG;
        $this->_lang_module_feature        = _AB_MYTABS_MODULE_FEATURE;
        $this->_lang_module_submit_feature = _AB_MYTABS_MODULE_SUBMIT_FEATURE;
        $this->_lang_module_disclaimer     = _AB_MYTABS_MODULE_DISCLAIMER;
        $this->_lang_author_word           = _AB_MYTABS_AUTHOR_WORD;
        $this->_lang_version_history       = _AB_MYTABS_VERSION_HISTORY;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function sanitize($value)
    {
        $myts = \MyTextSanitizer::getInstance();

        return $myts->displayTarea($value, 1);
    }

    public function render()
    {
        global $xoopsModule;
        /** @var \XoopsModuleHandler $moduleHandler */
        $moduleHandler = xoops_getHandler('module');
        $versioninfo   = $moduleHandler->get($xoopsModule->getVar('mid'));

        $this->_tpl = new \XoopsTpl();
        $this->_tpl->assign('module_url', XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/');
        $this->_tpl->assign('module_image', $versioninfo->getInfo('image'));
        $this->_tpl->assign('module_name', $versioninfo->getInfo('name'));
        $this->_tpl->assign('module_version', $versioninfo->getInfo('version'));
        $this->_tpl->assign('module_status_version', $versioninfo->getInfo('status_version'));

        // Left headings...
        if ('' != $versioninfo->getInfo('author_realname')) {
            $author_name = $versioninfo->getInfo('author') . ' (' . $versioninfo->getInfo('author_realname') . ')';
        } else {
            $author_name = $versioninfo->getInfo('author');
        }
        $this->_tpl->assign('module_author_name', $author_name);
        $this->_tpl->assign('module_license', $versioninfo->getInfo('license'));
        $this->_tpl->assign('module_credits', $versioninfo->getInfo('credits'));

        // Developers Information
        $this->_tpl->assign('module_developer_lead', $versioninfo->getInfo('developer_lead'));
        $this->_tpl->assign('module_developer_contributor', $versioninfo->getInfo('developer_contributor'));
        $this->_tpl->assign('module_developer_website_url', $versioninfo->getInfo('developer_website_url'));
        $this->_tpl->assign('module_developer_website_name', $versioninfo->getInfo('developer_website_name'));
        $this->_tpl->assign('module_developer_email', $versioninfo->getInfo('developer_email'));

        $people = $versioninfo->getInfo('people');
        if ($people) {
            $this->_tpl->assign('module_people_developers', isset($people['developers']) ? array_map([$this, 'sanitize'], $people['developers']) : false);
            $this->_tpl->assign('module_people_testers', isset($people['testers']) ? array_map([$this, 'sanitize'], $people['testers']) : false);
            $this->_tpl->assign('module_people_translaters', isset($people['translaters']) ? array_map([$this, 'sanitize'], $people['translaters']) : false);
            $this->_tpl->assign('module_people_documenters', isset($people['documenters']) ? array_map([$this, 'sanitize'], $people['documenters']) : false);
            $this->_tpl->assign('module_people_other', isset($people['other']) ? array_map([$this, 'sanitize'], $people['other']) : false);
        }
        //$this->_tpl->assign('module_developers', $versioninfo->getInfo('developer_email'));

        // Module Development information
        $this->_tpl->assign('module_date', $versioninfo->getInfo('date'));
        $this->_tpl->assign('module_status', $versioninfo->getInfo('status'));
        $this->_tpl->assign('module_demo_site_url', $versioninfo->getInfo('demo_site_url'));
        $this->_tpl->assign('module_demo_site_name', $versioninfo->getInfo('demo_site_name'));
        $this->_tpl->assign('module_support_site_url', $versioninfo->getInfo('support_site_url'));
        $this->_tpl->assign('module_support_site_name', $versioninfo->getInfo('support_site_name'));
        $this->_tpl->assign('module_submit_bug', $versioninfo->getInfo('submit_bug'));
        $this->_tpl->assign('module_submit_feature', $versioninfo->getInfo('submit_feature'));

        // Warning
        $this->_tpl->assign('module_warning', $this->sanitize($versioninfo->getInfo('warning')));

        // Author's note
        $this->_tpl->assign('module_author_word', $versioninfo->getInfo('author_word'));

        // For changelog thanks to 3Dev
        if (file_exists($file = XOOPS_ROOT_PATH . '/modules/' . $xoopsModule->getVar('dirname') . '/changelog.txt')) {
            $filesize = filesize($file);
            $handle   = fopen($file, 'r');
            $this->_tpl->assign('module_version_history', $this->sanitize(fread($handle, $filesize)));
            fclose($handle);
        }

        $this->_tpl->display('db:mytabs_about.tpl');
    }
}
