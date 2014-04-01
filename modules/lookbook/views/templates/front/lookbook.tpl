{$lookbookObj->getCss()}
{assign var='languages' value=$lookbookObj->getLanguagesOrdered()}
{assign var='currentLanguage' value=$lookbookObj->getDefaultLang()}
{if $bVersion15}
<script type="text/javascript" src="{$lookbookObj->getWebPath()}js/lookbook-fo2.js"></script>
{else}
<script type="text/javascript" src="{$lookbookObj->getWebPath()}js/lookbook-fo.js"></script>
{/if}
<div id="lookbox" style="text-align:center;">
	<h2>{$selectedLookbook.name}</h2>
	<div id="scene">
		<img src="{$lookbookObj->getWebPath()}uploads/{$selectedLookbook.image_url}" width="{$imageWidth}"/>
	</div>
</div>
  
<div id="explore-book">
	<h2>{l s='Explore our lookbooks' mod='lookbook'}</h2>
	<div id="scenes_list">
		{assign var='aliHeight' value=100}
		{assign var='anbItemsPerLine' value=4}
		{assign var='anbLi' value=$lookbooks|@count}
		{math equation="anbLi/anbItemsPerLine" anbLi=$anbLi anbItemsPerLine=$anbItemsPerLine assign=anbLines}
		{math equation="anbLines*aliHeight" anbLines=$anbLines|ceil aliHeight=$aliHeight assign=aulHeight}
		<ul style="height:{$aulHeight}px;">
			{foreach from=$lookbooks key=k item=lookbook name=lbLookbook}
			<li id="lb_{$lookbook.id_lookbook}" class="{if $selectedLookbook.link == $lookbook.link}selected{/if} {if $smarty.foreach.lbLookbook.first}first_item{elseif $smarty.foreach.lbLookbook.last}last_item{else}item{/if} {if $smarty.foreach.lbLookbook.iteration%$anbItemsPerLine == 0}last_item_of_line{elseif $smarty.foreach.lbLookbook.iteration%$anbItemsPerLine == 1}clear{/if} {if $smarty.foreach.lbLookbook.iteration > ($smarty.foreach.lbLookbook.total - ($smarty.foreach.lbLookbook.total % $anbItemsPerLine))}last_line{/if}"><a href="{$lookbookObj->getURI($category.link,$lookbook.link)}"><img src="{$lookbookObj->getWebPath()}uploads/thumbs/{$lookbook.image_url}" width="{$thImageWidth}"/></a></li>
			{/foreach}
		</ul>
	</div>
</div>


<div style="clear:both;"></div>
<h2>{l s='Description of the lookbook' mod='lookbook'} {$selectedLookbook.name}</h2>
<div class="lookdesc">
	{$selectedLookbook.description}
</div>
{if $bVersion15}
{include file="../../../views/templates/front/block-$display.tpl" products=$products}
{else}
{include file="views/templates/front/block-$display.tpl" products=$products}
{/if}