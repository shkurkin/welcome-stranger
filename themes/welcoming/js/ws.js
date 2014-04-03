$(function() {
  $('#menuCloseIcon').hide();
  $('#mainNavToggle').on('click', function(){
    var WStop = $('#generic-carousel').offset().top
    var WSelementHeight = $('#generic-carousel').height();

    if($('#mainNavToggle').hasClass('navSlide')) {

      // fix the slide out of menu here
      // if (window.pageYOffset > (WStop + WSelementHeight)) {
      //   $( ".sf-menu" ).animate({
      //       marginLeft: "-=100",
      //     }, 300);
      // }

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
    } else {

      // fix the slide out of menu here
      // if (window.pageYOffset > (WStop + WSelementHeight)) {
      //   $( ".sf-menu" ).animate({
      //       marginLeft: "+=100",
      //     }, 300);
      // }

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
  })
});