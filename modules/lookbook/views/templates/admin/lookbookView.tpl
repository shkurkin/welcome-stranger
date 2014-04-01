<fieldset id="lookbookForm" class="stylized myform">
	<script>
		id_language = Number({$lookbookObj->getDefaultLang()});
	</script>
	<legend><span class="legend-add" style="display:inline;">{l s='Add a lookbook' mod='lookbook'}</span><span class="legend-update" style="display:none;">{l s='Update a lookbook' mod='lookbook'}</span></legend>
	<form name="add_lookbook" id='add_lookbook' method="post">
		<input type="hidden" name="operation" value="add">
		<p style="text-align:right;margin-bottom:20px;font-size:10pt;"><a href="javascript: inst.liveActions('LBLookbookActions', 'lookbook', 'template');"><img src="{$smarty.const._PS_IMG_}admin/add.gif"/>Create a new lookbook</a></p>
		{foreach from=$lookbookObj->getLanguageIds() item=id_lang}
			<div id="lookbook_{$id_lang}" class="lookbooks" style="display:{if $lookbookObj->getDefaultLang() == $id_lang} block; {else} none; {/if}">
				<p>
					<label>{l s='Lookbook name' mod='lookbook'}
						<span class="small">{l s='Type here the name of your lookbook' mod='lookbook'}</span>
					</label>
					<input type="text" id="lookbook_name_{$id_lang}"/>
				</p>
				<p>
				<label>{l s='Lookbook description' mod='lookbook'}
					<span class="small">{l s='Type here the description of your lookbook' mod='lookbook'}</span>
				</label>
				<textarea id="lookbook_description_{$id_lang}"></textarea>
				</p>
			</div>
		{/foreach}
			<div>
				<p>
					<label>{l s='Active' mod='lookbook'}
						<span class="small">{l s='Check this checkbox if the lookbook is active' mod='lookbook'}</span>
					</label>
					<input type="checkbox" id="lookbook_active" value="1"/>
				</p>
			</div>
		<p>
			<span class="legend-add" style="display:inline;"><button style="float:right;" class="submit">{l s='Save' mod='lookbook'}</button></span>
			<span class="legend-update" style="display:none;"><button style="float:right;" class="submit">{l s='Update' mod='lookbook'}</button></span>
		</p>
		<div style="float:left;">{$lookbookObj->getLangDiv('lookbook','lookbook')}</div>
	</form>
</fieldset>
<hr/>
<fieldset class="stylized myform">
	<legend>{l s='List of the lookbooks' mod='lookbook'}</legend>
	<table>
		<thead>
			<tr>
				<th>{l s='Name' mod='lookbook'}</th><th>{l s='Description summary' mod='lookbook'}</th><th>{l s='# products' mod='lookbook'}</th><th>{l s='Actions' mod='lookbook'}</th>
			</tr>
		</thead>
		<tbody id='lookbook'>
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
		</tbody>
	</table>
</fieldset>