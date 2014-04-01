		<select id="lookbookToBeAssignedSelect" name="lookbookToBeAssignedSelect" class="selectMenu">
			<option value="">{l s='Choose a lookbook' mod='lookbook'}</option>
			<option value="">------------</option>
			{foreach from=$lookbookObj->getLookbooks(true) item='lookbook'}
				<option value="{$lookbook.id_lookbook}" {if $lookbook.id_lookbook == $id_lookbook}selected="selected"{/if}>{$lookbook.name}</option>
			{/foreach}
		</select><br/>
		<select id="productsAssignedSelect" name="assignedProducts[]" class="multiple"  multiple="true">
			{foreach from=$assignedProducts item='manufacturer'}
				{foreach from=$manufacturer item='product'}
				<option value="{$product.id_product}">{$product.name}
				{/foreach}
			{/foreach}
		</select>
		<br/>
		<input style="width:80%;margin-top:10px;" type="button" id="productsRemoveButton" value="{l s='Remove' mod='lookbook'}"/>
