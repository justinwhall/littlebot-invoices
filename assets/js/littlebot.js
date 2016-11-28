( function( $ ) {

	var LineItems = {

		init:function(){
			this.attachEvents();
		},

		attachEvents:function(){
			$('.lb-calc-container').on('change paste keyup', 'input.lb-calc-input', this.updateLineItemTotal);
			$('.lb-calc-container').on('change paste keyup', 'input.lb-calc-input', this.updateTotals);
			// add client
			$('.save-client').on('click', this.updateClient);
		},

		updateClient:function(){
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
					if (resp.error) {
						$('.add-user-feedback').append(resp.message);
					} else{
						LineItems.appendNewUser(resp.data);
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


	$('#due-date-div').find('.save-due-date').click( function() {
		updateDueDate(); 
	});

	$('.edit-due-date').on('click', function() {
		$('#due-date-div').slideDown('fast');
	});

	$('.cancel-due-date').on('click', function() {
		$('#due-date-div').slideUp('fast');
	});

	// Add line item
	$('.add-line-item').on('click', function(e) {
		e.preventDefault();
		addLineItem();
	});

	function addLineItem(){
		var template = wp.template( 'line-item' );
		console.log(template);
		$('#all-line-items').append( 
			template( { 
				test: 'test'
			} ) 
		);
	}

	function updateDueDate(){
		var	mm = $('#due-mm'),
			jj = $('#due-jj').val(),
			Y  = $('#due-y').val();

		$('#due-date-div').slideUp('fast');
		$('#lb-due-date b').html( $( '#due-mm option:selected' ).data( 'text' ) + ' ' + parseInt( jj, 10 ) + ', ' + Y );
	}

})( jQuery );