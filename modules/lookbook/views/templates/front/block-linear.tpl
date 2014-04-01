{if isset($products)}
	<!-- Products list -->
	<ul id="lb_product_list" class="clear">
		<script type="text/javascript">
			var jsonAttributes = {$jsonAttributes};
			// Translations
			var doesntExist = '{l s='The product does not exist in this model. Please choose another.' js=1}';
			var doesntExistNoMore = '{l s='This product is no longer in stock' js=1}';
			var doesntExistNoMoreBut = '{l s='with those attributes but is available with others' js=1}';
			var uploading_in_progress = '{l s='Uploading in progress, please wait...' js=1}';
			var fieldRequired = '{l s='Please fill in all required fields, then save the customization.' js=1}';
		</script>
		
	    {foreach from=$products item=product key=key name=products}

        <script type="text/javascript">


            var pAttributes_{$key} = new attributeManipulation(jsonAttributes);
            pAttributes_{$key}.productAvailableForOrder = '{$product.pObj->available_for_order}';
            pAttributes_{$key}.allowBuyWhenOutOfStock = {if $product.attributes.allow_oosp == 1}true{else}false{/if};
            pAttributes_{$key}.productReference = '{$product.pObj->reference|escape:'htmlall':'UTF-8'}';
            pAttributes_{$key}.default_eco_tax = {$product.pObj->ecotax};
            pAttributes_{$key}.availableNowValue = '{$product.pObj->available_now|escape:'quotes':'UTF-8'}';
            pAttributes_{$key}.maxQuantityToAllowDisplayOfLastQuantityMessage = {$product.attributes.last_qties};
            pAttributes_{$key}.quantitiesDisplayAllowed = {if $product.attributes.display_qties == 1}true{else}false{/if};
            pAttributes_{$key}.productShowPrice = '{$product.pObj->show_price}';
            pAttributes_{$key}.productPriceTaxExcluded = {$product.pObj->getPriceWithoutReduct(true)|default:'null'} - {$product.pObj->ecotax};
            pAttributes_{$key}.group_reduction = '{$product.attributes.group_reduction}';
            pAttributes_{$key}.taxRate = {$product.attributes.tax_rate|floatval};
            pAttributes_{$key}.specific_price = {if $product.pObj->specificPrice AND $product.pObj->specificPrice.price}{$product.pObj->specificPrice.price}{else}0{/if};
            pAttributes_{$key}.currencyRate = '{$product.attributes.currencyRate|floatval}';
            pAttributes_{$key}.displayPrice = {$product.attributes.priceDisplay};
            pAttributes_{$key}.noTaxForThisProduct = false;
            pAttributes_{$key}.reduction_price = {if $product.pObj->specificPrice AND $product.pObj->specificPrice.reduction AND $product.pObj->specificPrice.reduction_type == 'amount'}{$product.pObj->specificPrice.reduction}{else}0{/if};
            pAttributes_{$key}.reduction_percent = {if $product.pObj->specificPrice AND $product.pObj->specificPrice.reduction AND $product.pObj->specificPrice.reduction_type == 'percentage'}{$product.pObj->specificPrice.reduction*100}{else}0{/if};
            pAttributes_{$key}.specific_currency = {if $product.pObj->specificPrice AND $product.pObj->specificPrice.id_currency}true{else}false{/if};
            pAttributes_{$key}.ecotaxTax_rate = {$product.attributes.ecotaxTax_rate};
            pAttributes_{$key}.currencyRate = '{$product.attributes.currencyRate|floatval}';
            pAttributes_{$key}.currencyFormat = '{$product.attributes.currencyFormat|intval}';
            pAttributes_{$key}.currencyBlank = '{$product.attributes.currencyBlank|intval}';
            pAttributes_{$key}.currencySign = '{$product.attributes.currencySign|html_entity_decode:2:"UTF-8"}';
            pAttributes_{$key}.productUnitPriceRatio = '{$product.pObj->unit_price_ratio}';
            {if $bVersion15}
            pAttributes_{$key}.productBasePriceTaxExcluded = {$product.pObj->base_price} - {$product.pObj->ecotax};
            {else}
            pAttributes_{$key}.productBasePriceTaxExcluded = {$product.pObj->price} - {$product.pObj->ecotax};
            {/if}
            pAttributes_{$key}.productPrice = '{$product.pObj->price}';

            {if !isset($priceDisplayPrecision)}
            	{assign var='priceDisplayPrecision' value=2}
            {/if}


            pAttributes_{$key}.product_specific_price = new Array();
            {foreach from=$product.pObj->specificPrice key='key_specific_price' item='specific_price_value'}
            	pAttributes_{$key}.product_specific_price['{$key_specific_price}'] = '{$specific_price_value}';
            {/foreach}


            {if isset($product.attributes.groups)}
                pAttributes_{$key}.addCombination({$key});
            {/if}
            $(document).ready(function()
            {ldelim}
                $('p#add_to_cart_{$key} input').unbind('click').click(function(){ldelim}
                    ajaxCart.add( $('#product_page_product_id_{$key}').val(), $('#idCombination_{$key}').val(), false, product_block{$key}, $('#quantity_wanted_{$key}').val(), null);
                    return false;
                {rdelim});
                pAttributes_{$key}.findCombination();
            {rdelim});
        </script>

		<li class="ajax_block_product {if $smarty.foreach.products.first}first_item{elseif $smarty.foreach.products.last}last_item{/if} {if $smarty.foreach.products.index % 2}alternate_item{else}item{/if} clearfix">

			<div class="center_block">
				
				<a href="{$product.link|escape:'htmlall':'UTF-8'}" class="product_img_link" title="{$product.name|escape:'htmlall':'UTF-8'}"><img src="{if !empty($bVersion15)}{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')}{else}{$link->getImageLink($product.link_rewrite, $product.id_image, 'home')}{/if}" alt="{if !empty($product.legend)}{$product.legend|escape:'htmlall':'UTF-8'}{/if}" {if isset($homeSize)} width="{$homeSize.width}" height="{$homeSize.height}"{/if} /></a>

				<h3>{if isset($product.new) && $product.new == 1}<span class="new">{l s='New' mod='lookbook'}</span>{/if}<a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.name|escape:'htmlall':'UTF-8'}">{$product.name|truncate:35:'...'|escape:'htmlall':'UTF-8'}</a><p id="product_reference" {if isset($groups) OR !$product.pObj->reference}style="display: none;"{/if}><label for="product_reference">{l s='Reference :' mod='lookbook'} </label><span class="editable">{$product.pObj->reference|escape:'htmlall':'UTF-8'}</span></p></h3>

				<div id="short_description_block">
					{if $product.pObj->description_short OR $product.attributes.packItems|@count > 0}
				
						{if $product.pObj->description_short}
							<div id="short_description_content" class="rte align_justify"><a href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.description_short|truncate:360:'...'|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'}">{$product.pObj->description_short}</a>
						{/if}
				
							</div>

						{if $product.attributes.packItems|@count > 0}
							<h3>{l s='Pack content' mod='lookbook'}</h3>
							{foreach from=$product.attributes.packItems item=packItem}
								<div class="pack_content">
									{$packItem.pack_quantity} x <a href="{$link->getProductLink($packItem.id_product, $packItem.link_rewrite, $packItem.category)}">{$packItem.name|escape:'htmlall':'UTF-8'}</a>
									<p>{$packItem.description_short}</p>
								</div>
							{/foreach}
						{/if}

					</div>
					{/if}
				</div>

			<!-- add to cart form-->
			<form id="buy_block_{$key}" {if $PS_CATALOG_MODE AND !isset($groups) AND $product.pObj->quantity > 0}class="hidden"{/if} action="{$link->getPageLink('cart.php')}" method="post">
				<div id="product_block{$key}" class="right_block">
					<p class="hidden">
						<input type="hidden" name="token" value="{$static_token}" />
						<input type="hidden" name="id_product" value="{$product.pObj->id|intval}" id="product_page_product_id_{$key}" />
						<input type="hidden" name="add" value="1" />
						<input type="hidden" name="id_product_attribute" id="idCombination_{$key}" value="" />
					</p>
					
					
					<!-- prices -->
					{if $product.pObj->show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}
						<p class="price">
							
							{if !$priceDisplay || $priceDisplay == 2}
								{assign var='productPrice' value=$product.pObj->getPrice(true, $smarty.const.NULL, 2)}
								{assign var='productPriceWithoutReduction' value=$product.pObj->getPriceWithoutReduct(false, $smarty.const.NULL)}
							
							
							{elseif $priceDisplay == 1}
								{assign var='productPrice' value=$product.pObj->getPrice(false, $smarty.const.NULL, 2)}
								{assign var='productPriceWithoutReduction' value=$product.pObj->getPriceWithoutReduct(true, $smarty.const.NULL)}
							{/if}

							
							{if $product.pObj->on_sale}
								<img src="{$img_dir}onsale_{$lang_iso}.gif" alt="{l s='On sale' mod='lookbook'}" class="on_sale_img"/>
								<span class="on_sale">{l s='On sale!' mod='lookbook'}</span>
							
							
							{elseif $product.pObj->specificPrice AND $product.pObj->specificPrice.reduction AND $productPriceWithoutReduction > $productPrice}
								<span class="discount">{l s='Reduced price!' mod='lookbook'}</span>
							{/if}
							
							
							<br />
							<span class="our_price_display">
							
							
							{if $priceDisplay >= 0 && $priceDisplay <= 2}
								<span id="our_price_display_{$key}">{convertPrice price=$productPrice}</span>
									{if $product.attributes.tax_enabled  && ((isset($display_tax_label) && $display_tax_label == 1) OR !isset($display_tax_label))}
										{if $priceDisplay == 1}{l s='tax excl.' mod='lookbook'}{else}{l s='tax incl.' mod='lookbook'}{/if}
									{/if}
							{/if}
							
							
							</span>
							{if $priceDisplay == 2}
								<br />
								<span id="pretaxe_price"><span id="pretaxe_price_display_{$key}">{convertPrice price=$product.pObj->getPrice(false, $smarty.const.NULL, 2)}</span>&nbsp;{l s='tax excl.' mod='lookbook'}</span>
							{/if}
							
							
							<br />
						</p>
						
						
							{if $product.pObj->specificPrice AND $product.pObj->specificPrice.reduction}
								<p id="old_price_{$key}"><span class="bold">
								{if $priceDisplay >= 0 && $priceDisplay <= 2}
									{if $productPriceWithoutReduction > $productPrice}
										<span id="old_price_display_{$key}" class="old_price_display">{convertPrice price=$productPriceWithoutReduction}</span>
											{if $product.attributes.tax_enabled && $display_tax_label == 1}
												{if $priceDisplay == 1}{l s='tax excl.' mod='lookbook'}{else}{l s='tax incl.' mod='lookbook'}{/if}
											{/if}
									{/if}
								{/if}
								</span>
								</p>

							{/if}
							{if $product.pObj->specificPrice AND $product.pObj->specificPrice.reduction_type == 'percentage'}
								<p id="reduction_percent">{l s='(price reduced by' mod='lookbook'} <span id="reduction_percent_display">{$product.pObj->specificPrice.reduction*100}</span> %{l s=')' mod='lookbook'}</p>
							{/if}
							{if $product.attributes.packItems|@count}
								<p class="pack_price">{l s='instead of' mod='lookbook'} <span style="text-decoration: line-through;">{convertPrice price=$product.pObj->getNoPackPrice()}</span></p>
								<br class="clear" />
							{/if}
							{if $product.pObj->ecotax != 0}
								<p class="price-ecotax">{l s='include' mod='lookbook'} <span id="ecotax_price_display">{if $priceDisplay == 2}{$ecotax_tax_exc|convertAndFormatPrice}{else}{$ecotax_tax_inc|convertAndFormatPrice}{/if}</span> {l s='for green tax' mod='lookbook'}
									{if $product.pObj->specificPrice AND $product.pObj->specificPrice.reduction}
									<br />{l s='(not impacted by the discount)' mod='lookbook'}
									{/if}
								</p>
							{/if}
							{if !empty($product.pObj->unity) && $product.pObj->unit_price_ratio > 0.000000}
							    {math equation="pprice / punit_price"  pprice=$productPrice  punit_price=$product.pObj->unit_price_ratio assign=unit_price}
								<p class="unit-price"><span id="unit_price_display_{$key}">{convertPrice price=$unit_price}</span> {l s='per' mod='lookbook'} {$product.pObj->unity|escape:'htmlall':'UTF-8'}</p>
							{/if}
							{*close if for show price*}
						{/if}
						
						<!-- quantity wanted -->
						<p class="lb_quantity" id="quantity_wanted_p_{$key}"{if (!$product.attributes.allow_oosp && $product.pObj->quantity <= 0) OR !$product.pObj->available_for_order OR $PS_CATALOG_MODE} style="display: none;"{/if}>
							<label>{l s='Quantity :' mod='lookbook'}</label>
							<input type="text" name="qty" id="quantity_wanted_{$key}" class="text" value="{if isset($quantityBackup)}{$quantityBackup|intval}{else}{if $product.pObj->minimal_quantity > 1}{$product.pObj->minimal_quantity}{else}1{/if}{/if}" size="2" maxlength="3" {if $product.pObj->minimal_quantity > 1}onkeyup="checkMinimalQuantity({$product.pObj->minimal_quantity});"{/if} />
						</p>

						<!-- minimal quantity wanted -->
						<p id="minimal_quantity_wanted_p_{$key}"{if $product.pObj->minimal_quantity <= 1 OR !$product.pObj->available_for_order OR $PS_CATALOG_MODE} style="display: none;"{/if}>{l s='You must add ' mod='lookbook'} <b id="minimal_quantity_label_{$key}">{$product.pObj->minimal_quantity}</b> {l s=' as a minimum quantity to buy this product.' mod='lookbook'}</p>
						{if $product.pObj->minimal_quantity > 1}
						<script type="text/javascript">
							checkMinimalQuantity();
						</script>
						{/if}
						<!-- If you want to show Availability, swith to display block.-->
						<div style="display:block;">
						<!-- availability -->
							<p id="availability_statut_{$key}"{if ($product.pObj->quantity <= 0 && !$product.pObj->available_later && $product.attributes.allow_oosp) OR ($product.pObj->quantity > 0 && !$product.pObj->available_now) OR !$product.pObj->available_for_order OR $PS_CATALOG_MODE} style="display: none;"{/if}>
								<span id="availability_label">{l s='Availability:' mod='lookbook'}</span>
								<span id="availability_value_{$key}"{if $product.pObj->quantity <= 0} class="warning_inline"{/if}>
									{if $product.pObj->quantity <= 0}{if $product.attributes.allow_oosp}{$product.pObj->available_later}{else}{l s='This product is no longer in stock' mod='lookbook'}{/if}{else}{$product.pObj->available_now}{/if}
								</span>
							</p>
						</div>
						
						<!-- If you want to show the number of items in stock, swith to display block.-->
						<div style="display:block;">
							<!-- number of item in stock -->
							{if ($product.attributes.display_qties == 1 && !$PS_CATALOG_MODE && $product.pObj->available_for_order)}
							<p id="pQuantityAvailable_{$key}"{if $product.pObj->quantity <= 0} style="display: none;"{/if}>
								<span id="quantityAvailable_{$key}">{$product.pObj->quantity|intval}</span>
								<span {if $product.pObj->quantity > 1} style="display: none;"{/if} id="quantityAvailableTxt_{$key}">{l s='item in stock' mod='lookbook'}</span>
								<span {if $product.pObj->quantity == 1} style="display: none;"{/if} id="quantityAvailableTxtMultiple_{$key}">{l s='items in stock' mod='lookbook'}</span>
							</p>
							{/if}
						</div>

						{if isset($product.attributes.groups)}
						<!-- attributes -->
						<div class="lb_attributes" id="attributes_{$key}">
							<table>
						{foreach from=$product.attributes.groups key=id_attribute_group item=group}
								<tr>
						{if $group.attributes|@count}
									<td>
										<label for="group_{$id_attribute_group|intval}">{$group.name|escape:'htmlall':'UTF-8'} :</label>
									</td>
									{assign var="groupName" value="group_$id_attribute_group"}
									<td>
									<select class="lb_attribute" name="{$groupName}" id="group_{$id_attribute_group|intval}" onchange="javascript:pAttributes_{$key}.findCombination();{if $product.attributes.colors|@count > 0}$('#wrapResetImages').show('slow');{/if};">
										{foreach from=$group.attributes key=id_attribute item=group_attribute}
											<option value="{$id_attribute|intval}"{if (isset($smarty.get.$groupName) && $smarty.get.$groupName|intval == $id_attribute) || $group.default == $id_attribute} selected="selected"{/if} title="{$group_attribute|escape:'htmlall':'UTF-8'}">{$group_attribute|escape:'htmlall':'UTF-8'}</option>
										{/foreach}
									</select>
									</td>
						{/if}
								</tr>
						{/foreach}
							</table>
						</div>
						{/if}

						<div style="clear:both"></div>
						
						<p{if (!$product.attributes.allow_oosp && $product.pObj->quantity <= 0) OR !$product.pObj->available_for_order OR (isset($restricted_country_mode) AND $restricted_country_mode) OR $PS_CATALOG_MODE} style="display: none;"{/if} id="add_to_cart_{$key}" class="buttons_bottom_block lb_submit_button"><input type="submit" name="Submit" value="{l s='Add to cart' mod='lookbook'}" class="exclusive" /></p>
						<div class="clear"></div>
				
				</div>
			</form>
			
			
{*			
			<div class="right_block">
			
				{if isset($product.on_sale) && $product.on_sale && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}<span class="on_sale">{l s='On sale!' mod='lookbook'}</span>
				{elseif isset($product.reduction) && $product.reduction && isset($product.show_price) && $product.show_price && !$PS_CATALOG_MODE}<span class="discount">{l s='Reduced price!' mod='lookbook'}</span>{/if}
				{if isset($product.online_only) && $product.online_only}<span class="online_only">{l s='Online only!' mod='lookbook'}</span>{/if}
			
			
			
				{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
				<div>
					{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}<span class="price" style="display: inline;">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span><br />{/if}
					{if isset($product.available_for_order) && $product.available_for_order && !isset($restricted_country_mode)}<span class="availability">{if ($product.allow_oosp || $product.quantity > 0)}{l s='Available' mod='lookbook'}{elseif (isset($product.quantity_all_versions) && $product.quantity_all_versions > 0)}{l s='Product available with different options' mod='lookbook'}{else}{l s='Out of stock' mod='lookbook'}{/if}</span>{/if}
				</div>
				{/if}
			
			
				{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
					{if ($product.allow_oosp || $product.quantity > 0)}
						<a class="button ajax_add_to_cart_button exclusive" rel="ajax_id_product_{$product.id_product|intval}" href="{$link->getPageLink('cart.php')}?add&amp;id_product={$product.id_product|intval}{if isset($static_token)}&amp;token={$static_token}{/if}" title="{l s='Add to cart' mod='lookbook'}">{l s='Add to cart' mod='lookbook'}</a>
					{else}
							<span class="exclusive">{l s='Add to cart' mod='lookbook'}</span>
					{/if}
				{/if}
				
			</div>
			
*}			
			
		</li>


{*




			<p class="warning_inline" id="last_quantities_{$key}"{if ($product.pObj->quantity > $product.attributes.last_qties OR $product.pObj->quantity <= 0) OR $product.attributes.allow_oosp OR !$product.pObj->available_for_order OR $PS_CATALOG_MODE} style="display: none;"{/if} >{l s='Warning: Last items in stock!' mod='lookbook'}</p>

			{if $product.pObj->online_only}
				<p>{l s='Online only' mod='lookbook'}</p>
			{/if}

			<p{if (!$product.attributes.allow_oosp && $product.pObj->quantity <= 0) OR !$product.pObj->available_for_order OR (isset($restricted_country_mode) AND $restricted_country_mode) OR $PS_CATALOG_MODE} style="display: none;"{/if} id="add_to_cart" class="buttons_bottom_block"><input type="submit" name="Submit" value="{l s='Add to cart' mod='lookbook'}" class="exclusive" /></p>
			{if isset($HOOK_PRODUCT_ACTIONS) && $HOOK_PRODUCT_ACTIONS}{$HOOK_PRODUCT_ACTIONS}{/if}
			<div class="clear"></div>
		</form>		
		
		
*}	
		
		

	{/foreach}
	</ul>
	<!-- /Products list -->
{/if}


{*
<!-- JavaScript Vars -->
<script type="text/javascript">

	var myArray = {literal}[]{/literal};
	myArray[{$key}] = [{literal}{{/literal}'currencySign' : '{$product.attributes.currencySign|html_entity_decode:2:"UTF-8"}'{literal}}{/literal}];
	var currencyRate = '{$product.attributes.currencyRate|floatval}';
	var currencyFormat = '{$product.attributes.currencyFormat|intval}';
	var currencyBlank = '{$product.attributes.currencyBlank|intval}';
	var reduction_percent = {if $product.pObj->specificPrice AND $product.pObj->specificPrice.reduction AND $product.pObj->specificPrice.reduction_type == 'percentage'}{$product.pObj->specificPrice.reduction*100}{else}0{/if};
	var reduction_price = {if $product.pObj->specificPrice AND $product.pObj->specificPrice.reduction AND $product.pObj->specificPrice.reduction_type == 'amount'}{$product.pObj->specificPrice.reduction}{else}0{/if};
	var taxRate = {$product.attributes.tax_rate|floatval};
	var ecotaxTax_rate = {$product.attributes.ecotaxTax_rate};
	var default_eco_tax = {$product.pObj->ecotax};
	var productAvailableForOrder = '{$product.pObj->available_for_order}';
	var allowBuyWhenOutOfStock = {if $product.attributes.allow_oosp == 1}true{else}false{/if};
	var availableNowValue = '{$product.pObj->available_now|escape:'quotes':'UTF-8'}';
	var maxQuantityToAllowDisplayOfLastQuantityMessage = {$product.attributes.last_qties};
	var quantitiesDisplayAllowed = {if $product.attributes.display_qties == 1}true{else}false{/if};
	var productReference = '{$product.pObj->reference|escape:'htmlall':'UTF-8'}';
	var productShowPrice = '{$product.pObj->show_price}';
	var displayPrice = {$product.attributes.priceDisplay};
	var noTaxForThisProduct = false;
	var productPriceTaxExcluded = {$product.pObj->getPriceWithoutReduct(true)|default:'null'} - {$product.pObj->ecotax};
	var group_reduction = '{$product.attributes.group_reduction}';
	var productUnitPriceRatio = '{$product.pObj->unit_price_ratio}';
	var specific_price = {if $product.pObj->specificPrice AND $product.pObj->specificPrice.price}{$product.pObj->specificPrice.price}{else}0{/if};
</script>
*}
