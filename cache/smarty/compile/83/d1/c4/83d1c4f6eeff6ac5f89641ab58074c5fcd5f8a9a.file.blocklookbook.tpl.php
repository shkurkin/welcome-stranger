<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 15:22:20
         compiled from "/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/modules/lookbook/views/templates/hook/blocklookbook.tpl" */ ?>
<?php /*%%SmartyHeaderCode:407971657533b11ec854e51-09946589%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '83d1c4f6eeff6ac5f89641ab58074c5fcd5f8a9a' => 
    array (
      0 => '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/modules/lookbook/views/templates/hook/blocklookbook.tpl',
      1 => 1396377922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '407971657533b11ec854e51-09946589',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lookbookObj' => 0,
    'categories' => 0,
    'is154' => 0,
    'link' => 0,
    'rewrite_setting' => 0,
    'c' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533b11ec8f3625_60344565',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533b11ec8f3625_60344565')) {function content_533b11ec8f3625_60344565($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['languages'] = new Smarty_variable($_smarty_tpl->tpl_vars['lookbookObj']->value->getLanguagesOrdered(), null, 0);?>
<?php $_smarty_tpl->tpl_vars['currentLanguage'] = new Smarty_variable($_smarty_tpl->tpl_vars['lookbookObj']->value->getDefaultLang(), null, 0);?>
<!-- MODULE Block lookbook -->
<div id="manufacturers_block_left" class="row affix-top" data-spy="affix" data-offset-top="50">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default" style="border-radius: 0px; border: 0px">
                <h4 class="panel-title" >
                    <a style="padding-left: 5px;" data-toggle="collapse" data-parent="#manufacturers_block_left" href="#collapseOne">
                        MENU
                    </a>
                </h4>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <div id='lookbookMain' class="col-lg-12">
                        <hf><b>LOOKBOOKS</b></hf>
                        <ul class="bullet">
                            <?php  $_smarty_tpl->tpl_vars['c'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['c']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['categories']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['c']->key => $_smarty_tpl->tpl_vars['c']->value){
$_smarty_tpl->tpl_vars['c']->_loop = true;
?>
                                <?php if (!empty($_smarty_tpl->tpl_vars['is154']->value)){?>
                                    <li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getModuleLink('lookbook');?>
<?php if (!empty($_smarty_tpl->tpl_vars['rewrite_setting']->value)){?>?<?php }else{ ?>&<?php }?>category=<?php echo $_smarty_tpl->tpl_vars['c']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['c']->value['name'];?>
</a></li>
                                    <?php }else{ ?>
                                    <li><a href="<?php echo $_smarty_tpl->tpl_vars['lookbookObj']->value->getURI($_smarty_tpl->tpl_vars['c']->value['link']);?>
"><?php echo $_smarty_tpl->tpl_vars['c']->value['name'];?>
</a></li>
                                    <?php }?>
                                <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /MODULE Block lookbook -->
<?php }} ?>