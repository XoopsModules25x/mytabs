<{foreach item=thisblock from=$block.blocks}>
    <div>
        <{if $thisblock.title != ""}>
            <h3 id="title-<{$thisblock.blockid}>" class="mytabsblock-title">
                <{$thisblock.title}>
            </h3>
        <{/if}>

        <div id="content-<{$thisblock.blockid}>" class="mytabsblock-content">
            <{$thisblock.content}>
        </div>

    </div>
<{/foreach}>
