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
  'version' => 'Smarty-3.1.14',
  'unifunc' => 'content_533b2a7768c701_03812910',
  'has_nocache_code' => false,
  'cache_lifetime' => 31536000,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_533b2a7768c701_03812910')) {function content_533b2a7768c701_03812910($_smarty_tpl) {?>
<!-- Module HomeSlider -->
<script type="text/javascript">
			var homeslider_loop = true;
	var homeslider_speed = 500;
var homeslider_pause = 3000;
</script>
    <div class="row">
        <div id="generic-carousel" class="carousel slide col-lg-12" data-ride="carousel">
            <ol class="carousel-indicators">
                                                            <li data-target="#generic-carousel" data-slide-to="0" class="active"></li>
                                                                                <li data-target="#generic-carousel" data-slide-to="1" ></li>
                                            </ol>

            <div class="carousel-inner">`
                                                            <div class="item active">
                            <img src="http://localhost:8000/prestashop/modules/wshomeslider/images/7e38b7b3ea990c0f92eb602155014a79.jpg" alt="WS 1" />
                        </div>
                                                                                <div class="item ">
                            <img src="http://localhost:8000/prestashop/modules/wshomeslider/images/f751949159fc30c1db310d7c93e064fe.jpg" alt="WS 2" />
                        </div>
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
<!-- /Module HomeSlider -->
<?php }} ?>