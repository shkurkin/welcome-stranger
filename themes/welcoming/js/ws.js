$(function() {
  $('#menuCloseIcon').hide();
  $('#mainNavToggle').on('click', function(){
    if($('#mainNavToggle').hasClass('navSlide')) {
      $( "#mainNavToggle" ).animate({
          left: "+=40",
        }, 300)

      $( "#mainNavDropdown" ).animate({
          left: "-=200",
        }, 300, function() {
          $('#menuCloseIcon').hide();
          $('#menuOpenIcon').show();

          $('#mainNavToggle').toggleClass('navSlide');
        });
    } else {
      $( "#mainNavToggle" ).animate({
          left: "-=40",
        }, 300)
      $( "#mainNavDropdown" ).animate({
          left: "+=200",
        }, 300, function() {
          $('#menuCloseIcon').show();
          $('#menuOpenIcon').hide();
          $('#mainNavToggle').toggleClass('navSlide');
        });
    }
  })
});