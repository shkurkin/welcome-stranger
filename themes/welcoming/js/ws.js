$(function() {
  $('#dropdownMenu').hide();
  $('#mainNavToggle').on('click', function(){
    $('#dropdownMenu').slideToggle('fast');
  })
});