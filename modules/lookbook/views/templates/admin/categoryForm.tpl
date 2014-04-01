<script>
	id_language = Number({$lookbookObj->getDefaultLang()});
</script>
<legend>
	{if !$update}
	<span style="display:inline;">{l s='Add a category' mod='lookbook'}</span>
	{else}
	<span style="display:inline;">{l s='Update a category' mod='lookbook'}</span>
	{/if}
</legend>
<form name="add_category" id='add_category' method="post">
	<input type="hidden" name="operation" value="{if !$update}add{else}update{/if}">
	<p style="text-align:right;margin-bottom:20px;font-size:10pt;"><a href="javascript: inst.liveActions('LBCategoryActions', 'category', 'template');"><img src="{$smarty.const._PS_IMG_}admin/add.gif"/>Create a new lookbook</a></p>
{foreach from=$lookbookObj->getLanguageIds() item=id_lang}
{if $update}
	{assign var="active" value=$categoryValues[$id_lang].active}
	{assign var="id_category" value=$categoryValues[$id_lang].id_category}
{/if}
	<div id="category_{$id_lang}" class="categories" style="display:{if $lookbookObj->getDefaultLang() == $id_lang} block; {else} none; {/if}">
		<p>
			<label>{l s='Category name' mod='lookbook'}
				<span class="small">{l s='Type here the name of your category' mod='lookbook'}</span>
			</label>
			<input type="text" id="category_name_{$id_lang}" value="{if $update}{$categoryValues[$id_lang].name}{/if}"/>
		</p>
		<p>
		<label>{l s='Category description' mod='lookbook'}
			<span class="small">{l s='Type here the description of your category' mod='lookbook'}</span>
		</label>
		<textarea id="category_description_{$id_lang}">{if $update}{$categoryValues[$id_lang].description}{/if}</textarea>
		</p>
	</div>
{/foreach}
	<div>
		<p>
			<label>{l s='Active' mod='lookbook'}
				<span class="small">{l s='Check this checkbox if the category is active' mod='lookbook'}</span>
			</label>
			<input type="checkbox" id="category_active" {if !empty($active)}checked="checked"{/if} value="1"/>
		</p>
	</div>
	<p>
		<span style="display:inline;"><button style="float:right;" class="submit">{if !$update}{l s='Save' mod='lookbook'}{else}{l s='Update' mod='lookbook'}{/if}</button></span>
	</p>
	<div style="float:left;">{$lookbookObj->getLangDiv('category','category')}</div>
	{if $update}
	<input type="hidden" name="id_category" value="{$id_category}"/>
	{/if}
</form>