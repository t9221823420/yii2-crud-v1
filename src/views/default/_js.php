<?php

use yii\helpers\Html;
use yii\helpers\Url;

//

?>
<?php if( $printTags ?? false ) : ?>
<script type='text/javascript'><?php endif; ?>
	
	<?php switch($section) : case 'onload' : ?>
	
	$( function () {
		
		$( '#' + yozh.Modal.pluginId ).on( yozh.Modal.EVENT_SUBMIT, function () {
			$.pjax.reload( { container : '#pjax-container', async : false } );
		} );
		
	} );
	
	<?php break; case 'modal' : ?>
	
	
	var _confirm = function ( _$target, _config ) {
		
		var _deferred = yozh.Modal.helpers.confirm( _$target, _config );
		
		return _deferred;
	}
	
	var _done = function ( _response, _status, xhr, _$target ) {
		
		/*
		$( '#selector' + _$target.data( 'id' ) ).find( '.icon' )
			.removeClass( 'icon-status-new' )
			.addClass( 'icon-status-close' )
		;
		
		_$target.parent().html( _response );
		*/
		
	}
	
	var _create = function ( _$target ) {
		
		$( '#' + yozh.Modal.pluginId ).yozhModal( {
			url : '<?= Url::to( [ 'create' ] ) ?>'
		} ).show();
		
	}
	
	var _update = function ( _$target ) {
		
		$( '#' + yozh.Modal.pluginId ).yozhModal( {
			url : '<?= Url::to( [ 'update?id=' ] ) ?>' + _$target.data('id')
		} ).show();
		
	}
	
	<?php break; case 'template' : ?>
	
	
	<?php break; default: ?>
	
	<?php endswitch; ?>
	<?php if( $printTags ?? false ) : ?></script><?php endif; ?>
