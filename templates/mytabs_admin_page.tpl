<{if $pagelist}>
    <div style="float: right;">
        <form method="get" action="main.php" id="changepage">
            <select name="pageid" id="pageid">
                <{foreach item=name from=$pagelist key=value }>
                    <option value="<{$value}>"<{if $pageid == $value}> selected='selected'<{/if}>><{$name}></option>
                <{/foreach}>
            </select>
            <input type="submit" value="<{$smarty.const._AM_MYTABS_GOTO_PAGE}>">
        </form>
    </div>
    <div>
        <a href="index.php"><{$smarty.const._AM_MYTABS_HOME}></a>&raquo;&nbsp;
        <a href="main.php?pageid=<{$pageid}>"><{$pagename}></a>&nbsp;
        <a href="page.php?op=edit&amp;pageid=<{$pageid}>"><{$smarty.const._EDIT}></a> -
        <a href="page.php?op=delete&amp;pageid=<{$pageid}>"><{$smarty.const._DELETE}></a>
    </div>
    <br>
<{/if}>

<div>
    <{if $tabs}>
        <div>
            <form action="main.php" method="post" onsubmit="return confirmIfDelete(this);">
                <{securityToken}><{*//mb*}>
                <div style="clear:both;">
                    <table style="border: 1px solid #000000; border-collapse: collapse; padding: 4px; margin:1px; width:100%;">
                        <tr>
                            <{foreach from=$tabs key=k item=tab}>
                                <td style="border: 1px solid #000000; padding: 4px; margin: 1px; vertical-align: top;">
                                    <div class="flexblock"
                                         style="background-color: <{if $tab.visible}>#afa<{/if}><{if $tab.timebased}>#ffa<{/if}><{if $tab.unvisible}>#faa<{/if}>;">
                                        <div style="background-color: #ccc; padding-left: 6px; cursor: pointer;"
                                             onclick="toggleTab(<{$k}>);" id="tabl_<{$k}>">
                                            <div style="float:right;font-size:10px;">
                                                (<{$k}>)
                                            </div>
                                            <{$tab.title}><{if $tab.note != ""}>&nbsp;(<{$tab.note}>)<{/if}>
                                            <input type="checkbox" name="markedtabs[]" value="<{$k}>" id="tab_<{$k}>"
                                                   style="display: none;">
                                        </div>
                                        <{if $tab.link != ""}>
                                            <div style="padding: 4px;background-color: #aff;">
                                                <{$smarty.const._AM_MYTABS_LINK}>:&nbsp;<{$tab.link}>
                                            </div>
                                        <{/if}>
                                        <{if $tab.rev != ""}>
                                            <div style="padding: 4px;background-color: #aaf;">
                                                <{$smarty.const._AM_MYTABS_REV}>:&nbsp;<{$tab.rev}>
                                            </div>
                                        <{/if}>
                                        <div style="padding: 4px;">
                                            <{foreach item=groupid from=$tab.groups name=grouploop}>
                                                <{if $smarty.foreach.grouploop.first}>(<{/if}><{$groups[$groupid]}><{if $smarty.foreach.grouploop.last}>)<{else}>, <{/if}>
                                            <{/foreach}>
                                            <br>
                                            <a href="tab.php?op=edit&amp;tabid=<{$k}>"><{$smarty.const._EDIT}></a> -
                                            <a href="tab.php?op=delete&amp;tabid=<{$k}>"><{$smarty.const._DELETE}></a>&nbsp;&nbsp;
                                            <input type="text" name="tabpri[<{$k}>]" value="<{$tab.priority}>" size="2"
                                                   style="margin: 1px;">
                                        </div>
                                        <hr>
                                        <{if $blocks}>
                                            <{include file="db:mytabs_admin_blocks.tpl" blocks=$blocks.$k}>
                                        <{/if}>
                                    </div>
                                </td>
                            <{/foreach}>
                        </tr>
                    </table>
                </div>
                <div style="float:right;width:200px;">
                    <fieldset>
                        <legend><{$smarty.const._AM_MYTABS_COLOR_LEGEND}></legend>
                        <table>
                            <tr>
                                <td style="background: #afa; border: 1px solid #000000;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td><{$smarty.const._AM_MYTABS_COLOR_LEGEND_VISIBLE}></td>
                            </tr>
                            <tr>
                                <td style="background: #ffa; border: 1px solid #000000;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td><{$smarty.const._AM_MYTABS_COLOR_LEGEND_TIME_BASED}></td>
                            </tr>
                            <tr>
                                <td style="background: #faa; border: 1px solid #000000;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                <td><{$smarty.const._AM_MYTABS_COLOR_LEGEND_NOT_VISIBLE}></td>
                            </tr>
                        </table>
                    </fieldset>
                </div>
                <div>
                    <select name="doaction">
                        <option value="setpriorities"><{$smarty.const._AM_MYTABS_ACTION_SETPRIORITIES}></option>
                        <option value="delete"><{$smarty.const._AM_MYTABS_ACTION_DELETE}></option>
                    </select>
                    <input type="submit" value="<{$smarty.const._AM_MYTABS_GO}>">
                    <input type="button" onclick="document.location='main.php?pageid=<{$pageid}>';"
                           value="<{$smarty.const._AM_MYTABS_CANCEL}>">
                    <input type="hidden" name="pageid" value="<{$pageid}>">
                </div>
            </form>
        </div>
    <{/if}>


    <{if $placement}>
        <div>
            <h3><{$smarty.const._AM_MYTABS_CREATE_BLOCK}></h3>
            <form method="post" action="block.php" id="newblocksubmit">
                <{securityToken}><{*//mb*}>
                <input type="hidden" name="op" value="new">
                <select name="blockid" id="blockid">
                    <{foreach item=name from=$blocklist key=value }>
                        <option value="<{$value}>"><{$name}></option>
                    <{/foreach}>
                </select>&nbsp;
                <{$placement}>
                <input type="submit" value="<{$smarty.const._AM_MYTABS_GO}>">
                <input type="hidden" name="pageid" value="<{$pageid}>">
            </form>
        </div>
    <{/if}>

    <{if $pagelist}>
        <div>
            <h3><{$smarty.const._AM_MYTABS_CREATE_TAB}></h3>
            <form method="post" action="tab.php" id="newtabsubmit">
                <{securityToken}><{*//mb*}>
                <input type="hidden" name="op" value="new">
                <input type="text" name="tabtitle" id="tabtitle" size="14">
                <input type="submit" value="<{$smarty.const._AM_MYTABS_GO}>">
                <input type="hidden" name="pageid" value="<{$pageid}>">
            </form>
        </div>
    <{/if}>

    <div>
        <h3><{$smarty.const._AM_MYTABS_CREATE_PAGE}></h3>
        <form method="post" action="page.php" id="newpagesubmit">
            <{securityToken}><{*//mb*}>
            <input type="hidden" name="op" value="new">
            <input type="text" name="pagetitle" id="pagetitle" size="14">
            <input type="submit" value="<{$smarty.const._AM_MYTABS_GO}>">
        </form>
    </div>

</div>

<div id="flexblock_infoblock" style="margin-top: 20px;"></div>

<script type="text/javascript">
    function toggleBlock(id) {
        var checkbox = document.getElementById('block_' + id);
        checkbox.checked = !checkbox.checked;
        document.getElementById('blockl_' + id).style.backgroundColor = checkbox.checked ? '#fa0' : '#ccc';
    }

    function toggleTab(id) {
        var checkbox = document.getElementById('tab_' + id);
        checkbox.checked = !checkbox.checked;
        document.getElementById('tabl_' + id).style.backgroundColor = checkbox.checked ? '#fa0' : '#ccc';
    }

    function confirmIfDelete(form) {
        if (form.doaction.value == 'delete')
            return confirm('<{$smarty.const._AM_MYTABS_CONFIRM_DELETE}>');
        return true;
    }
</script>
