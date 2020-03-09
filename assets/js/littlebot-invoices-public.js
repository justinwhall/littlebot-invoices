(function($) {
  var Status = {
    init: function() {
      this.attachEvents();
    },

    attachEvents: function() {
      $('.single-lb_estimate .status').on('click', 'span', Status.updateStatus);
    },

    updateStatus: function() {
      $('.spinner').css('opacity', 1);

      var data = {
        action: 'update_status',
        nonce: littleBotConfig.ajaxNonce,
        ajax: true,
        status: $(this).data('status'),
        ID: $(this)
          .parent()
          .data('id')
      };

      $.ajax({
        url: littleBotConfig.ajaxUrl,
        type: 'POST',
        data: data,
        success: function(resp) {
          console.log(resp);
          $('.spinner').css('opacity', 0);
          if (resp.error) {
            $('.status').html(
              '<span style="color:#666;">' + resp.message + '</span>'
            );
          } else {
            if (resp.data.new_status == 'lb-declined') {
              html = '<span class="decline">Declined</span>';
            } else {
              html = '<span class="approved">Approved</span>';
            }
            $('.status').html(html);
          }
        }
      });
    }
  };
  Status.init();
})(jQuery);
