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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7 " lang="{$lang_iso}"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8 ie7" lang="{$lang_iso}"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9 ie8" lang="{$lang_iso}"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js ie9" lang="{$lang_iso}"> <![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$lang_iso}">
    <head>
        <title>{$meta_title|escape:'htmlall':'UTF-8'}</title>
        {if isset($meta_description) AND $meta_description}
            <meta name="description" content="{$meta_description|escape:html:'UTF-8'}" />
        {/if}
        {if isset($meta_keywords) AND $meta_keywords}
            <meta name="keywords" content="{$meta_keywords|escape:html:'UTF-8'}" />
        {/if}
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
        <meta http-equiv="content-language" content="{$meta_language}" />
        <meta name="generator" content="PrestaShop" />
        <meta name="robots" content="{if isset($nobots)}no{/if}index,{if isset($nofollow) && $nofollow}no{/if}follow" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="icon" type="image/vnd.microsoft.icon" href="{$favicon_url}?{$img_update_time}" />
                <link rel="shortcut icon" type="image/x-icon" href="{$favicon_url}?{$img_update_time}" />

                {if isset($css_files)}

                    <link href="{$css_dir}bootstrap.min.css" rel="stylesheet" type="text/css"/>
                    {foreach from=$css_files key=css_uri item=media}
                        <link href="{$css_uri}" rel="stylesheet" type="text/css" media="{$media}" />
                    {/foreach}
                {/if}
                <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
                <!--[if lt IE 9]>
                  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
                <![endif]-->
                {$HOOK_HEADER}
                </head>

                <body {if isset($page_name)}id="{$page_name|escape:'htmlall':'UTF-8'}"{/if} class="{if isset($page_name)}{$page_name|escape:'htmlall':'UTF-8'}{/if}{if $hide_left_column} hide-left-column{/if}{if $hide_right_column} hide-right-column{/if}{if $content_only} content_only{/if}" data-spy="scroll" data-target=".scrollspyNavbar" data-offset="0">
                    {if !$content_only}
                        {if isset($restricted_country_mode) && $restricted_country_mode}
                            <div id="restricted-country">
                                <p>{l s='You cannot place a new order from your country.'} <span class="bold">{$geolocation_country}</span></p>
                            </div>
                        {/if}

                        <div id="gridWrapper" class="container-fluid">

                        <div id="left_column">
                            {$HOOK_LEFT_COLUMN}
                        </div>


                            <!-- Center -->
                            <div id="page" class="col-md-12 col-lg-12 clearfix">
                                <!-- Header -->
                                <div class="row">
                                    <div id="header" class="col-md-12 col-lg-12">

                                        <!-- MAIN DROPDOWN NAV -->
                                        <div id="mainNavDropdown">
                                          <div id="mainNavToggle"><img src="https://cdn2.iconfinder.com/data/icons/flat-ui-icons-24-px/24/menu-24-512.png" width="12" id="menuOpenIcon"><img src="https://cdn2.iconfinder.com/data/icons/flat-ui-icons-24-px/24/cross-24-512.png" id="menuCloseIcon" width="12"> MENU</div>

                                          <ul id="dropdownMenu">
                                            <div class="featuredMenuBlock">
                                                <li><a href="#">SHOP</a></li>
                                                <li><a href="#">WS CLOTHING</a></li>
                                                <li><a href="#">LOOKBOOKS</a></li>
                                            </div>
                                            <div class="subMenuBlock">
                                                <li><a href="#">Blog</a></li>
                                                <li><a href="#">Trade</a></li>
                                                <li><a href="#">Press</a></li>
                                                <li><a href="#">Contact</a></li>
                                                <li><a href="#">FB IG</a></li>
                                            </div>
                                          </ul>
                                        </div>
                                        <!-- /MAIN DROPDOWN NAV -->


                                    </div>

                                    <!-- CenterColumn -->
                                    <div id="columns" class="col-md-12 col-lg-12 clearfix">
                                        <div class="row">
                                            <!-- Center -->
                                            <div id="center_column" class="col-md-12 col-lg-12">
                                                <div class="row">
                                                {/if}
