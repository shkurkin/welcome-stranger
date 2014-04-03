$(document).ready(function() {
    window.onscroll = WSchangePos;

    var WStop = $('#generic-carousel').offset().top
    var WSelementHeight = $('#generic-carousel').height();

    function WSchangePos() {
        if (window.pageYOffset > (WStop + WSelementHeight)) {
            FixedNav.pullInMenu();
            FixedNav.fixed();
        } else {
            FixedNav.absolute();
        }
    }
});

var FixedNav = (function(){
    var header = document.getElementById("navWrapper");
    var menu = document.getElementById("mainNavDropdown");
    var rightCol = document.getElementById("right_column");
    var WStop = $('#generic-carousel').offset().top
    var WSelementHeight = $('#generic-carousel').height();

    function _fixed() {
        header.style.position = "fixed";
        header.style.top = "0";
        menu.style.position = "fixed";
        menu.style.top = "-10px";
        rightCol.style.position = "fixed";
        rightCol.style.top = "-42px";
    }

    function _absolute() {
        header.style.position = "";
        header.style.top = "";
        menu.style.position = "absolute";
        menu.style.top = "0";
        rightCol.style.position = "absolute";
        rightCol.style.top = "";
    }

    function _pullInMenu() {
        if($('#mainNavToggle').hasClass('navSlide') &&
            window.pageYOffset < (WStop + WSelementHeight + 150)) {
            $('#mainNavToggle').removeClass('navSlide');
            $( "#mainNavToggle" ).animate({
                left: "+=100",
              }, 300);

            $( "#mainNavDropdown" ).animate({
                left: "-=200",
              }, 300, function() {
                $('#menuCloseIcon').hide();
                $('#menuOpenIcon').show();

            });
        }
    }

    return {
        fixed: _fixed,
        absolute: _absolute,
        pullInMenu: _pullInMenu
    }
}());
