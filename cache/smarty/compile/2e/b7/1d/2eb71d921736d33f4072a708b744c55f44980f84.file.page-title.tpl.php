<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 12:10:49
         compiled from "/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/themes/default/mobile/page-title.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1250088225533b0f39b1c2f9-93673409%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2eb71d921736d33f4072a708b744c55f44980f84' => 
    array (
      0 => '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/themes/default/mobile/page-title.tpl',
      1 => 1390236862,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1250088225533b0f39b1c2f9-93673409',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_title' => 0,
    'meta_title' => 0,
    'shop_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533b0f39b57a73_10471830',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533b0f39b57a73_10471830')) {function content_533b0f39b57a73_10471830($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/tools/smarty/plugins/modifier.escape.php';
?><?php if (!isset($_smarty_tpl->tpl_vars['page_title']->value)&&isset($_smarty_tpl->tpl_vars['meta_title']->value)&&$_smarty_tpl->tpl_vars['meta_title']->value!=$_smarty_tpl->tpl_vars['shop_name']->value){?>
	<?php $_smarty_tpl->tpl_vars['page_title'] = new Smarty_variable(smarty_modifier_escape($_smarty_tpl->tpl_vars['meta_title']->value, 'htmlall', 'UTF-8'), null, 0);?>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['page_title']->value)){?>
	<div data-role="header" class="clearfix navbartop" data-position="inline">
		<h1><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</h1>
	</div><!-- /navbartop -->
<?php }?><?php }} ?>