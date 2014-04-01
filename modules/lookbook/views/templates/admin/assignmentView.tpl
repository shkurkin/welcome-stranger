<h3>{l s='Assign multiple lookbooks to a category' mod='lookbook'}</h3>
<form>
	<div class="assignments" id="lookbookAssignments">
		<fieldset>
			<legend>
				<select id="categoryToBeAssignedSelect" name="categoryToBeAssignedSelect" class="selectMenu">
						<option value="">{l s='Choose a category' mod='lookbook'}</option>
						<option value="">------------</option>
					{foreach from=$lookbookObj->getCategories(true) item='category'}
						<option value="{$category.id_category}">{$category.name}</option>
					{/foreach}
				</select>
			</legend>
			<div style="float:left;text-align:center;">
				<select id="lookbooksAssignedSelect" name="assignedLookbook[]" class="multiple" multiple="true">
				</select>
				<br/>
				<input style="width:80%;margin-top:10px;" type="button" id="lookbooksRemoveButton" value="{l s='Remove' mod='lookbook'} ->"/>
			</div>
			<div style="float:left;text-align:center;">
				<select id="lookbooksToAssignSelect" name="assignedLookbook[]" class="multiple" multiple="true">
				</select>
				<br/>
				<input style="width:80%;margin-top:10px;" type="button" id="lookbooksAddButton" value="<- {l s='Add' mod='lookbook'}"/>
			</div>
		</fieldset>
	</div>
</form>
<hr/>
<h3>{l s='Assign products to a lookbook' mod='lookbook'}</h3>
<form>
	<div class="assignments" id="productAssignements">
		<fieldset>
			<div id="productAssignmentsAssigned" style="float:left;text-align:center;">
				<select id="lookbookToBeAssignedSelect" name="lookbookToBeAssignedSelect" class="selectMenu">
					<option value="">{l s='Choose a lookbook' mod='lookbook'}</option>
					<option value="">------------</option>
					{foreach from=$lookbookObj->getLookbooks(true) item='lookbook'}
						<option value="{$lookbook.id_lookbook}">{$lookbook.name}</option>
					{/foreach}
				</select><br/>
				<select id="productsAssignedSelect" name="assignedProducts[]" class="multiple"  multiple="true">
				</select>
				<br/>
				<input style="width:80%;margin-top:10px;" type="button" id="productsRemoveButton" value="{l s='Remove' mod='lookbook'}"/>
			</div>

			<div id="productAssignmentsUnAssigned" style="float:left;text-align:center;">
				<select id="productsFromManufacturerSelect" name="productsFromManufacturerSelect" class="selectMenu">
					<option value="">{l s='Choose a manufacturer' mod='lookbook'}</option>
					<option value="">------------</option>
					{foreach from=$lookbookObj->getManufacturers() item='manufacturer'}
						<option value="{$manufacturer.id_manufacturer}">{$manufacturer.name}</option>
					{/foreach}
				</select><br/>
				<select id="productsToAssignSelect" name="assignedProducts[]" class="multiple"  multiple="true">
				</select>
				<br/>
				<input style="width:80%;margin-top:10px;" type="button" id="productsAddButton" value="<- {l s='Add' mod='lookbook'}"/>
			</div>
		</fieldset>
	</div>
</form>