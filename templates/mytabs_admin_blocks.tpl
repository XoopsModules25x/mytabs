<{foreach item=block from=$blocks}>
    <div class="flexblock"
         style="background-color: <{if $block.visible}>#afa<{/if}><{if $block.timebased}>#ffa<{/if}><{if $block.unvisible}>#faa<{/if}>;">
        <div style="background-color: #ccc; padding-left: 6px; cursor: pointer;"
             onclick="toggleBlock(<{$block.pageblockid}>);" id="blockl_<{$block.pageblockid}>">
            <div style="float:right;font-size:10px;">
                (<{$block.pageblockid}>)
            </div>
            <{$block.title}><{if $block.note != ""}>&nbsp;(<{$block.note}>)<{/if}>
            <input type="checkbox" name="markedblocks[]" value="<{$block.pageblockid}>"
                   id="block_<{$block.pageblockid}>" style="display: none;">
        </div>
        <div style=" padding: 4px;">
            <{foreach item=groupid from=$block.groups name=grouploop}>
                <{if $smarty.foreach.grouploop.first}>(<{/if}><{$groups[$groupid]}><{if $smarty.foreach.grouploop.last}>)<{else}>, <{/if}>
            <{/foreach}>
            <br>
            <a href="block.php?op=edit&amp;pageblockid=<{$block.pageblockid}>"><{$smarty.const._EDIT}></a> -
            <a href="block.php?op=delete&amp;pageblockid=<{$block.pageblockid}>"><{$smarty.const._DELETE}></a>
            &nbsp;&nbsp;<input type="text" name="pri[<{$block.pageblockid}>]" value="<{$block.priority}>" size="2"
                               style="margin: 1px;">
            <select name='place[<{$block.pageblockid}>]'>";
                <option value='left' <{if $block.placement == 'left'}> selected='selected'<{/if}>><{$smarty.const._AM_MYTABS_LEFT}></option>
                <option value='center' <{if $block.placement == 'center'}> selected='selected'<{/if}>><{$smarty.const._AM_MYTABS_CENTER}></option>
                <option value='right' <{if $block.placement == 'right'}> selected='selected'<{/if}>><{$smarty.const._AM_MYTABS_RIGHT}></option>
            </select>
            <br><br>
        </div>
    </div>
<{/foreach}>
