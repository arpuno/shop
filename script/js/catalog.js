$(function() {
  var key = Cookies.get('editkey');

  /* редактирование */
  $('.ct-edit').click(function() {
    var fields = {
      'title':  '.ct-title',
      'artist': '.ct-artist',
      'year':   '.ct-year',
      'genre':  '.ct-genre',
      'cond':   '.ct-cond',
      'price':  '.ct-price',
      'amount': '.ct-amount'
    };

    var row = $(this).parents('.ct-tr');
    var id = row.attr('data-id');

    /* запись значений в поля */
    $.each(fields, function(k, v) {
      $('.dg-input[name='+k+']').val(row.find(v).attr('data-val'));
    });

    $('#dg-wrap, #dg-edit').show();

    $('#dg-edit-commit').click(function() {
      if (!$('.dg-input').removeClass('dg-input-error').filter(function () { return ($(this).val() == ''); })
          .addClass('dg-input-error').length) {

        var data = {}, query = [];

        $.each(fields, function(k, v) {
          var inp = $('.dg-input[name='+k+']').val();

          data[k] = [v, inp];
          query.push(k +'='+ inp);
        });

        $.ajax({
          url: '/script/php/catedit.php?k='+key+'&m=edit&id='+id+'&'+query.join('&'),
          success: function(m) {
            $.each(data, function(k, v) {
              row.find(v[0]).attr('data-val', v[1]).text(v[1]);
            });

            if (data.amount[1] == 0) {
              row.addClass('ct-outofstock');
              row.find(data.amount[0]).html('нет в<br>наличии');
            }
            else {
              row.removeClass('ct-outofstock');
            }

            $('#dg-wrap, #dg-remove').hide();
            showMessage(m[0], m[1]);
          }
        })
      }
    });
  });

  /* удаление */
  $('.ct-remove').click(function() {
    var row = $(this).parents('.ct-tr');
    var id = row.attr('data-id');

    $('#dg-wrap, #dg-remove').show();

    $('#dg-remove-commit').click(function() {
      $.ajax({
        url: '/script/php/catedit.php?k='+key+'&m=remove&id='+id,
        success: function(data) {
          row.addClass('ct-deleted');
          $('#dg-wrap, #dg-remove').hide();

          showMessage(data[0], data[1]);
        }
      });
    });
  });

  /* закрытие */
  $('#dg-close').click(function() {
    $('#dg-wrap, #dg-edit, #dg-remove').hide();
    $('.dg-input').val('').removeClass('dg-input-error');
  });
});

//console.log($(this).parents('.ct-tr').attr('data-id'), Cookies.get('editkey'));