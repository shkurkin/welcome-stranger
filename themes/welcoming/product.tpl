{*
* 2007-2013 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2013 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{include file="$tpl_dir./errors.tpl"}
{if $errors|@count == 0}
    <script type="text/javascript" src="/js/jquery/jquery-1.7.2.min.js"></script>
    <script type="text/javascript">
        // PrestaShop internal settings
        var currencySign = '{$currencySign|html_entity_decode:2:"UTF-8"}';
        var currencyRate = '{$currencyRate|floatval}';
        var currencyFormat = '{$currencyFormat|intval}';
        var currencyBlank = '{$currencyBlank|intval}';
        var taxRate = {$tax_rate|floatval};
        var jqZoomEnabled = {if $jqZoomEnabled}true{else}false{/if};
        // Combinations attributes informations
         var attributesCombinations = new Array();
            //JS Hook
            var oosHookJsCodeFunctions = new Array();

            // Parameters
            var id_product = '{$product->id|intval}';
            var productHasAttributes = {if isset($groups)}true{else}false{/if};
                var quantitiesDisplayAllowed = {if $display_qties == 1}true{else}false{/if};
                    var quantityAvailable = {if $display_qties == 1 && $product->quantity}{$product->quantity}{else}0{/if};
                        var allowBuyWhenOutOfStock = {if $allow_oosp == 1}true{else}false{/if};
                            var availableNowValue = '{$product->available_now|escape:'quotes':'UTF-8'}';
                            var availableLaterValue = '{$product->available_later|escape:'quotes':'UTF-8'}';
                            var productPriceTaxExcluded = {$product->getPriceWithoutReduct(true)|default:'null'} - {$product->ecotax};
                            var productBasePriceTaxExcluded = {$product->base_price} - {$product->ecotax};

                            var reduction_percent = {if $product->specificPrice AND $product->specificPrice.reduction AND $product->specificPrice.reduction_type == 'percentage'}{$product->specificPrice.reduction*100}{else}0{/if};
                                var reduction_price = {if $product->specificPrice AND $product->specificPrice.reduction AND $product->specificPrice.reduction_type == 'amount'}{$product->specificPrice.reduction|floatval}{else}0{/if};
                                    var specific_price = {if $product->specificPrice AND $product->specificPrice.price}{$product->specificPrice.price}{else}0{/if};
                                        var product_specific_price = new Array();
        {foreach from=$product->specificPrice key='key_specific_price' item='specific_price_value'}
                                        product_specific_price['{$key_specific_price}'] = '{$specific_price_value}';
        {/foreach}
                                        var specific_currency = {if $product->specificPrice AND $product->specificPrice.id_currency}true{else}false{/if};
                                            var group_reduction = '{$group_reduction}';
                                            var default_eco_tax = {$product->ecotax};
                                            var ecotaxTax_rate = {$ecotaxTax_rate};
                                            var currentDate = '{$smarty.now|date_format:'%Y-%m-%d %H:%M:%S'}';
                                            var maxQuantityToAllowDisplayOfLastQuantityMessage = {$last_qties};
                                            var noTaxForThisProduct = {if $no_tax == 1}true{else}false{/if};
                                                var displayPrice = {$priceDisplay};
                                                var productReference = '{$product->reference|escape:'htmlall':'UTF-8'}';
                                                var productAvailableForOrder = {if (isset($restricted_country_mode) AND $restricted_country_mode) OR $PS_CATALOG_MODE}'0'{else}'{$product->available_for_order}'{/if};
                                                        var productShowPrice = '{if !$PS_CATALOG_MODE}{$product->show_price}{else}0{/if}';
                                                            var productUnitPriceRatio = '{$product->unit_price_ratio}';
                                                            var idDefaultImage = {if isset($cover.id_image_only)}{$cover.id_image_only}{else}0{/if};
                                                                var stock_management = {$stock_management|intval};
        {if !isset($priceDisplayPrecision)}
            {assign var='priceDisplayPrecision' value=2}
        {/if}
        {if !$priceDisplay || $priceDisplay == 2}
            {assign var='productPrice' value=$product->getPrice(true, $smarty.const.NULL, $priceDisplayPrecision)}
            {assign var='productPriceWithoutReduction' value=$product->getPriceWithoutReduct(false, $smarty.const.NULL)}
        {elseif $priceDisplay == 1}
            {assign var='productPrice' value=$product->getPrice(false, $smarty.const.NULL, $priceDisplayPrecision)}
            {assign var='productPriceWithoutReduction' value=$product->getPriceWithoutReduct(true, $smarty.const.NULL)}
        {/if}


                                                                var productPriceWithoutReduction = '{$productPriceWithoutReduction}';
                                                                var productPrice = '{$productPrice}';

                                                                // Customizable field
                                                                var img_ps_dir = '{$img_ps_dir}';
                                                                var customizationFields = new Array();
                                                                        $( document ).ready(function(){
        {assign var='imgIndex' value=0}
        {assign var='textFieldIndex' value=0}
        {foreach from=$customizationFields item='field' name='customizationFields'}
            {assign var="key" value="pictures_`$product->id`_`$field.id_customization_field`"}
                                                                customizationFields[{$smarty.foreach.customizationFields.index|intval}] = new Array();
                                                                customizationFields[{$smarty.foreach.customizationFields.index|intval}][0] = '{if $field.type|intval == 0}img{$imgIndex++}{else}textField{$textFieldIndex++}{/if}';
                                                                    customizationFields[{$smarty.foreach.customizationFields.index|intval}][1] = {if $field.type|intval == 0 && isset($pictures.$key) && $pictures.$key}2{else}{$field.required|intval}{/if};
        {/foreach}

                                                                        // Images
                                                                        var img_prod_dir = '{$img_prod_dir}';
                                                                        var combinationImages = new Array();

        {if isset($combinationImages)}
            {foreach from=$combinationImages item='combination' key='combinationId' name='f_combinationImages'}
                                                                        combinationImages[{$combinationId}] = new Array();
                {foreach from=$combination item='image' name='f_combinationImage'}
                                                                        combinationImages[{$combinationId}][{$smarty.foreach.f_combinationImage.index}] = {$image.id_image|intval};
                {/foreach}
            {/foreach}
        {/if}

                                                                        combinationImages[0] = new Array();
        {if isset($images)}
            {foreach from=$images item='image' name='f_defaultImages'}
                                                                        combinationImages[0][{$smarty.foreach.f_defaultImages.index}] = {$image.id_image};
            {/foreach}
        {/if}

                                                                        // Translations
                                                                        var doesntExist = '{l s='This combination does not exist for this product. Please select another combination.' js=1}';
                                                                        var doesntExistNoMore = '{l s='This product is no longer in stock' js=1}';
                                                                        var doesntExistNoMoreBut = '{l s='with those attributes but is available with others.' js=1}';
                                                                        var uploading_in_progress = '{l s='Uploading in progress, please be patient.' js=1}';
                                                                        var fieldRequired = '{l s='Please fill in all the required fields before saving your customization.' js=1}';
{$badImages = []}
    {$badColor = []}
        {if isset($groups)}
                                                                        // Combinations
            {foreach from=$combinations key=idCombination item=combination}
                                                                        var specific_price_combination = new Array();
                                                                        var available_date = new Array();
                                                                        specific_price_combination['reduction_percent'] = {if $combination.specific_price AND $combination.specific_price.reduction AND $combination.specific_price.reduction_type == 'percentage'}{$combination.specific_price.reduction*100}{else}0{/if};
                                                                            specific_price_combination['reduction_price'] = {if $combination.specific_price AND $combination.specific_price.reduction AND $combination.specific_price.reduction_type == 'amount'}{$combination.specific_price.reduction}{else}0{/if};
                                                                                specific_price_combination['price'] = {if $combination.specific_price AND $combination.specific_price.price}{$combination.specific_price.price}{else}0{/if};
                                                                                    specific_price_combination['reduction_type'] = '{if $combination.specific_price}{$combination.specific_price.reduction_type}{/if}';
                                                                                    specific_price_combination['id_product_attribute'] = {if $combination.specific_price}{$combination.specific_price.id_product_attribute|intval}{else}0{/if};
                                                                                        available_date['date'] = '{$combination.available_date}';
                                                                                        available_date['date_formatted'] = '{dateFormat date=$combination.available_date full=false}';
                                                                                        addCombination({$idCombination|intval}, new Array({$combination.list}), {$combination.quantity}, {$combination.price}, {$combination.ecotax}, {$combination.id_image}, '{$combination.reference|addslashes}', {$combination.unit_impact}, {$combination.minimal_quantity}, available_date, specific_price_combination);
                                                                                        
                                                                                        {if $combination.quantity <= 0}
                                                                                            {$badImages[$combination.id_image] = 1}
                                                                                                {$badColor[$combination.attributes[0]] = 1}
                                                                                                    {/if}
                                                                                                     
            {/foreach}
        {/if}
        
        {if isset($attributesCombinations)}
                                                                                        
            {foreach from=$attributesCombinations key=id item=aC}
                                                                                        tabInfos = new Array();
                                                                                        tabInfos['id_attribute'] = '{$aC.id_attribute|intval}';
                                                                                        tabInfos['attribute'] = '{$aC.attribute}';
                                                                                        tabInfos['group'] = '{$aC.group}';
                                                                                        tabInfos['id_attribute_group'] = '{$aC.id_attribute_group|intval}';
                                                                                        attributesCombinations.push(tabInfos);
            {/foreach}
        {/if}
         
});
    </script>

    <div id="primary_block" class="col-lg-12 clearBoth">

        {if isset($adminActionDisplay) && $adminActionDisplay}
            <div id="admin-action">
                <p>{l s='This product is not visible to your customers.'}
                    <input type="hidden" id="admin-action-product-id" value="{$product->id}" />
                    <input type="submit" value="{l s='Publish'}" class="exclusive" onclick="submitPublishProduct('{$base_dir}{$smarty.get.ad|escape:'htmlall':'UTF-8'}', 0, '{$smarty.get.adtoken|escape:'htmlall':'UTF-8'}')"/>
                    <input type="submit" value="{l s='Back'}" class="exclusive" onclick="submitPublishProduct('{$base_dir}{$smarty.get.ad|escape:'htmlall':'UTF-8'}', 1, '{$smarty.get.adtoken|escape:'htmlall':'UTF-8'}')"/>
                </p>
                <p id="admin-action-result"></p>
                </p>
            </div>
        {/if}

        {if isset($confirmation) && $confirmation}
            <p class="confirmation">
                {$confirmation}
            </p>
        {/if}
        {include file="$tpl_dir./breadcrumb.tpl"}
        <div class="row fixedheight">
        <!-- right infos-->
        <div id="pb-right-column" class="col-lg-8 botlign affix-top">
            <!-- product img-->
            <div id="image-block">
                {if $have_image}
                    <span id="view_full_size">
                        <img src="{$link->getImageLink($product->link_rewrite, $cover.id_image, 'large_default')|escape:'html'}"{if $jqZoomEnabled && $have_image} class="jqzoom"{/if} title="{if !empty($cover.legend)}{$cover.legend|escape:'htmlall':'UTF-8'}{else}{$product->name|escape:'htmlall':'UTF-8'}{/if}" alt="{if !empty($cover.legend)}{$cover.legend|escape:'htmlall':'UTF-8'}{else}{$product->name|escape:'htmlall':'UTF-8'}{/if}" id="bigpic" width="{$largeSize.width}" height="{$largeSize.height}"/>				
                    </span>
                {else}
                    <span id="view_full_size">
                        <img src="{$img_prod_dir}{$lang_iso}-default-large_default.jpg" id="bigpic" alt="" title="{$product->name|escape:'htmlall':'UTF-8'}" width="{$largeSize.width}" height="{$largeSize.height}" />
                    </span>
                {/if}
            </div>
            <div id="thumbs_list" class="hidden">
			<ul id="thumbs_list_frame">
			{if isset($images)}
				{foreach from=$images item=image name=thumbnails}
					{assign var=imageIds value="`$product->id`-`$image.id_image`"}
					{if !empty($image.legend)}
						{assign var=imageTitlte value=$image.legend|escape:'htmlall':'UTF-8'}
					{else}
						{assign var=imageTitlte value=$product->name|escape:'htmlall':'UTF-8'}
					{/if}
					<li id="thumbnail_{$image.id_image}">
						<a href="{$link->getImageLink($product->link_rewrite, $imageIds, 'thickbox_default')|escape:'html'}" rel="other-views" class="thickbox{if $smarty.foreach.thumbnails.first} shown{/if}" title="{$imageTitlte}">
							<img id="thumb_{$image.id_image}" src="{$link->getImageLink($product->link_rewrite, $imageIds, 'medium_default')|escape:'html'}" alt="{$imageTitlte}" title="{$imageTitlte}" height="{$mediumSize.height}" width="{$mediumSize.width}" />
						</a>
					</li>
				{/foreach}
			{/if}
			</ul>
		</div>
        </div>

        <!-- left infos-->
        <div id="pb-left-column" class="col-lg-4 botlign">
            <div class="row">
                <div class="col-lg-12">
                     <div id='headerText'>{$product->name|escape:'htmlall':'UTF-8'}</div>
                        <div id='manufacturerText'>{$product->manufacturer_name|escape:'htmlall':'UTF-8'}</div>


            <div class="price">
                <p class="our_price_display">
                    {if $priceDisplay >= 0 && $priceDisplay <= 2}
                        <span id="our_price_display">{convertPrice price=$productPrice}</span>
                        <!--{if $tax_enabled  && ((isset($display_tax_label) && $display_tax_label == 1) OR !isset($display_tax_label))}
                {if $priceDisplay == 1}{l s='tax excl.'}{else}{l s='tax incl.'}{/if}
            {/if}-->
        {/if}
    </p>

    {if $product->on_sale}
        <img src="{$img_dir}onsale_{$lang_iso}.gif" alt="{l s='On sale'}" class="on_sale_img"/>
        <span class="on_sale">{l s='On sale!'}</span>
    {elseif $product->specificPrice AND $product->specificPrice.reduction AND $productPriceWithoutReduction > $productPrice}
        <span class="discount">{l s='Reduced price!'}</span>
    {/if}
    {if $priceDisplay == 2}
        <br />
        <span id="pretaxe_price"><span id="pretaxe_price_display">{convertPrice price=$product->getPrice(false, $smarty.const.NULL)}</span>&nbsp;{l s='tax excl.'}</span>
    {/if}
</div>
<p id="reduction_percent" {if !$product->specificPrice OR $product->specificPrice.reduction_type != 'percentage'} style="display:none;"{/if}><span id="reduction_percent_display">{if $product->specificPrice AND $product->specificPrice.reduction_type == 'percentage'}-{$product->specificPrice.reduction*100}%{/if}</span></p>
<p id="reduction_amount" {if !$product->specificPrice OR $product->specificPrice.reduction_type != 'amount' || $product->specificPrice.reduction|intval ==0} style="display:none"{/if}>
    <span id="reduction_amount_display">
        {if $product->specificPrice AND $product->specificPrice.reduction_type == 'amount' AND $product->specificPrice.reduction|intval !=0}
            -{convertPrice price=$productPriceWithoutReduction-$productPrice|floatval}
        {/if}
    </span>
</p>
<p id="old_price"{if !$product->specificPrice || !$product->specificPrice.reduction} class="hidden"{/if}>
    {if $priceDisplay >= 0 && $priceDisplay <= 2}
        <span id="old_price_display">{if $productPriceWithoutReduction > $productPrice}{convertPrice price=$productPriceWithoutReduction}{/if}</span>
        <!-- {if $tax_enabled && $display_tax_label == 1}{if $priceDisplay == 1}{l s='tax excl.'}{else}{l s='tax incl.'}{/if}{/if} -->
    {/if}
</p>
{if $packItems|@count && $productPrice < $product->getNoPackPrice()}
    <p class="pack_price">{l s='Instead of'} <span style="text-decoration: line-through;">{convertPrice price=$product->getNoPackPrice()}</span></p>
    <br class="clear" />
{/if}
{if $product->ecotax != 0}
    <p class="price-ecotax">{l s='Include'} <span id="ecotax_price_display">{if $priceDisplay == 2}{$ecotax_tax_exc|convertAndFormatPrice}{else}{$ecotax_tax_inc|convertAndFormatPrice}{/if}</span> {l s='For green tax'}
        {if $product->specificPrice AND $product->specificPrice.reduction}
            <br />{l s='(not impacted by the discount)'}
        {/if}
    </p>
{/if}
{if !empty($product->unity) && $product->unit_price_ratio > 0.000000}
    {math equation="pprice / punit_price"  pprice=$productPrice  punit_price=$product->unit_price_ratio assign=unit_price}
    <p class="unit-price"><span id="unit_price_display">{convertPrice price=$unit_price}</span> {l s='per'} {$product->unity|escape:'htmlall':'UTF-8'}</p>
{/if}
{*{if isset($colors) && $colors}
<!-- colors -->
<div id="color_picker">
<p>{l s='Pick a color:' js=1}</p>
<div class="clear"></div>
<ul id="color_to_pick_list" class="clearfix">
{foreach from=$colors key='id_attribute' item='color'}
<li><a id="color_{$id_attribute|intval}" class="color_pick" style="background: {$color.value};" onclick="updateColorSelect({$id_attribute|intval});$('#wrapResetImages').show('slow');" title="{$color.name}">{if file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}<img src="{$img_col_dir}{$id_attribute}.jpg" alt="{$color.name}" width="20" height="20" />{/if}</a></li>
{/foreach}
</ul>
<div class="clear"></div>
</div>
{/if}*}
</div>
</div>
{if ($product->show_price AND !isset($restricted_country_mode)) OR isset($groups) OR $product->reference OR (isset($HOOK_PRODUCT_ACTIONS) && $HOOK_PRODUCT_ACTIONS)}
    <div class="row">
    <div class="col-lg-12">
    <!-- add to cart form-->
    <form id="buy_block" {if $PS_CATALOG_MODE AND !isset($groups) AND $product->quantity > 0}class="hidden" style="padding-bottom:0px;"{/if} action="{$link->getPageLink('cart')|escape:'html'}" method="post">

        <!-- hidden datas -->
        <p class="hidden">
            <input type="hidden" name="token" value="{$static_token}" />
            <input type="hidden" name="id_product" value="{$product->id|intval}" id="product_page_product_id" />
            <input type="hidden" name="add" value="1" />
            <input type="hidden" name="id_product_attribute" id="idCombination" value="" />
        </p>

        <div class="product_attributes">
            {if isset($groups)}
                <!-- attributes -->
                <div id="attributes">
                    <div class="clear"></div>
                    {foreach from=$groups key=id_attribute_group item=group}
                        {if $group.attributes|@count}
                            {assign var="groupName" value="group_$id_attribute_group"}
                            <div class="attribute_fields">
                                <div class="attribute_list {cycle values="leftProductBlock,rightProductBlock"}">
                                    <p class="attribute_label">{$group.name|escape:'htmlall':'UTF-8'} :&nbsp;</p>
                                    {if ($group.group_type == 'select')}
                                        <select name="{$groupName}" id="group_{$id_attribute_group|intval}" class="attribute_select" onchange="findCombination();
                                                getProductAttribute();">
                                            {foreach from=$group.attributes key=id_attribute item=group_attribute}
                                                <option value="{$id_attribute|intval}"{if (isset($smarty.get.$groupName) && $smarty.get.$groupName|intval == $id_attribute) || $group.default == $id_attribute} selected="selected"{/if} title="{$group_attribute|escape:'htmlall':'UTF-8'}">{$group_attribute|escape:'htmlall':'UTF-8'}</option>
                                            {/foreach}
                                        </select>
                                    {elseif ($group.group_type == 'color')}
                                        <ul id="color_to_pick_list" class="clearfix">
                                            {assign var="default_colorpicker" value=""}
                                            {foreach from=$group.attributes key=id_attribute item=group_attribute}
                                                {if !isset($badColor[$id_attribute])}
                                                    <li{if $group.default == $id_attribute} class="selected"{/if}>
                                                        <a id="color_{$id_attribute|intval}" class="color_pick{if ($group.default == $id_attribute)} selected{/if}" style="background: {$colors.$id_attribute.value};" title="{$colors.$id_attribute.name}" onclick="colorPickerClick(this);
                                                                getProductAttribute();">
                                                            {if file_exists($col_img_dir|cat:$id_attribute|cat:'.jpg')}
                                                                <img src="{$img_col_dir}{$id_attribute}.jpg" alt="{$colors.$id_attribute.name}" width="20" height="20" /><br />
                                                            {/if}
                                                        </a>
                                                    </li>
                                                    {if ($group.default == $id_attribute)}
                                                        {$default_colorpicker = $id_attribute}
                                                    {/if}
                                                {/if}
                                            {/foreach}
                                        </ul>
                                        <input type="hidden" class="color_pick_hidden" name="{$groupName}" value="{$default_colorpicker}" />
                                    {elseif ($group.group_type == 'radio')}
                                        <ul>
                                            {foreach from=$group.attributes key=id_attribute item=group_attribute}
                                                <li>
                                                    <input type="radio" class="attribute_radio" name="{$groupName}" value="{$id_attribute}" {if ($group.default == $id_attribute)} checked="checked"{/if} onclick="findCombination();
                                                            getProductAttribute();" />
                                                    <span>{$group_attribute|escape:'htmlall':'UTF-8'}</span>
                                                </li>
                                            {/foreach}
                                        </ul>
                                    {/if}
                                </div>
                            </div>
                        {/if}
                    {/foreach}
                </div>
            {/if}        
</div>
    </div>
    </div>
        <div class="last_line row">
            <div class="leftProductBlock col-lg-3">
            <!-- quantity wanted -->
            <p id="quantity_wanted_p"{if (!$allow_oosp && $product->quantity <= 0) OR $virtual OR !$product->available_for_order OR $PS_CATALOG_MODE} style="display: none;"{/if} style="padding-bottom: 0px;">
            <p style="inline-block">{l s='Qty:'}</p>
                <input type="text" name="qty" id="quantity_wanted" class="text" value="{if isset($quantityBackup)}{$quantityBackup|intval}{else}{if $product->minimal_quantity > 1}{$product->minimal_quantity}{else}1{/if}{/if}" size="2" maxlength="3" {if $product->minimal_quantity > 1}onkeyup="checkMinimalQuantity({$product->minimal_quantity});"{/if} />
            </p>

            <!-- minimal quantity wanted -->
            <p id="minimal_quantity_wanted_p"{if $product->minimal_quantity <= 1 OR !$product->available_for_order OR $PS_CATALOG_MODE} style="display: none;"{/if}>
                {l s='This product is not sold individually. You must select at least'} <b id="minimal_quantity_label">{$product->minimal_quantity}</b> {l s='quantity for this product.'}
            </p>
            {if $product->minimal_quantity > 1}
                <script type="text/javascript">
                    checkMinimalQuantity();
                </script>
            {/if}

            <!-- Out of stock hook -->
            <div id="oosHook"{if $product->quantity > 0} style="display: none;"{/if}>
                {$HOOK_PRODUCT_OOS}
            </div>
            </div>
            <div class="content_prices rightProductBlock col-lg-6">
                <!-- prices -->
                {if $product->show_price AND !isset($restricted_country_mode) AND !$PS_CATALOG_MODE}

                    {if $product->online_only}
                        <p class="online_only">{l s='Online only'}</p>
                    {/if}

                    {*close if for show price*}
                {/if}
                <p id="add_to_cart" {if (!$allow_oosp && $product->quantity <= 0) OR !$product->available_for_order OR (isset($restricted_country_mode) AND $restricted_country_mode) OR $PS_CATALOG_MODE}style="display:none"{/if} class="buttons_bottom_block">
                    <input type="submit" name="Submit" value="{l s='Add to cart'}" id="clearbutton" class="exclusive" />
                </p>
            {if isset($HOOK_PRODUCT_ACTIONS) && $HOOK_PRODUCT_ACTIONS}{$HOOK_PRODUCT_ACTIONS}{/if}

        </div>
    </div>

</form>
{/if}
{if isset($HOOK_EXTRA_RIGHT) && $HOOK_EXTRA_RIGHT}{$HOOK_EXTRA_RIGHT}{/if}
</div>
        </div>
{if $product->description OR $packItems|@count > 0}
    <div id="row">
    <div id="short_description_block" class="col-lg-8">
        {if $product->description}
            <ul class='descriptorTags'>
                <li><a href='#tab1'>DESCRIPTION</a></li>
                <li><a href='#tab2'>SIZING/SHIPPING</a></li>
            </ul>
            <div id='tab1'>
                <div id="short_description_content" class="rte align_justify">{$product->description}</div>
            </div>
            <div id='tab2'>
                <div>Horray, I am some sizing content</div>
            </div>
        {/if}
    </div>
    <div class="col-lg-4"></div>
    </div>
{/if}

{if isset($images)}
    <div id="row">
        <div id='imageBlock' class="col-lg-12" style="padding-left: 0px">
            {foreach from=$images item=image name=thumbnails}
                {if !isset($badImages[$image.id_image])}
                    {if $image.cover != "1"}
                        {assign var=imageIds value="`$product->id`-`$image.id_image`"}
                        <img src="{$link->getImageLink($product->link_rewrite, $imageIds, 'large_default')|escape:'html'}"/><br/>
                    {/if}
                {/if}
            {/foreach}
        </div>
    </div>
{/if}
</div>

{if (isset($quantity_discounts) && count($quantity_discounts) > 0)}
    <!-- quantity discount -->
    <ul class="idTabs clearfix">
        <li><a href="#discount" style="cursor: pointer" class="selected">{l s='Sliding scale pricing'}</a></li>
    </ul>
    <div id="quantityDiscount">
        <table class="std">
            <thead>
                <tr>
                    <th>{l s='Product'}</th>
                    <th>{l s='From (qty)'}</th>
                    <th>{if Configuration::get('PS_DISPLAY_DISCOUNT_PRICE')}{l s='Price'}{else}{l s='Discount'}{/if}</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$quantity_discounts item='quantity_discount' name='quantity_discounts'}
                    <tr id="quantityDiscount_{$quantity_discount.id_product_attribute}" class="quantityDiscount_{$quantity_discount.id_product_attribute}">
                        <td>
                            {if (isset($quantity_discount.attributes) && ($quantity_discount.attributes))}
                                {$product->getProductName($quantity_discount.id_product, $quantity_discount.id_product_attribute)}
                            {else}
                                {$product->getProductName($quantity_discount.id_product)}
                            {/if}
                        </td>
                        <td>{$quantity_discount.quantity|intval}</td>
                        <td>
                            {if $quantity_discount.price >= 0 OR $quantity_discount.reduction_type == 'amount'}
                                {if Configuration::get('PS_DISPLAY_DISCOUNT_PRICE')}
                                    {convertPrice price=$productPrice-$quantity_discount.real_value|floatval}
                                {else}
                                    -{convertPrice price=$quantity_discount.real_value|floatval}
                                {/if}
                            {else}
                                {if Configuration::get('PS_DISPLAY_DISCOUNT_PRICE')}
                                    {convertPrice price = $productPrice-($productPrice*$quantity_discount.reduction)|floatval}
                                {else}
                                    -{$quantity_discount.real_value|floatval}%
                                {/if}
                            {/if}
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
{/if}
{if isset($HOOK_PRODUCT_FOOTER) && $HOOK_PRODUCT_FOOTER}{$HOOK_PRODUCT_FOOTER}{/if}

{if isset($packItems) && $packItems|@count > 0}
    <div id="blockpack">
        <h2>{l s='Pack content'}</h2>
        {include file="$tpl_dir./product-list.tpl" products=$packItems}
    </div>
{/if}
{/if}
