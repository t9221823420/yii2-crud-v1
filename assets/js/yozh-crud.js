( function ( $, undefined ) {
	
	$( '.filters' ).on( 'change', 'input', function () {
		
		this.form.submit();
		
		/*
		var _$form = $( this.form );
		var _formData = new FormData( this.form );
		
		$.ajax( {
				url : _$form.attr( 'action' ),
				type : _$form.attr( 'method' ),
				data : _formData,
				processData : false,
				contentType : false,
			} )
			.done( function ( _response, status, xhr ) {
				$( "#pjax-container" ).html( _response );
			} )
			.fail( function ( _response, status, xhr ) {
			
			} )
		;
		*/
		
	} )
	
}( jQuery ) );