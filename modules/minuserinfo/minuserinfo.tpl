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

<!-- Block user information module HEADER -->
<div id="userFunctions">
    <div id="header_user" {if $PS_CATALOG_MODE}class="header_user_catalog"{/if}>
            <div id="signInBlock" >
                <p id="header_user_info">
                    {if $logged}
                        <a href="{$link->getPageLink('my-account', true)|escape:'html'}" title="{l s='View my customer account' mod='minuserinfo'}" class="account" rel="nofollow"><span>{$cookie->customer_firstname} {$cookie->customer_lastname}</span></a>
                        <a href="{$link->getPageLink('index', true, NULL, "mylogout")|escape:'html'}" title="{l s='Log me out' mod='minuserinfo'}" class="logout" rel="nofollow">{l s='Log out' mod='minuserinfo'}</a>
                    {else}
                        <a href="{$link->getPageLink('my-account', true)|escape:'html'}" title="{l s='Login to your customer account' mod='minuserinfo'}" class="login" rel="nofollow">{l s='SIGN IN' mod='minuserinfo'}</a>
                    {/if}
                </p>
            </div>
        </div>
    	<div id="header_nav">
    		{if !$PS_CATALOG_MODE}
            <div id="search_bar" class="userInfoIcon">
                <a href="#"></a>
            </div>
    		<div id="shopping_cart" class="userInfoIcon">
    			<a href="{$link->getPageLink($order_process, true)|escape:'html'}" title="{l s='View my shopping cart' mod='minuserinfo'}" rel="nofollow">
    			<span class="ajax_cart_quantity{if $cart_qties == 0} hidden{/if}">{$cart_qties}</span>
    			<span class="ajax_cart_product_txt hidden{if $cart_qties != 1} hidden{/if}">{l s='Product' mod='minuserinfo'}</span>
    			<span class="ajax_cart_product_txt_s hidden{if $cart_qties < 2} hidden{/if}">{l s='Products' mod='minuserinfo'}</span>
    			<span class="ajax_cart_total hidden{if $cart_qties == 0} hidden{/if}">
    				{if $cart_qties > 0}
    					{if $priceDisplay == 1}
    						{assign var='blockuser_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
    						{convertPrice price=$cart->getOrderTotal(false, $blockuser_cart_flag)}
    					{else}
    						{assign var='blockuser_cart_flag' value='Cart::BOTH_WITHOUT_SHIPPING'|constant}
    						{convertPrice price=$cart->getOrderTotal(true, $blockuser_cart_flag)}
    					{/if}
    				{/if}
    			</span>
    			<span class="ajax_cart_no_product{if $cart_qties > 0} hidden{/if}"> </span>
    			</a>
    		</div>
    		{/if}
    	</div>
        </div>
            <div class="col-lg-12">
                <form method="get" action="{$link->getPageLink('search', true)|escape:'html'}" id="searchbox">
                                <input type="hidden" name="controller" value="search">
                                <input type="hidden" name="orderby" value="position">
                                <input type="hidden" name="orderway" value="desc">
                                <input class="minsearch" type="text" id="min_search_query_top" name="search_query" value="" autocomplete="off" placeholder=" Search">
                            </form>
            </div>
        </div>
    </div>
</div>
<!-- /Block user information module HEADER -->
