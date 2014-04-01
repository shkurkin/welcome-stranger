<fieldset>
	<legend>
		<select id="categoryToBeAssignedSelect" name="categoryToBeAssignedSelect" class="selectMenu">
				<option value="">{l s='Choose a category' mod='lookbook'}</option>
				<option value="">------------</option>
			{foreach from=$lookbookObj->getCategories(true) item='category'}
				<option value="{$category.id_category}" {if $category.id_category == $id_category}selected="selected"{/if}>{$category.name}</option>
			{/foreach}
		</select>
	</legend>
	<div style="float:left;text-align:center;">
		<select id="lookbooksAssignedSelect" name="assignedLookbook[]" class="multiple" multiple="true">
			{foreach from=$assignedLookbooks item='lookbook'}
				<option value="{$lookbook.id_lookbook}">{$lookbook.name}
			{/foreach}
		</select>
		<br/>
		<input style="width:80%;margin-top:10px;" type="button" id="lookbooksRemoveButton" value="{l s='Remove' mod='lookbook'} ->"/>
	</div>
	<div style="float:left;text-align:center;">
		<select id="lookbooksToAssignSelect" name="assignedLookbook[]" class="multiple" multiple="true">
			{foreach from=$unAssignedLookbooks item='lookbook'}
				<option value="{$lookbook.id_lookbook}">{$lookbook.name}
			{/foreach}
		</select>
		<br/>
		<input style="width:80%;margin-top:10px;" type="button" id="lookbooksAddButton" value="<- {l s='Add' mod='lookbook'}"/>
	</div>
</fieldset>