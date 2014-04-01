<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 15:22:20
         compiled from "/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/modules/longlistview/longlistview.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1441850481533b11ecad9679-55205523%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1b2a802907a6a0e74b19c8b96f5dc89c313413e7' => 
    array (
      0 => '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/modules/longlistview/longlistview.tpl',
      1 => 1396377922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1441850481533b11ecad9679-55205523',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'categoryMap' => 0,
    'category' => 0,
    'catArray' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533b11ecb53995_97808607',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533b11ecb53995_97808607')) {function content_533b11ecb53995_97808607($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/tools/smarty/plugins/modifier.escape.php';
?><!-- Block longlistview -->
<div id="longlistview_block_middle" class="block">
    <div class="block_content">
        <?php  $_smarty_tpl->tpl_vars['catArray'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['catArray']->_loop = false;
 $_smarty_tpl->tpl_vars['category'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categoryMap']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['catArray']->key => $_smarty_tpl->tpl_vars['catArray']->value){
$_smarty_tpl->tpl_vars['catArray']->_loop = true;
 $_smarty_tpl->tpl_vars['category']->value = $_smarty_tpl->tpl_vars['catArray']->key;
?>
               <div class="row padded">
               <div id="a<?php echo mb_strtoupper($_smarty_tpl->tpl_vars['category']->value, 'UTF-8');?>
" class="productListBlockHeader col-lg-4">
                   <div class="innerTable">
                        <div class="categorySpanner">
                            <span class="categoryText"> <?php echo $_smarty_tpl->tpl_vars['category']->value;?>
 </span>
                        </div>
                   </div>
               </div>
                <?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['catArray']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['product']->iteration++;
?>
                    <?php if ($_smarty_tpl->tpl_vars['product']->iteration%3==0){?>
                        </div><div class="row padded">
                    <?php }?>
                    <div class="productListBlock col-lg-4">
                        <a href="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['prodLink'], 'htmlall', 'UTF-8');?>
" class="product_img_link" title="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['product']->value['name'], 'htmlall', 'UTF-8');?>
">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['product']->value['imgLink'];?>
"/><br/><br/>
                            <span class="prod_name"><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</span><br/>
		            <span class="manufacturer">		
                            <?php echo $_smarty_tpl->tpl_vars['product']->value['manufacturerName'];?>
</span><br/>
                            <span class="price">$<?php echo $_smarty_tpl->tpl_vars['product']->value['price'];?>
</span>
                        </a>
                    </div>
                <?php } ?>
                <?php if (isset($_smarty_tpl->tpl_vars['product']->value['catLink'])){?>
                    </div>
                    <div class="row">
                        <div class="dividerImage col-lg-12">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['product']->value['catLink'];?>
"/>
                        </div>
                    </div>
                <?php }?>


        <?php } ?>
        </div>
</div>
<!-- /Block longlistview -->
<?php }} ?>