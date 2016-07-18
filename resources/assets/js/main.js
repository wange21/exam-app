$(function() {
  // remove 'no-js' class on html tag
  $('html').removeClass('no-js');
  // bind navicon click handler
  $('.navicon').click(function(e) {
    e.preventDefault();
    $('body').toggleClass('is-open');
  });
});
