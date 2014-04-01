{assign var='languages' value=$lookbookObj->getLanguagesOrdered()}
{assign var='currentLanguage' value=$lookbookObj->getDefaultLang()}
<!-- MODULE Block lookbook -->
<div id="manufacturers_block_left" class="row affix-top" data-spy="affix" data-offset-top="50">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default" style="border-radius: 0px; border: 0px">
                <h4 class="panel-title" >
                    <a style="padding-left: 5px;" data-toggle="collapse" data-parent="#manufacturers_block_left" href="#collapseOne">
                        MENU
                    </a>
                </h4>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id='lookbookMain' class="col-lg-12">
                        <hf><b>LOOKBOOKS</b></hf>
                        <ul class="bullet">
                            {foreach from=$categories item=c}
                                {if !empty($is154)}
                                    <li><a href="{$link->getModuleLink('lookbook')}{if !empty($rewrite_setting) }?{else}&{/if}category={$c.link}">{$c.name}</a></li>
                                    {else}
                                    <li><a href="{$lookbookObj->getURI($c.link)}">{$c.name}</a></li>
                                    {/if}
                                {/foreach}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /MODULE Block lookbook -->
