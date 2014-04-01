		<select id="productsFromManufacturerSelect" name="productsFromManufacturerSelect" class="selectMenu">
			<option value="">{l s='Choose a manufacturer' mod='lookbook'}</option>
			<option value="">------------</option>
			{foreach from=$lookbookObj->getManufacturers() item='manufacturer'}
				<option value="{$manufacturer.id_manufacturer}" {if $manufacturer.id_manufacturer == $id_manufacturer}selected="selected"{/if}>{$manufacturer.name}</option>
			{/foreach}
		</select><br/>
		<select id="productsToAssignSelect" name="assignedProducts[]" class="multiple"  multiple="true">
			{foreach from=$unAssignedProducts item='product'}
				<option value="{$product.id_product}">{$product.name}
			{/foreach}
		</select>
		<br/>
		<input style="width:80%;margin-top:10px;" type="button" id="productsAddButton" value="<- {l s='Add' mod='lookbook'}"/>