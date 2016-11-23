( function( $ ) {

	$(window).bind('beforeunload', function() {} );

	var LineItems = {

		init:function(){
			this.attachEvents();
		},

		attachEvents:function(){
			$('#all-line-items').on('change paste keyup', 'input.sub-fixed', this.updateLineItemTotal);
		},

		updateLineItemTotal:function(){
			
			var qty     = ( isNaN( parseFloat($(this).parents('.line-vals').find('.item-qty').val()) ) ? 0 : parseFloat($(this).parents('.line-vals').find('.item-qty').val()) );
			var rate    = ( isNaN( parseFloat($(this).parents('.line-vals').find('.item-rate').val()) ) ? 0 : parseFloat($(this).parents('.line-vals').find('.item-rate').val()) );
			var percent = ( isNaN(parseFloat($(this).parents('.line-vals').find('.item-percent').val()) / 100) ? 0 : parseFloat($(this).parents('.line-vals').find('.item-percent').val()) / 100  );
			var totalEl = $(this).parents('.line-vals').find('.item-total');
			var discount = qty * rate * percent;
			var total = qty * rate - discount;

			// Update line item
			$(this).parents('.line-vals').find('.line-total').text(total);
			$(this).parents('.line-vals').find('.line-total-input').val(total);

			// update totals
			LineItems.updateTotals();
		},

		updateTotals:function(){

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