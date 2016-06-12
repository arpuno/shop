var data = {
  URI: 'http://rcdshop.dev',
  msgInterval: null
};

function showMessage(text, type) {
  if (data.msgInterval) {
    clearTimeout(data.msgInterval);
    hideMessage();
  }

  var cnv = $('.canvas');
  var msg = $('#message');

  switch (type) {
    case 1:
      msg.addClass('msg-error');
      break;
  }

  msg.css({
    display: 'inline-block',
    top: cnv.offset().top + 4,
    left: cnv.offset().left + cnv.outerWidth() + 8
  }).text(text);

  data.msgInterval = setTimeout(function() {
    hideMessage();
  }, 5000);
}

function hideMessage() {
  $('#message').hide().removeClass('msg-error');
  data.msgInterval = null;
}

$(function() {
  $('#lg-show').click(function() {
    $('#lg-short').hide();
    $('#lg-full').show();
  });

  $('#lg-submit').click(function() {
    $('#lg-form').submit();
  });
});