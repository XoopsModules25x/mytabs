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
 * @version         $Id: xoops_version.php 0 2009-11-14 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

$modversion['name'] = _MI_MYTABS_NAME;
$modversion['description'] = _MI_MYTABS_DSC;
$modversion['version'] = '2.21';
$modversion['author'] = "Trabis (www.xuups.com)";
$modversion['credits'] = "Michael Wulff Nielsen <naish@klanen.net>(www.smartfactory.ca),  Jan Keller Pedersen <jkp@cusix.dk>(www.smartfactory.ca), Tab Content script v2.2- © Dynamic Drive DHTML code library (www.dynamicdrive.com), Menus from 13Styles (www.13styles.com)";
$modversion['help'] = 'page=help';
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/mytabs_slogo.png";
$modversion['dirname'] = "mytabs";
$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['icons16'] = '../../Frameworks/moduleclasses/icons/16';
$modversion['icons32'] = '../../Frameworks/moduleclasses/icons/32';

//about
$modversion['release_date']     = '2011/11/25';
$modversion["module_website_url"] = "www.xoops.org/";
$modversion["module_website_name"] = "XOOPS";
$modversion["module_status"] = "Final";
$modversion['min_php']='5.2';
$modversion['min_xoops']="2.5.5";
$modversion['min_admin']='1.1';
$modversion['min_db']= array('mysql'=>'5.0.7', 'mysqli'=>'5.0.7');

//Database
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "mytabs_page";
$modversion['tables'][1] = "mytabs_tab";
$modversion['tables'][2] = "mytabs_pageblock";

$modversion['hasMain'] = 0;

//Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";
$modversion['system_menu'] = 1;

$modversion['templates'][] = array('file' => "mytabs_admin_blocks.html",
                                   'description' => "");
$modversion['templates'][] = array('file' => "mytabs_admin_page.html",
                                   'description' => "");
$modversion['templates'][] = array('file' => "mytabs_block.html",
                                   'description' => "");
$modversion['templates'][] = array('file' => "mytabs_index.html",
                                   'description' => "");
$modversion['templates'][] = array('file' => "mytabs_about.html",
                                   'description' => "");

//Blocks
$modversion['blocks'][1]['file'] = "mytabs_block.php";
$modversion['blocks'][1]['name'] = _MI_MYATBS_BNAME1;
$modversion['blocks'][1]['description'] = "Shows dynamic content tab";
$modversion['blocks'][1]['show_func'] = "b_mytabs_block_show";
$modversion['blocks'][1]['edit_func'] = "b_mytabs_block_edit";
$modversion['blocks'][1]['options'] = "|0|400|mytabsdefault|true|2000||1|0|false";
$modversion['blocks'][1]['template'] = 'mytabs_block_blocks.html';

// About stuff
$modversion['status_version'] = "Final";
$modversion['developer_website_url'] = "http://www.xuups.com";
$modversion['developer_website_name'] = "Xuups";
$modversion['developer_email'] = "lusopoemas@gmail.com";
$modversion['status'] = "Final";
$modversion['date'] = "14/11/2009";

$modversion['people']['developers'][] = "Trabis, Mowaffak, Gopala, Beduíno";

$modversion['people']['testers'][] = "xoopsbr.org Team, X-Trad.org Team, impresscms.org Team, xoops.org Team, YOU!";

$modversion['people']['translaters'][] = "flymirco(italian)";
$modversion['people']['translaters'][] = "voltan(persian)";
$modversion['people']['translaters'][] = "Gibaphp(portuguesebr)";
$modversion['people']['translaters'][] = "kris_fr(french)";
$modversion['people']['translaters'][] = "wuddel(german)";
$modversion['people']['translaters'][] = "almjd(arabic)";

$modversion['people']['documenters'][] = "mamba - <a href='http://www.xoops.org/uploads/tutorials/MyTabsTutorial.pdf' target='_blank'>Quick Tutorial</a>(english version) ";
$modversion['people']['documenters'][] = "Burning - <a href='http://internap.dl.sourceforge.net/sourceforge/xoops/xoops2_docu_module-mytabs2.pdf' target='_blank'>Full Tutorial</a> (english version)";
//$modversion['people']['other'][] = "";

$modversion['demo_site_url'] = "http://www.xuups.com";
$modversion['demo_site_name'] = "Xuups.com";
$modversion['support_site_url'] = "http://www.xuups.com/modules/newbb";
$modversion['support_site_name'] = "Xuups Support Forums";
$modversion['submit_bug'] = "http://www.xuups.com/modules/newbb";
$modversion['submit_feature'] = "http://www.xuups.com/modules/newbb";

$modversion['author_word'] = "I want to dedicated this module to Gopala, the owner of this idea and first lines of code.";
//$modversion['warning'] = "";

?>