<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 16:34:19
         compiled from "/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/themes/welcoming/breadcrumb.tpl" */ ?>
<?php /*%%SmartyHeaderCode:830666667533b22cbb91440-92517349%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '296d6a0541d5ffcc7862d20a7329b23f12a529d6' => 
    array (
      0 => '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/themes/welcoming/breadcrumb.tpl',
      1 => 1396377922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '830666667533b22cbb91440-92517349',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'base_dir' => 0,
    'path' => 0,
    'category' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533b22cbbf7b86_99752443',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533b22cbbf7b86_99752443')) {function content_533b22cbbf7b86_99752443($_smarty_tpl) {?>

<!-- Breadcrumb -->
<?php if (isset(Smarty::$_smarty_vars['capture']['path'])){?><?php $_smarty_tpl->tpl_vars['path'] = new Smarty_variable(Smarty::$_smarty_vars['capture']['path'], null, 0);?><?php }?>
<div id="breadcrumb" class="breadcrumb affix-top">
	<a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
" title="<?php echo smartyTranslate(array('s'=>'Return to Home'),$_smarty_tpl);?>
" id='backlink'>Back</a>
	<?php if (isset($_smarty_tpl->tpl_vars['path']->value)&&$_smarty_tpl->tpl_vars['path']->value){?>
		<?php if (!strpos($_smarty_tpl->tpl_vars['path']->value,'span')){?>
			<span class="navigation_page"><?php echo $_smarty_tpl->tpl_vars['path']->value;?>
</span>
		<?php }else{ ?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['base_dir']->value;?>
index.php#a<?php echo mb_strtoupper($_smarty_tpl->tpl_vars['category']->value->name, 'UTF-8');?>
" id='currentlink'><?php echo mb_strtoupper($_smarty_tpl->tpl_vars['category']->value->name, 'UTF-8');?>
</a>
		<?php }?>
	<?php }?>
</div>
<!-- /Breadcrumb --><?php }} ?>