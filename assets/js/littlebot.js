( function( $ ) {

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