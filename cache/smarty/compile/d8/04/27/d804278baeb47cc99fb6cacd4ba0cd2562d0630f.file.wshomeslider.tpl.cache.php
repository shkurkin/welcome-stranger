<?php /* Smarty version Smarty-3.1.14, created on 2014-04-01 15:22:20
         compiled from "/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/modules/wshomeslider/wshomeslider.tpl" */ ?>
<?php /*%%SmartyHeaderCode:726734913533b11ecb67623-28879492%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd804278baeb47cc99fb6cacd4ba0cd2562d0630f' => 
    array (
      0 => '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/modules/wshomeslider/wshomeslider.tpl',
      1 => 1396377922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '726734913533b11ecb67623-28879492',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'homeslider' => 0,
    'homeslider_slides' => 0,
    'slide' => 0,
    'module_dir' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533b11ecc0e031_57288808',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533b11ecc0e031_57288808')) {function content_533b11ecc0e031_57288808($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_escape')) include '/Applications/prestashop-1.6.0.5-1/apps/prestashop/htdocs/tools/smarty/plugins/modifier.escape.php';
?>

<!-- Module HomeSlider -->
<?php if (isset($_smarty_tpl->tpl_vars['homeslider']->value)){?>
<script type="text/javascript">
<?php if (isset($_smarty_tpl->tpl_vars['homeslider_slides']->value)&&count($_smarty_tpl->tpl_vars['homeslider_slides']->value)>1){?>
	<?php if ($_smarty_tpl->tpl_vars['homeslider']->value['loop']==1){?>
		var homeslider_loop = true;
	<?php }else{ ?>
		var homeslider_loop = false;
	<?php }?>
<?php }else{ ?>
	var homeslider_loop = false;
<?php }?>
var homeslider_speed = <?php echo $_smarty_tpl->tpl_vars['homeslider']->value['speed'];?>
;
var homeslider_pause = <?php echo $_smarty_tpl->tpl_vars['homeslider']->value['pause'];?>
;
</script>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['homeslider_slides']->value)){?>
    <div class="row">
        <div id="generic-carousel" class="carousel slide col-lg-12" data-ride="carousel">
            <ol class="carousel-indicators">
            <?php  $_smarty_tpl->tpl_vars['slide'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slide']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['homeslider_slides']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['slide']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['slide']->key => $_smarty_tpl->tpl_vars['slide']->value){
$_smarty_tpl->tpl_vars['slide']->_loop = true;
 $_smarty_tpl->tpl_vars['slide']->iteration++;
?>
                    <?php if (isset($_smarty_tpl->tpl_vars['slide']->value['active'])&&$_smarty_tpl->tpl_vars['slide']->value['active']){?>
                            <li data-target="#generic-carousel" data-slide-to="<?php echo $_smarty_tpl->tpl_vars['slide']->iteration-1;?>
" <?php if ($_smarty_tpl->tpl_vars['slide']->iteration==1){?>class="active"<?php }?>></li>
                    <?php }?>
            <?php } ?>
            </ol>

            <div class="carousel-inner">`
                <?php  $_smarty_tpl->tpl_vars['slide'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['slide']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['homeslider_slides']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['slide']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['slide']->key => $_smarty_tpl->tpl_vars['slide']->value){
$_smarty_tpl->tpl_vars['slide']->_loop = true;
 $_smarty_tpl->tpl_vars['slide']->iteration++;
?>
                    <?php if (isset($_smarty_tpl->tpl_vars['slide']->value['active'])&&$_smarty_tpl->tpl_vars['slide']->value['active']){?>
                        <div class="item <?php if ($_smarty_tpl->tpl_vars['slide']->iteration==1){?>active<?php }?>">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getMediaLink(((string)$_smarty_tpl->tpl_vars['module_dir']->value)."images/".((string)smarty_modifier_escape($_smarty_tpl->tpl_vars['slide']->value['image'], 'htmlall', 'UTF-8')));?>
" alt="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['slide']->value['legend'], 'htmlall', 'UTF-8');?>
" />
                        </div>
                    <?php }?>
                <?php } ?>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" id="prevSlide" href="#generic-carousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" id="nextSlide" href="#generic-carousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>        
<?php }?>
<!-- /Module HomeSlider -->
<?php }} ?>