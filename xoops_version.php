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

include __DIR__ . '/preloads/autoloader.php';

$modversion['version']       = '2.22';
$modversion['module_status'] = 'Beta 1';
$modversion['release_date']  = '2017/07/23';
$modversion['name']          = _MI_MYTABS_NAME;
$modversion['description']   = _MI_MYTABS_DSC;
$modversion['author']        = 'Trabis (www.xuups.com)';
$modversion['credits']       = 'Michael Wulff Nielsen <naish@klanen.net>(www.smartfactory.ca),  Jan Keller Pedersen <jkp@cusix.dk>(www.smartfactory.ca), Tab Content script v2.2- � Dynamic Drive DHTML code library (www.dynamicdrive.com), Menus from 13Styles (www.13styles.com)';
$modversion['help']          = 'page=help';
$modversion['license']       = 'GNU GPL 2.0 or later';
$modversion['license_url']   = 'www.gnu.org/licenses/gpl-2.0.html';
$modversion['official']      = 0; //1 indicates supported by XOOPS Dev Team, 0 means 3rd party supported
$modversion['image']         = 'assets/images/logoModule.png';
$modversion['dirname']       = basename(__DIR__);
$modversion['modicons16']          = 'assets/images/icons/16';
$modversion['modicons32']          = 'assets/images/icons/32';
$modversion['module_website_url']  = 'www.xoops.org/';
$modversion['module_website_name'] = 'XOOPS';
$modversion['min_php']             = '5.5';
$modversion['min_xoops']           = '2.5.9';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = ['mysql' => '5.5'];

//Database
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][0]        = 'mytabs_page';
$modversion['tables'][1]        = 'mytabs_tab';
$modversion['tables'][2]        = 'mytabs_pageblock';

$modversion['hasMain'] = 0;

//Admin things
$modversion['hasAdmin']    = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';
$modversion['system_menu'] = 1;

// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => _MI_MYTABS_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_MYTABS_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_MYTABS_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_MYTABS_SUPPORT, 'link' => 'page=support'],
];

$modversion['templates'][] = [
    'file'        => 'mytabs_admin_blocks.tpl',
    'description' => ''
];
$modversion['templates'][] = [
    'file'        => 'mytabs_admin_page.tpl',
    'description' => ''
];
$modversion['templates'][] = [
    'file'        => 'mytabs_block.tpl',
    'description' => ''
];
$modversion['templates'][] = [
    'file'        => 'mytabs_index.tpl',
    'description' => ''
];
$modversion['templates'][] = [
    'file'        => 'mytabs_about.tpl',
    'description' => ''
];

//Blocks
$modversion['blocks'][1]['file']        = 'mytabs_block.php';
$modversion['blocks'][1]['name']        = _MI_MYATBS_BNAME1;
$modversion['blocks'][1]['description'] = 'Shows dynamic content tab';
$modversion['blocks'][1]['show_func']   = 'b_mytabs_block_show';
$modversion['blocks'][1]['edit_func']   = 'b_mytabs_block_edit';
$modversion['blocks'][1]['options']     = '|0|400|mytabsdefault|true|2000||1|0|false';
$modversion['blocks'][1]['template']    = 'mytabs_block_blocks.tpl';

// About stuff
$modversion['status_version']         = 'Final';
$modversion['developer_website_url']  = 'http://www.xuups.com';
$modversion['developer_website_name'] = 'Xuups';
$modversion['developer_email']        = 'lusopoemas@gmail.com';
$modversion['status']                 = 'Final';
$modversion['date']                   = '14/11/2009';

$modversion['people']['developers'][] = 'Trabis, Mowaffak, Gopala, Bedu�no';

$modversion['people']['testers'][] = 'xoopsbr.org Team, X-Trad.org Team, impresscms.org Team, xoops.org Team, YOU!';

$modversion['people']['translaters'][] = 'flymirco(italian)';
$modversion['people']['translaters'][] = 'voltan(persian)';
$modversion['people']['translaters'][] = 'Gibaphp(portuguesebr)';
$modversion['people']['translaters'][] = 'kris_fr(french)';
$modversion['people']['translaters'][] = 'wuddel(german)';
$modversion['people']['translaters'][] = 'almjd(arabic)';

$modversion['people']['documenters'][] = "mamba - <a href='https://xoops.org/uploads/tutorials/MyTabsTutorial.pdf' target='_blank'>Quick Tutorial</a>(english version) ";
$modversion['people']['documenters'][] = "Burning - <a href='http://internap.dl.sourceforge.net/sourceforge/xoops/xoops2_docu_module-mytabs2.pdf' target='_blank'>Full Tutorial</a> (english version)";
//$modversion['people']['other'][] = "";

$modversion['demo_site_url']     = 'http://www.xuups.com';
$modversion['demo_site_name']    = 'Xuups.com';
$modversion['support_site_url']  = 'http://www.xuups.com/modules/newbb';
$modversion['support_site_name'] = 'Xuups Support Forums';
$modversion['submit_bug']        = 'http://www.xuups.com/modules/newbb';
$modversion['submit_feature']    = 'http://www.xuups.com/modules/newbb';

$modversion['author_word'] = 'I want to dedicated this module to Gopala, the owner of this idea and first lines of code.';
//$modversion['warning'] = "";
