( function( $ ) {

	var LineItems = {

		init:function(){
			// make line items sortable
			$( "#all-line-items" ).sortable({
				placeholder: "ui-state-highlight",
				handle: ".items-wrap"
			});
			$( "#all-line-items" ).disableSelection();
			this.attachEvents();
		},

		attachEvents:function(){
			$('.lb-calc-container').on('change paste keyup', 'input.lb-calc-input', this.updateLineItemTotal);
			$('.lb-calc-container').on('change paste keyup', 'input.lb-calc-input', this.updateTotals);
			// Add line item
			$('.add-line-item').on('click', this.addLineItem);
			// delete line item
			$('.lb-calc-container').on('click', '.dashicons-dismiss', this.removeLineItem);
			// dupe line item
			$('.lb-calc-container').on('click', '.dashicons-plus-alt', this.dupeLineItem);
		},

		addLineItem:function(){
			var template = wp.template( 'line-item' );
			$('#all-line-items').append( template() );
			$('#all-line-items .single-line-item:last-child').slideDown('fast');
		},

		removeLineItem:function(){
			var lineItem = $(this).parents('.single-line-item');
			$(lineItem).slideUp('fast',function(){
				$(lineItem).remove();
				// recalculate totals
				LineItems.updateTotals();
			});
		},

		dupeLineItem:function(){
			var lineItem = $(this).parents('.single-line-item');
			var dupe = $(lineItem).clone();

			$(dupe).css('display', 'none');
			$(dupe).insertAfter(lineItem);

			$(dupe).slideDown('fast', function() {
				// recalculate totals
				LineItems.updateTotals();
			});
		},

		updateLineItemTotal:function(){
			var qty      = ( isNaN( parseFloat($(this).parents('.line-vals').find('.item-qty').val()) ) ? 0 : parseFloat($(this).parents('.line-vals').find('.item-qty').val()) );
			var rate     = ( isNaN( parseFloat($(this).parents('.line-vals').find('.item-rate').val()) ) ? 0 : parseFloat($(this).parents('.line-vals').find('.item-rate').val()) );
			var percent  = ( isNaN(parseFloat($(this).parents('.line-vals').find('.item-percent').val()) / 100) ? 0 : parseFloat($(this).parents('.line-vals').find('.item-percent').val()) / 100  );
			var totalEl  = $(this).parents('.line-vals').find('.item-total');
			var discount = (qty * rate * percent).toFixed(2);
			var total    = (qty * rate - discount).toFixed(2);

			// Update line item
			$(this).parents('.line-vals').find('.line-total').text(total);
			$(this).parents('.line-vals').find('.line-total-input').val(total);
		},

		updateTotals:function(){
			var tax      = ( isNaN( parseFloat($('#lb-tax-rate').val()) ) ? 0 : parseFloat($('#lb-tax-rate').val()) / 100 );
			var subTotal = 0;
			var total    = 0;

			// subtotal
			$.each($('.line-total-input'), function(index, val) {
				subTotal += parseFloat($(val).val());
			});

			$('.subtotal-val').text((subTotal).toFixed(2));
			$('.subtotal-input').val((subTotal).toFixed(2));

			// And total
			total += subTotal + (subTotal * tax);
			$('.total-val').text((total).toFixed(2));
			$('.total-input').val((total).toFixed(2));
		},

		padInt:function(str, max) {
		  str = str.toString();
		  return str.length < max ? LineItems.padInt("0" + str, max) : str;
		}

	}
	LineItems.init();

	var Clients = {

		init:function(){
			this.attachEvents();
		},

		attachEvents:function(){
			$('.save-client').on('click', this.updateClient);
		},

		updateClient:function(){

			$('#lb-feedback').css('opacity', 0);
			$('#client-loader').css('opacity', 1);

			if (!$('#add-new-client .email input').val().length) {
				$('#lb-feedback p').html('Client must at <em>least</em> an email');
				$('#lb-feedback').css('opacity', 1);
				$('#lb-feedback').removeClass('notice-success');
				$('#lb-feedback').addClass('notice-error');

				return;
			}

			var data = {
				action         : 'create_client',
				nonce          : ajax_object.ajax_nonce,
				first_name     : $('.first-name input').val(),
				last_name      : $('.last-name input').val(),
				email          : $('.email input').val(),
				website        : $('.website input').val(),
				company_name   : $('.company input').val(),
				phone_number   : $('.phone-number input').val(),
				street_address : $('.street-address input').val(),
				city           : $('.city input').val(),
				state          : $('.state input').val(),
				zip            : $('.zipcode input').val(),
				country        : $('.country input').val(),
				client_notes   : $('#client-notes').val(),
				lb_client      : 1
			};

			$.ajax({
				url     : ajax_object.ajax_url,
				type    : 'POST',
				data    : data,
				success : function( resp ){
					$('#client-loader').css('opacity', 0);
					$('#lb-feedback').css('opacity', 1);
					$('#lb-feedback p').empty();
					if (resp.error) {
						$('#lb-feedback').removeClass('notice-success');
						$('#lb-feedback').addClass('notice-error');
						$('#lb-feedback p').append(resp.message);
					} else{
						// add to select menu
						$('#lb-feedback').removeClass('notice-error');
						$('#lb-feedback').addClass('notice-success');
						$('#lb-feedback p').append('Success! Client added.');
						Clients.appendNewUser(resp.data);
					}
				}
			});
		},

		appendNewUser:function(user){
			var optName, option;
			if (user.company_name.length) {
				optName = user.company_name;
			} else {
				optName = user.first_name + ' ' + user.last_name;
			}
			option = '<option value="' + user.user_id + '" selected >' + optName + '</option>';
			$('#lb-client').append(option);

		},

	}
	Clients.init();


	$('#due-date-div').find('.save-due-date').click( function() {
		updateDueDate(); 
	});

	$('.edit-due-date').on('click', function() {
		$('#due-date-div').slideDown('fast');
	});

	$('.cancel-due-date').on('click', function() {
		$('#due-date-div').slideUp('fast');
	});

	function updateDueDate(){
		var	mm = $('#due-mm'),
			jj = $('#due-jj').val(),
			Y  = $('#due-y').val();

		$('#due-date-div').slideUp('fast');
		$('#lb-due-date b').html( $( '#due-mm option:selected' ).data( 'text' ) + ' ' + parseInt( jj, 10 ) + ', ' + Y );
	}

})( jQuery );