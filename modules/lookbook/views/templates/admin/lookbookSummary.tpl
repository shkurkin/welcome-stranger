{foreach from=$lookbookObj->getLookbooks() item='lookbook'}
	<tr style="background-color: {cycle values="#ddf,#eef"}">
		<td>{$lookbook.name}</td>
		<td>{$lookbook.description|truncate:40:"..."}</td>
		<td>{$lookbookObj->getNbProductsInLookbook($lookbook.id_lookbook)}</td>
		<td>
			<a class="lb_status" rel="{$lookbook.id_lookbook}"><img rel="status" src="{$smarty.const._PS_IMG_}admin/{if $lookbook.active == 0}disabled{else}enabled{/if}.gif"/></a>|
			<a class="lb_edit"  rel="{$lookbook.id_lookbook}"><img rel="edit" src="{$smarty.const._PS_IMG_}admin/edit.gif" /></a>|
			<a class="lb_delete"  rel="{$lookbook.id_lookbook}"><img rel="delete" src="{$smarty.const._PS_IMG_}admin/delete.gif" /></a>
		</td>
	</tr>
{/foreach}