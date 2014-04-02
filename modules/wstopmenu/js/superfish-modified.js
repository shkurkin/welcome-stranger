$(document).ready(function() {
    window.onscroll = WSchangePos;

    var WStop = $('#generic-carousel').offset().top
    var WSelementHeight = $('#generic-carousel').height();

    function WSchangePos() {
        var header = document.getElementById("navWrapper");
        var menu = document.getElementById("mainNavDropdown");
        var rightCol = document.getElementById("right_column");
        if (window.pageYOffset > (WStop + WSelementHeight)) {
            header.style.position = "fixed";
            header.style.top = "0";
            menu.style.position = "fixed";
            menu.style.top = "-10px";
            rightCol.style.position = "fixed";
            rightCol.style.top = "-42px";
        } else {
            header.style.position = "";
            header.style.top = "";
            menu.style.position = "absolute";
            menu.style.top = "0";
            rightCol.style.position = "absolute";
            rightCol.style.top = "";
        }
    }


//     $('#navWrapper').height($("#nav").height());

//     $('#stickyNav').affix({
//         offset: 510
//     });

//     $(".scroll").click(function (event) {
//     event.preventDefault();
//     //calculate destination place
//     var dest = 0;
//     if ($(this.hash).offset().top > $(document).height() - $(window).height()) {
//         dest = $(document).height() - $(window).height();
//     } else {
//         dest = $(this.hash).offset().top;
//     }
//     //go to destination
//     $('html,body').animate({
//         scrollTop: dest
//     }, 2000, 'swing');
// });
});
