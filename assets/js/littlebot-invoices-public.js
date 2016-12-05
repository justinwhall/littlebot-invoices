( function( $ ) {
	
	var Status = {

		init:function(){
			this.attachEvents();
			console.log('var');
		},

		attachEvents:function(){
			$('.status').on('click', 'span', Status.updateStatus);
		},

		updateStatus:function(){

			$('.spinner').css('opacity', 1);

			var data = {
				action : 'update_status',
				nonce  : ajax_object.ajax_nonce,
				status : $(this).data('status'),
				ID: $(this).parent().data('id')
			};

			$.ajax({
				url     : ajax_object.ajax_url,
				type    : 'POST',
				data    : data,
				success : function( resp ){
					$('.spinner').css('opacity', 0);
					if (resp.error) {
						$('.status').html('<span style="color:#666;">' + resp.message + '</span>');
					} else{

						if (resp.data.new_status == 'lb-declined') {
							html = '<span class="decline">Declined</span>';
						} else{
							html = '<span class="approved">Approved</span>';
						}
						$('.status').html(html);
					}
				}
			});
		}

	}
	Status.init();


})( jQuery );	
