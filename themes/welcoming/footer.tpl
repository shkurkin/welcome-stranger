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

{if !$content_only}
                                        </div>
                                    </div> <!--Center div -->
                                </div>
                            </div> <!-- CenterColumn -->
                        </div> <!-- Header-->


                <!-- Footer -->
                <div class="row">
                    <div id="footer" class="col-md-8 col-centered clearfix">
                        <a href="#top"><p id="backToTop">
                            <img src="http://ieeebitmesra.in/img/uparrow.png" width="24"><br>
                            BACK TO TOP</p></a>
                        {$HOOK_FOOTER}
                        <div class="row" style="padding-top:42px">
                            <div id="rowText" class="col-md-6">
                                <h4>JOIN OUR MAILING LIST:</h4>
                                <form action="#">
                                    <input type="text" id="newsletterBox" name="mailingList" placeholer="ENTER EMAIL"/>
                                    <input type="submit" id="newsletterSubmit" value="JOIN"/>
                                </form>
                            </div>
                            <div id="middleText" class="col-md-2 footerText">
                                <h4>INFO</h4>
                                <div id="footerLinkBlock">
                                    <ul>
                                    <li><a href="{$link->getCMSLink('1', 'Contact Info')}" title="{l s='Contact Info'}">{l s='Contact Info'}</a></li>
                                    <li><a href="{$link->getCMSLink('1', 'Store Policy')}" title="{l s='Store Policy'}">{l s='Store Policy'}</a></li>
                                    <li><a href="{$link->getCMSLink('1', 'Sizing Guide')}" title="{l s='Sizing Guide'}">{l s='Sizing Guide'}</a></li>
                                    <li><a href="{$link->getCMSLink('1', 'Terms of Use')}" title="{l s='Terms of Use'}">{l s='Terms of Use'}</a></li>
                                    <li><a href="{$link->getCMSLink('1', 'Privacy Policy')}" title="{l s='Privacy Policy'}">{l s='Privacy Policy'}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div id="footerLocation" class="col-md-2 footerText">
                                <h4>LOCATION</h4>
                                <ul>
                                    <li>SAN FRANSISCO</li>
                                    <li>460 Gough St</li>
                                    <li>San Fransisco,</li>
                                    <li>CA 94102</li>
                                </ul>
                            </div>
                            <div id="social" class="col-md-2 footerText">
                                    <h4>FOLLOW US</h4>
                                <div id="footerLinkBlock">
                                    <ul>
                                    <li><a href="http://www.instagram/welcomestranger" title="{l s='Instagram'}">{l s='Instagram'}</a></li>
                                    <li><a href="http://www.facebook.com/shopwelcomestranger" title="{l s='Facebook'}">{l s='Facebook'}</a></li>
                                    <li><a href="http://www.twitter.com/welcomestrangr" title="{l s='Twitter'}">{l s='Twitter'}</a></li>
                                    <li><a href="http://www.pinterest.com/welcomestranger" title="{l s='Pintrest'}">{l s='Pintrest'}</a></li>
                                    <li><a href="http://www.tumblr.com/welcomestrangersf" title="{l s='Tumblr'}">{l s='Tumblr'}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <p id="WScopyright">&copy; 2009-2014 Welcome Stranger San Fransisco.</p>
                    </div>
                </div>
            {/if}
                </div><!--end id=page -->

                 <!-- Right -->
            </div>
        </div> <!--gridWrapper -->
        <script type="text/javascript">
			var baseDir = '{$content_dir|addslashes}';
			var baseUri = '{$base_uri|addslashes}';
			var static_token = '{$static_token|addslashes}';
			var token = '{$token|addslashes}';
			var priceDisplayPrecision = {$priceDisplayPrecision*$currency->decimals};
			var priceDisplayMethod = {$priceDisplay};
			var roundMode = {$roundMode};
		</script>
                {if isset($js_files)}
	{foreach from=$js_files item=js_uri}
	<script type="text/javascript" src="{$js_uri}"></script>
	{/foreach}
        <script type="text/javascript" src="{$js_dir}bootstrap.min.js"></script>
{/if}
    <script type="text/javascript" src="{$js_dir}ws.js"></script>
    </body>
</html>
