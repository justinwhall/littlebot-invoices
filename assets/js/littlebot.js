( function( $ ) {

	$('#due-date-div').find('.save-due-date').click( function( event ) { 
		event.preventDefault();

			// $('#due-date-div').slideUp('fast');
			// $('#due-date-div').siblings('a.edit-timestamp').show().focus();
			 
			var	mm = $('#due-mm'),
				jj = $('#due-jj').val(),
				Y  = $('#due-y').val();

			$('#due_date b').html( $( '#due-mm option:selected' ).data( 'text' ) + ' ' + parseInt( jj, 10 ) + ', ' + Y );

	});

})( jQuery );