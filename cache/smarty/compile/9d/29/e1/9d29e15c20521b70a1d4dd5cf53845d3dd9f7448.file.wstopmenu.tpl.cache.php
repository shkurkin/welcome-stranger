<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 15:41:59
         compiled from "/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/modules/wstopmenu/wstopmenu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1885500914533b1687817a57-32237989%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9d29e15c20521b70a1d4dd5cf53845d3dd9f7448' => 
    array (
      0 => '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/modules/wstopmenu/wstopmenu.tpl',
      1 => 1396377922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1885500914533b1687817a57-32237989',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MENU' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533b168785ccd2_67424005',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533b168785ccd2_67424005')) {function content_533b168785ccd2_67424005($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['MENU']->value!=''){?>
    <!-- WS TopMenu -->
    <div id="navWrapper">
        <div class="sf-contener clearfix" id="stickyNav">
            <div class="sf-leftmenu scrollspyNavbar">
                <ul class="nav sf-menu clearfix">
                    <?php echo $_smarty_tpl->tpl_vars['MENU']->value;?>

                </ul>
            </div>
            <div class="sf-rightmenu">
                <ul class="sf-rightmenu clearfix">
                    <ul class="sf-menu clearfix ">
                        <li>CATEGORY / BRAND</li>
                    </ul>
                </ul>
            </div>
        </div>
    </div>
    <div class="sf-right">&nbsp;</div>

    <!-- /WS TopMenu -->
<?php }?><?php }} ?>