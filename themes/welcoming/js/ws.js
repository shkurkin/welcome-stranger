$(function() {
  DynamicSizing.sizeMenuHeight();

  $('#menuCloseIcon').hide();
  $('#mainNavToggle').on('click', function(){
    if($('#mainNavToggle').hasClass('navSlide')) {
      Slide.hideNav();
    } else {
      Slide.showNav();
    }
  });

  if($('#pb-left-column').length > 0) {
    DynamicSizing.padProdDesc();
    $(window).resize(function(){
      DynamicSizing.padProdDesc();
    });
    window.onscroll = ProdFixed.fixed;
  }

});

var ProdFixed = (function(){
  if($('#pb-left-column').length > 0) {
    var infoPos = $('#pb-left-column').position().top;
  }
  function _fixed() {
    var prodInfo = document.getElementById("pb-left-column");
    if (window.pageYOffset > infoPos) {
        prodInfo.style.position = "fixed";
        prodInfo.style.top = "30px";
    } else {
        prodInfo.style.position = "";
        prodInfo.style.top = "490px";
    }
  }

  return {
    fixed: _fixed
  }
}());

var DynamicSizing = (function() {
  function _padProdDesc() {
    var $prodCol = $('#pb-right-column');
    var padding = $prodCol.position().left + $prodCol.width();
    $('#pb-left-column').css('padding-left', padding);
  }

  function _sizeMenuHeight() {
    var footerTop = $('#footer').position().top;
    $('#dropdownMenu').height(footerTop);
  }

  return {
    padProdDesc: _padProdDesc,
    sizeMenuHeight: _sizeMenuHeight
  }
}());

var Slide = (function(){
  function _showNav() {
    $( "#mainNavToggle" ).animate({
        left: "-=100",
      }, 300);

    $( "#mainNavDropdown" ).animate({
        left: "+=200",
      }, 300, function() {
        $('#menuCloseIcon').show();
        $('#menuOpenIcon').hide();
        $('#mainNavToggle').toggleClass('navSlide');
      });
  }

  function _hideNav() {
    $( "#mainNavToggle" ).animate({
        left: "+=100",
      }, 300);

    $( "#mainNavDropdown" ).animate({
        left: "-=200",
      }, 300, function() {
        $('#menuCloseIcon').hide();
        $('#menuOpenIcon').show();

        $('#mainNavToggle').toggleClass('navSlide');
      });
  }

  return {
    showNav: _showNav,
    hideNav: _hideNav
  }
}());