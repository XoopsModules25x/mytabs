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
 * .* @author          InstantZero http://xoops.instant-zero.com
 * @param int    $currentoption
 * @param string $breadcrumb
 */

// defined('XOOPS_ROOT_PATH') || die("XOOPS root path not defined");

function mytabs_adminmenu($currentoption = 0, $breadcrumb = '')
{
    /* Nice buttons styles */
    echo "
        <style type='text/css'>
        #buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
        #buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/mytabs/assets/images/bg.png') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px; }
        #buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
        #buttonbar li { display:inline; margin:0; padding:0; }
        #buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/mytabs/assets/images/left_both.png') no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
        #buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/mytabs/assets/images/right_both.png') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
        /* Commented Backslash Hack hides rule from IE5-Mac \*/
        #buttonbar a span {float:none;}
        /* End IE5-Mac hack */
        #buttonbar a:hover span { color:#333; }
        #buttonbar #current a { background-position:0 -150px; border-width:0; }
        #buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
        #buttonbar a:hover { background-position:0% -150px; }
        #buttonbar a:hover span { background-position:100% -150px; }
        </style>
    ";
    global $xoopsModule, $xoopsConfig;

    $tblColors = array('', '', '');
    if ($currentoption >= 0) {
        $tblColors[$currentoption] = 'current';
    }

    xoops_loadLanguage('modinfo', 'mytabs');

    echo "<div id='buttontop'>";
    echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
    echo "<td style=\"width: 60%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"../../system/admin.php?fct=blocksadmin&amp;selvis=-1&amp;selmod=-2&amp;selgrp=-1&amp;selgen="
         . $xoopsModule->getVar('mid')
         . "\">"
         . _MI_MYTABS_ADMMENU3
         . '</a>';
    echo "<td style=\"width: 40%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;\"><b>" . $xoopsModule->name() . '  ' . _AM_MYTABS_MODULEADMIN . '</b> ' . $breadcrumb . '</td>';
    echo '</tr></table>';
    echo '</div>';

    echo "<div id='buttonbar'>";
    echo '<ul>';
    echo "<li id='" . $tblColors[0] . "'><a href=\"main.php\"\"><span>" . _MI_MYTABS_ADMMENU1 . "</span></a></li>\n";
    echo "<li id='" . $tblColors[2] . "'><a href=\"about.php\"\"><span>" . _MI_MYTABS_ADMMENU2 . "</span></a></li>\n";
    echo '</ul></div><div>&nbsp;</div>';
}
