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
*  @version  Release: $Revision$
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<!-- Module HomeSlider -->
{if isset($homeslider)}
<script type="text/javascript">
{if isset($homeslider_slides) && $homeslider_slides|@count > 1}
	{if $homeslider.loop == 1}
		var homeslider_loop = true;
	{else}
		var homeslider_loop = false;
	{/if}
{else}
	var homeslider_loop = false;
{/if}
var homeslider_speed = {$homeslider.speed};
var homeslider_pause = {$homeslider.pause};
</script>
{/if}
{if isset($homeslider_slides)}
    <div class="row">
        <div id="generic-carousel" class="carousel slide col-lg-12" data-ride="carousel">
            <ol class="carousel-indicators">
            {foreach from=$homeslider_slides item=slide}
                    {if isset($slide.active) && $slide.active}
                            <li data-target="#generic-carousel" data-slide-to="{$slide@iteration -1}" {if $slide@iteration == 1}class="active"{/if}></li>
                    {/if}
            {/foreach}
            </ol>

            <div class="carousel-inner">`
                {foreach from=$homeslider_slides item=slide}
                    {if isset($slide.active) && $slide.active}
                        <div class="item {if $slide@iteration == 1}active{/if}">
                            <img src="{$link->getMediaLink("`$module_dir`images/`$slide.image|escape:'htmlall':'UTF-8'`")}" alt="{$slide.legend|escape:'htmlall':'UTF-8'}" />
                        </div>
                    {/if}
                {/foreach}
            </div>
            <!-- Controls -->
            <a class="left carousel-control" id="prevSlide" href="#generic-carousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" id="nextSlide" href="#generic-carousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>        
{/if}
<!-- /Module HomeSlider -->
