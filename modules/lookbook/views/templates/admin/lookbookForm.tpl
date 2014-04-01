<script>
	id_language = Number({$lookbookObj->getDefaultLang()});
</script>
<legend>
	{if !$update}
	<span style="display:inline;">{l s='Add a lookbook' mod='lookbook'}</span>
	{else}
	<span style="display:inline;">{l s='Update a lookbook' mod='lookbook'}</span>
	{/if}
</legend>
<form name="add_lookbook" id='add_lookbook' method="post">
	<input type="hidden" name="operation" value="{if !$update}add{else}update{/if}">
	<p style="text-align:right;margin-bottom:20px;font-size:10pt;"><a href="javascript: inst.liveActions('LBLookbookActions', 'lookbook', 'template');"><img src="{$smarty.const._PS_IMG_}admin/add.gif"/>Create a new lookbook</a></p>
	{foreach from=$lookbookObj->getLanguageIds() item=id_lang}
	{if $update}
		{assign var="active" value=$lookbookValues[$id_lang].active}
		{assign var="id_lookbook" value=$lookbookValues[$id_lang].id_lookbook}
	{/if}
		<div id="lookbook_{$id_lang}" class="lookbooks" style="display:{if $lookbookObj->getDefaultLang() == $id_lang} block; {else} none; {/if}">
			<p>
				<label>{l s='Lookbook name' mod='lookbook'}
					<span class="small">{l s='Type here the name of your lookbook' mod='lookbook'}</span>
				</label>
				<input type="text" id="lookbook_name_{$id_lang}" value="{if $update}{$lookbookValues[$id_lang].name}{/if}"/>
			</p>
			<p>
			<label>{l s='Lookbook description' mod='lookbook'}
				<span class="small">{l s='Type here the description of your lookbook' mod='lookbook'}</span>
			</label>
			<textarea id="lookbook_description_{$id_lang}">{if $update}{$lookbookValues[$id_lang].description}{/if}</textarea>
			</p>
		</div>
	{/foreach}
		<div>
			<p>
				<label>{l s='Active' mod='lookbook'}
					<span class="small">{l s='Check this checkbox if the lookbook is active' mod='lookbook'}</span>
				</label>
				<input type="checkbox" id="lookbook_active" {if !empty($active)}checked="checked"{/if}  value="1"/>
			</p>
		</div>
	<p>
		<span class="legend-add" style="display:inline;"><button style="float:right;" class="submit">{if !$update}{l s='Save' mod='lookbook'}{else}{l s='Update' mod='lookbook'}{/if}</button></span>
	</p>
	<div style="float:left;">{$lookbookObj->getLangDiv('lookbook','lookbook')}</div>
	{if $update}
	<input type="hidden" name="id_lookbook" value="{$id_lookbook}"/>
	{/if}
</form>