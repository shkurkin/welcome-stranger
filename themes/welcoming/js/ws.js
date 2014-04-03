$(function() {
  $('#menuCloseIcon').hide();
  $('#mainNavToggle').on('click', function(){

    if($('#mainNavToggle').hasClass('navSlide')) {
      Slide.hide();
    } else {
      Slide.show();
    }
  })
});

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