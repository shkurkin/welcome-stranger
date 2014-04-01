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