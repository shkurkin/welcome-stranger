$(function() {
  $('#menuCloseIcon').hide();
  $('#mainNavToggle').on('click', function(){
    if($('#mainNavToggle').hasClass('navSlide')) {
      $( "#mainNavDropdown" ).animate({
          left: "-=170",
        }, 300, function() {
          $('#menuCloseIcon').hide();
          $('#menuOpenIcon').show();

          $('#mainNavToggle').toggleClass('navSlide');
        });
    } else {
      $( "#mainNavDropdown" ).animate({
          left: "+=170",
        }, 300, function() {
          $('#menuCloseIcon').show();
          $('#menuOpenIcon').hide();
          $('#mainNavToggle').toggleClass('navSlide');
        });
    }
  })
});