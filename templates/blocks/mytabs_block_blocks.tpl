<div class="<{$block.class}>-menu" id="tabscontents-<{$block.uniqueid}>"><{$block.tabsmenu}></div>

<{foreach item=thistab from=$block.tabs}>
    <div class="<{$block.class}>-content" id="tab-<{$thistab.id}>-<{$block.uniqueid}>"
         style="<{if $block.width != 0}>width:<{$block.width}>px;<{/if}><{if $block.height != 0}>height: <{$block.height}>px;<{/if}>overflow: auto;">
        <table cellspacing="0">
            <tr>
                <{foreach item=placement from=$block.placements}>
                    <{if $thistab.$placement}>
                        <td style="width:<{$thistab.width}>%; padding: 5px; vertical-align: top;">
                            <{foreach item=thisblock from=$thistab.$placement}>
                                <div class="<{$block.class}>-block">
                                    <{if $block.showblockstitle == 1}>
                                        <h2 class="<{$block.class}>-blocktitle"><{$thisblock.title}></h2>
                                    <{/if}>
                                    <div class="<{$block.class}>-blockcontent"><{$thisblock.content}></div>
                                </div>
                            <{/foreach}>
                        </td>
                    <{/if}>
                <{/foreach}>
            </tr>
        </table>
    </div>
<{/foreach}>

<script type="text/javascript">
    var tabc_<{$block.uniqueid}>= new ddtabcontent("tabscontents-<{$block.uniqueid}>")
    tabc_<{$block.uniqueid}>.setpersist(<{$block.persist}>)
    tabc_<{$block.uniqueid}>.hidetabs(<{$block.hidetabs}>)
    tabc_<{$block.uniqueid}>.setonmouseover(<{$block.onmouseover}>)
    tabc_<{$block.uniqueid}>.setselectedClassTarget("link")
    tabc_<{$block.uniqueid}>.init(<{$block.milisec}>)
</script>
