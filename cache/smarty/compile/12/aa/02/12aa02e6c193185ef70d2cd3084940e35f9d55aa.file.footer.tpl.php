<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 15:16:10
         compiled from "/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/themes/welcoming/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1365847581533b107a117928-41765302%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '12aa02e6c193185ef70d2cd3084940e35f9d55aa' => 
    array (
      0 => '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/themes/welcoming/footer.tpl',
      1 => 1396377922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1365847581533b107a117928-41765302',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content_only' => 0,
    'HOOK_RIGHT_COLUMN' => 0,
    'HOOK_FOOTER' => 0,
    'link' => 0,
    'content_dir' => 0,
    'base_uri' => 0,
    'static_token' => 0,
    'token' => 0,
    'priceDisplayPrecision' => 0,
    'currency' => 0,
    'priceDisplay' => 0,
    'roundMode' => 0,
    'js_files' => 0,
    'js_uri' => 0,
    'js_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533b107a1ce0d5_23919838',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533b107a1ce0d5_23919838')) {function content_533b107a1ce0d5_23919838($_smarty_tpl) {?>

<?php if (!$_smarty_tpl->tpl_vars['content_only']->value){?>
                                        </div>
                                    </div> <!--Center div -->
                                </div>
                            </div> <!-- CenterColumn -->
                        </div> <!-- Header-->
                    </div><!--end id=page -->

                     <!-- Right -->
                    <div id="right_column" class="col-md-2 col-lg-2">
                            <?php echo $_smarty_tpl->tpl_vars['HOOK_RIGHT_COLUMN']->value;?>

                    </div>
                </div>
                
                <!-- Footer -->
                <div class="row">
                    <div id="footer" class="col-md-12 col-lg-12 clearfix">
                        <?php echo $_smarty_tpl->tpl_vars['HOOK_FOOTER']->value;?>

                        <div class="row" style="padding-top:42px">
                        <div id="rowText" class="col-lg-4">
                            <h4>JOIN OUR MAILING LIST</h4>
                            <form action="#">
                                <input type="text" id="newsletterBox" name="mailingList" placeholer="ENTER EMAIL"/><br/><br/>
                                <input type="submit" id="newsletterSubmit" value="JOIN"/>
                            </form>
                        </div>
                        <div id="middleText" class="col-lg-4">
                            <h4>CUSTOMER SERVICE</h4>
                            <div id="footerLinkBlock">
                                <ul>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getCMSLink('1','Contact Info');?>
" title="<?php echo smartyTranslate(array('s'=>'Contact Info'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Contact Info'),$_smarty_tpl);?>
</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getCMSLink('1','Store Policy');?>
" title="<?php echo smartyTranslate(array('s'=>'Store Policy'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Store Policy'),$_smarty_tpl);?>
</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getCMSLink('1','Sizing Guide');?>
" title="<?php echo smartyTranslate(array('s'=>'Sizing Guide'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Sizing Guide'),$_smarty_tpl);?>
</a></li>
                                <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getCMSLink('1','Terms of Use');?>
" title="<?php echo smartyTranslate(array('s'=>'Terms of Use'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Terms of Use'),$_smarty_tpl);?>
</a></li>
                                </ul>
                            </div>
                        </div>
                            <div id="social" class="col-lg-4">
                                <h4>FOLLOW US</h4>
                            <div id="footerLinkBlock">
                                <ul>
                                <li><a href="http://www.instagram/welcomestranger" title="<?php echo smartyTranslate(array('s'=>'Instagram'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Instagram'),$_smarty_tpl);?>
</a></li>
                                <li><a href="http://www.facebook.com/shopwelcomestranger" title="<?php echo smartyTranslate(array('s'=>'Facebook'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Facebook'),$_smarty_tpl);?>
</a></li>
                                <li><a href="http://www.twitter.com/welcomestrangr" title="<?php echo smartyTranslate(array('s'=>'Twitter'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Twitter'),$_smarty_tpl);?>
</a></li>
                                <li><a href="http://www.pinterest.com/welcomestranger" title="<?php echo smartyTranslate(array('s'=>'Pintrest'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Pintrest'),$_smarty_tpl);?>
</a></li>
                                <li><a href="http://www.tumblr.com/welcomestrangersf" title="<?php echo smartyTranslate(array('s'=>'Tumblr'),$_smarty_tpl);?>
"><?php echo smartyTranslate(array('s'=>'Tumblr'),$_smarty_tpl);?>
</a></li>
                                </ul>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div> <!--gridWrapper -->
        <script type="text/javascript">
			var baseDir = '<?php echo addslashes($_smarty_tpl->tpl_vars['content_dir']->value);?>
';
			var baseUri = '<?php echo addslashes($_smarty_tpl->tpl_vars['base_uri']->value);?>
';
			var static_token = '<?php echo addslashes($_smarty_tpl->tpl_vars['static_token']->value);?>
';
			var token = '<?php echo addslashes($_smarty_tpl->tpl_vars['token']->value);?>
';
			var priceDisplayPrecision = <?php echo $_smarty_tpl->tpl_vars['priceDisplayPrecision']->value*$_smarty_tpl->tpl_vars['currency']->value->decimals;?>
;
			var priceDisplayMethod = <?php echo $_smarty_tpl->tpl_vars['priceDisplay']->value;?>
;
			var roundMode = <?php echo $_smarty_tpl->tpl_vars['roundMode']->value;?>
;
		</script>
                <?php if (isset($_smarty_tpl->tpl_vars['js_files']->value)){?>
	<?php  $_smarty_tpl->tpl_vars['js_uri'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['js_uri']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['js_files']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['js_uri']->key => $_smarty_tpl->tpl_vars['js_uri']->value){
$_smarty_tpl->tpl_vars['js_uri']->_loop = true;
?>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_uri']->value;?>
"></script>
	<?php } ?>
        <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
bootstrap.min.js"></script>
<?php }?>
    </body>
</html>
<?php }} ?>