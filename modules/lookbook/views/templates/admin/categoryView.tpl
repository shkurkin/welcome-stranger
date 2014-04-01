<fieldset id="categoryForm" class="myform stylized">
	<script>
		id_language = Number({$lookbookObj->getDefaultLang()});
	</script>
	<legend><span class="legend-add" style="display:inline;">{l s='Add a category' mod='lookbook'}</span><span class="legend-update" style="display:none;">{l s='Update a category' mod='lookbook'}</span></legend>
	<form name="add_category" id='add_category' method="post">
		<input type="hidden" name="operation" value="add">
		<p style="text-align:right;margin-bottom:20px;font-size:10pt;"><a href="javascript: inst.liveActions('LBCategoryActions', 'category', 'template');"><img src="{$smarty.const._PS_IMG_}admin/add.gif"/>Create a new category</a></p>
	{foreach from=$lookbookObj->getLanguageIds() item=id_lang}
		<div id="category_{$id_lang}" class="categories" style="display:{if $lookbookObj->getDefaultLang() == $id_lang} block; {else} none; {/if}">
			<p>
				<label>{l s='Category name' mod='lookbook'}
					<span class="small">{l s='Type here the name of your category' mod='lookbook'}</span>
				</label>
				<input type="text" id="category_name_{$id_lang}"/>
			</p>
			<p>
			<label>{l s='Category description' mod='lookbook'}
				<span class="small">{l s='Type here the description of your category' mod='lookbook'}</span>
			</label>
			<textarea id="category_description_{$id_lang}"></textarea>
			</p>
		</div>
	{/foreach}
		<div>
			<p>
				<label>{l s='Active' mod='lookbook'}
					<span class="small">{l s='Check this checkbox if the category is active' mod='lookbook'}</span>
				</label>
				<input type="checkbox" id="category_active" value="1"/>
			</p>
		</div>
		<p>
			<span class="legend-add" style="display:inline;"><button style="float:right;" class="submit">{l s='Save' mod='lookbook'}</button></span>
			<span class="legend-update" style="display:none;"><button style="float:right;" class="submit">{l s='Update' mod='lookbook'}</button></span>
		</p>
		<div style="float:left;">{$lookbookObj->getLangDiv('category','category')}</div>
	</form>
</fieldset>
<hr/>
<fieldset class="stylized myform">
	<legend>{l s='List of the categories' mod='lookbook'}</legend>
	<table>
		<thead>
			<tr>
				<th>{l s='Name' mod='lookbook'}</th><th>{l s='Description summary' mod='lookbook'}</th><th>{l s='# lookbooks' mod='lookbook'}</th><th>{l s='Actions' mod='lookbook'}</th>
			</tr>
		</thead>
		<tbody id="category">
		{foreach from=$lookbookObj->getCategories() item='category'}
			<tr style="background-color: {cycle values="#ddf,#eef"}">
				<td>{$category.name}</td>
				<td>{$category.description|truncate:40:"..."}</td>
				<td>{$lookbookObj->getNbLookbookForThisCategory($category.id_category)}</td>
				<td>
					<a class="cat_status" rel="{$category.id_category}"><img rel="status" src="{$smarty.const._PS_IMG_}admin/{if $category.active == 0}disabled{else}enabled{/if}.gif"/></a>|
					<a class="cat_edit"  rel="{$category.id_category}"><img rel="edit" src="{$smarty.const._PS_IMG_}admin/edit.gif" /></a>|
					<a class="cat_delete"  rel="{$category.id_category}"><img rel="delete" src="{$smarty.const._PS_IMG_}admin/delete.gif" /></a>
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
</fieldset>