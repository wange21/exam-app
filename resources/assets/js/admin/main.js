$(function() {
  var $adminExamType = $('#admin-exam-type');
  var $adminExamPassword = $('#admin-exam-password');
  $adminExamType.change(function(e) {
    if ($adminExamType.val() === 'password') {
      $adminExamPassword.show();
    } else {
      $adminExamPassword.hide();
    }
  });
});
