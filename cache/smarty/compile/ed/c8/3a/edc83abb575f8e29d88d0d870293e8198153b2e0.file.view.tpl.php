<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 12:10:37
         compiled from "/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/admin/themes/default/template/controllers/search/helpers/view/view.tpl" */ ?>
<?php /*%%SmartyHeaderCode:882405662533b0f2d461c88-20388922%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'edc83abb575f8e29d88d0d870293e8198153b2e0' => 
    array (
      0 => '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/admin/themes/default/template/controllers/search/helpers/view/view.tpl',
      1 => 1390236860,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '882405662533b0f2d461c88-20388922',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'query' => 0,
    'show_toolbar' => 0,
    'toolbar_btn' => 0,
    'toolbar_scroll' => 0,
    'title' => 0,
    'features' => 0,
    'feature' => 0,
    'key' => 0,
    'val' => 0,
    'modules' => 0,
    'module' => 0,
    'categories' => 0,
    'category' => 0,
    'products' => 0,
    'customers' => 0,
    'orders' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533b0f2d5e7e68_83156676',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533b0f2d5e7e68_83156676')) {function content_533b0f2d5e7e68_83156676($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/tools/smarty/plugins/modifier.escape.php';
?>

<script type="text/javascript">
$(function() {
	$('body').highlight('<?php echo $_smarty_tpl->tpl_vars['query']->value;?>
');
});
</script>

<?php if ($_smarty_tpl->tpl_vars['show_toolbar']->value){?>
	<?php echo $_smarty_tpl->getSubTemplate ("toolbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('toolbar_btn'=>$_smarty_tpl->tpl_vars['toolbar_btn']->value,'toolbar_scroll'=>$_smarty_tpl->tpl_vars['toolbar_scroll']->value,'title'=>$_smarty_tpl->tpl_vars['title']->value), 0);?>

	<div class="leadin"></div>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['features']->value)){?>
	<?php if (!$_smarty_tpl->tpl_vars['features']->value){?>
		<h3><?php echo smartyTranslate(array('s'=>'No features matching your query'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
</h3>
	<?php }else{ ?>
		<h3><?php echo smartyTranslate(array('s'=>'Features matching your query'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
</h3>
		<table class="table" cellpadding="0" cellspacing="0">
			<?php  $_smarty_tpl->tpl_vars['feature'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['feature']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['features']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['feature']->key => $_smarty_tpl->tpl_vars['feature']->value){
$_smarty_tpl->tpl_vars['feature']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['feature']->key;
?>
				<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['feature']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['val']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['val']->key;
 $_smarty_tpl->tpl_vars['val']->index++;
 $_smarty_tpl->tpl_vars['val']->first = $_smarty_tpl->tpl_vars['val']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['feature_list']['first'] = $_smarty_tpl->tpl_vars['val']->first;
?>
					<tr>
						<th><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['feature_list']['first']){?><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
<?php }?></th>
						<td>
							<a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['value'];?>
</a>
						</td>
					</tr>
				<?php } ?>
			<?php } ?>
		</table>
		<div class="clear">&nbsp;</div>
	<?php }?>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['modules']->value)){?>
	<?php if (!$_smarty_tpl->tpl_vars['modules']->value){?>
		<h3><?php echo smartyTranslate(array('s'=>'No modules matching your query'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
</h3>
	<?php }else{ ?>
		<h3><?php echo smartyTranslate(array('s'=>'Modules matching your query'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
</h3>
		<table class="table" cellpadding="0" cellspacing="0">
			<?php  $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['module']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['modules']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['module']->key => $_smarty_tpl->tpl_vars['module']->value){
$_smarty_tpl->tpl_vars['module']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['module']->key;
?>
				<tr>
					<th><a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['module']->value->linkto, 'htmlall', 'UTF-8');?>
"><?php echo $_smarty_tpl->tpl_vars['module']->value->displayName;?>
</a></th>
					<td><a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['module']->value->linkto, 'htmlall', 'UTF-8');?>
"><?php echo $_smarty_tpl->tpl_vars['module']->value->description;?>
</a></td>
				</tr>
			<?php } ?>
		</table>
		<div class="clear">&nbsp;</div>
	<?php }?>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['categories']->value)){?>
	<?php if (!$_smarty_tpl->tpl_vars['categories']->value){?>
		<h3><?php echo smartyTranslate(array('s'=>'No categories matching your query'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
</h3>
	<?php }else{ ?>
		<h3><?php echo smartyTranslate(array('s'=>'Categories matching your query'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
</h3>
		<table cellspacing="0" cellpadding="0" class="table">
			<?php  $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['category']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['category']->key => $_smarty_tpl->tpl_vars['category']->value){
$_smarty_tpl->tpl_vars['category']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['category']->key;
?>
				<tr class="alt_row">
					<td><?php echo $_smarty_tpl->tpl_vars['category']->value;?>
</td>
				</tr>
			<?php } ?>
		</table>
		<div class="clear">&nbsp;</div>
	<?php }?>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['products']->value)){?>
	<?php if (!$_smarty_tpl->tpl_vars['products']->value){?>
		<h3><?php echo smartyTranslate(array('s'=>'There are no products matching your query'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
</h3>
	<?php }else{ ?>
		<h3><?php echo smartyTranslate(array('s'=>'Products matching your query'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
</h3>
		<?php echo $_smarty_tpl->tpl_vars['products']->value;?>

	<?php }?>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['customers']->value)){?>
	<?php if (!$_smarty_tpl->tpl_vars['customers']->value){?>
		<h3><?php echo smartyTranslate(array('s'=>'There are no customers matching your query'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
</h3>
	<?php }else{ ?>
		<h3><?php echo smartyTranslate(array('s'=>'Customers matching your query'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
</h3>
		<?php echo $_smarty_tpl->tpl_vars['customers']->value;?>

	<?php }?>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['orders']->value)){?>
	<?php if (!$_smarty_tpl->tpl_vars['orders']->value){?>
		<h3><?php echo smartyTranslate(array('s'=>'There are no orders matching your query'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
</h3>
	<?php }else{ ?>
		<h3><?php echo smartyTranslate(array('s'=>'Orders matching your query'),$_smarty_tpl);?>
 : <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
</h3>
		<?php echo $_smarty_tpl->tpl_vars['orders']->value;?>

	<?php }?>
<?php }?><?php }} ?>