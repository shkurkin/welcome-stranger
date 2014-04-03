$(function() {
  $('#menuCloseIcon').hide();
  $('#mainNavToggle').on('click', function(){

    if($('#mainNavToggle').hasClass('navSlide')) {
      Slide.hide();
    } else {
      Slide.show();
    }
  });

  DynamicPadding.padProdDesc();
  $(window).resize(function(){
    DynamicPadding.padProdDesc();
  });

  window.onscroll = ProdFixed.fixed;

});

var ProdFixed = (function(){
  function _fixed() {
    var prodInfo = document.getElementById("pb-left-column");
    if (window.pageYOffset > $('#pb-left-column').position().top) {
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

var DynamicPadding = (function() {
  function _padProdDesc() {
    var $prodCol = $('#pb-right-column');
    var padding = $prodCol.position().left + $prodCol.width();
    $('#pb-left-column').css('padding-left', padding);
  }

  return {
    padProdDesc: _padProdDesc
  }
}());

var Slide = (function(){
  function _show() {
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

  function _hide() {
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
    show: _show,
    hide: _hide
  }
}());