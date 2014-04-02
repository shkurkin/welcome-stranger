$(function() {

  $('#mainNavToggle').on('click', function(){
    if($('#mainNavToggle').hasClass('navSlide')) {
      $( "#mainNavDropdown" ).animate({
          left: "-=150",
        }, 500, function() {
          $('#mainNavToggle').toggleClass('navSlide');
        });
    } else {
      $( "#mainNavDropdown" ).animate({
          left: "+=150",
        }, 500, function() {
          $('#mainNavToggle').toggleClass('navSlide');
        });
    }
  })
});