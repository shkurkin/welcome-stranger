<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 12:10:34
         compiled from "/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/admin/themes/default/template/controllers/outstanding/_print_pdf_icon.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1997434388533b0f2acfd906-68529728%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4ef36907783f15a4b1f7b0842b2baf3260205194' => 
    array (
      0 => '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/admin/themes/default/template/controllers/outstanding/_print_pdf_icon.tpl',
      1 => 1390236860,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1997434388533b0f2acfd906-68529728',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'id_invoice' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533b0f2ad18791_45217741',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533b0f2ad18791_45217741')) {function content_533b0f2ad18791_45217741($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/tools/smarty/plugins/modifier.escape.php';
?>


<span style="width:20px; margin-right:5px;">
	<a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['link']->value->getAdminLink('AdminPdf'), 'htmlall', 'UTF-8');?>
&submitAction=generateInvoicePDF&id_order_invoice=<?php echo $_smarty_tpl->tpl_vars['id_invoice']->value;?>
"><img src="../img/admin/tab-invoice.gif" alt="invoice" /></a>
</span><?php }} ?>