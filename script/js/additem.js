$(function() {
  $('#ai-submit').click(function() {
    if (!$('.ai-input').removeClass('ai-input-error').filter(function() { return($(this).val() == ''); })
      .addClass('ai-input-error').length) {

      $('#ai-form').submit();
    }
  });
});