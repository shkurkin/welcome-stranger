<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 15:20:46
         compiled from "/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/modules/lookbook/views/templates/config/mainView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1435035383533b118eda00f3-72769968%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '99dc77df5d39b30be65052e6e98245fec8f74429' => 
    array (
      0 => '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/modules/lookbook/views/templates/config/mainView.tpl',
      1 => 1396377922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1435035383533b118eda00f3-72769968',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'bMultiGroupError' => 0,
    'modulePath' => 0,
    'lookbook' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533b118ee33f02_96650748',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533b118ee33f02_96650748')) {function content_533b118ee33f02_96650748($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['bMultiGroupError']->value)){?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['modulePath']->value)."views/templates/admin/multishopConfig.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>

    <fieldset>
        <legend><img src="<?php echo $_smarty_tpl->tpl_vars['lookbook']->value->getWebPath();?>
logo.gif" alt="" title="" /><?php echo smartyTranslate(array('s'=>'Lookbook banner image file dimensions','mod'=>'lookbook'),$_smarty_tpl);?>
</legend>
    <form action="<?php echo $_SERVER['REQUEST_URI'];?>
" method="POST">
        <p><?php echo smartyTranslate(array('s'=>'Please change the dimensions of the banner here.','mod'=>'lookbook'),$_smarty_tpl);?>
</p>
        <?php echo smartyTranslate(array('s'=>'Enter the banner size','mod'=>'lookbook'),$_smarty_tpl);?>
 <input type="text" name="banner_size" value="<?php echo $_smarty_tpl->tpl_vars['lookbook']->value->getConfigurationValue('LOOKBOOK_IMG_DIMENSIONS');?>
"/> pixels. (<?php echo smartyTranslate(array('s'=>'Default','mod'=>'lookbook'),$_smarty_tpl);?>
:555 pixels)<br/>
        <input type="submit" value="<?php echo smartyTranslate(array('s'=>'Save','mod'=>'lookbook'),$_smarty_tpl);?>
" name="submitImageSize"/>
    </form>
    </fieldset>
    <br/>
    <fieldset>
        <legend><img src="<?php echo $_smarty_tpl->tpl_vars['lookbook']->value->getWebPath();?>
logo.gif" alt="" title="" /><?php echo smartyTranslate(array('s'=>'Lookbook thumbnail image file dimensions','mod'=>'lookbook'),$_smarty_tpl);?>
</legend>
    <form action="<?php echo $_SERVER['REQUEST_URI'];?>
" method="POST">
        <p><?php echo smartyTranslate(array('s'=>'Please change the dimensions of the thumbnails here.','mod'=>'lookbook'),$_smarty_tpl);?>
</p>
        <?php echo smartyTranslate(array('s'=>'Enter the thumbnail size','mod'=>'lookbook'),$_smarty_tpl);?>
 <input type="text" name="thumb_size" value="<?php echo $_smarty_tpl->tpl_vars['lookbook']->value->getConfigurationValue('LOOKBOOK_IMG_TH_DIMENSIONS');?>
"/> pixels. (<?php echo smartyTranslate(array('s'=>'Default','mod'=>'lookbook'),$_smarty_tpl);?>
:120 pixels)<br/>
        <input type="submit" value="<?php echo smartyTranslate(array('s'=>'Save','mod'=>'lookbook'),$_smarty_tpl);?>
" name="submitImageThumbSize"/>
    </form>
    </fieldset>
    <br/>
    
<?php }?><?php }} ?>