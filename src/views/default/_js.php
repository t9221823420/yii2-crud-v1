<?php

use yii\helpers\Html;
use yii\helpers\Url;

//

?>
<?php if( $printTags ?? false ) : ?>
<script type='text/javascript'><?php endif; ?>
	
	<?php switch($section) : case 'onload' : ?>
	
	$( function () {
		
	} );
	
	<?php break; case 'modal' : ?>
	
    var <?= $jsId ?> = {
    	
    	id : '<?= $jsId ?>',
    
		confirm : function ( _$target, _config ) {
			
			var _deferred = yozh.Modal.helpers.confirm( _$target, _config );
			
			return _deferred;
		},
		
		done : function ( _response, _status, xhr, _$target ) {
			
			/*
			$( '#selector' + _$target.data( 'id' ) ).find( '.icon' )
				.removeClass( 'icon-status-new' )
				.addClass( 'icon-status-close' )
			;
			
			_$target.parent().html( _response );
			*/
			
		},
		
		action : function ( _$target, _url ) {
			
    		_$target.data() ? _url = _url + '?' : '';
    		
			$( '#<?= $modalId ?>' ).yozhModal( {
				url : _url + $.param( _$target.data() )
			} ).show();
			
		},
		
		create : function ( _$target ) {
    		this.action( _$target, '<?= Url::to( [ 'create' ] ) ?>' );
		},
		
		update : function ( _$target ) {
    		this.action( _$target, '<?= Url::to( [ 'update' ] ) ?>' );
		},
		
		clone : function ( _$target ) {
    		this.action( _$target, '<?= Url::to( [ 'clone' ] ) ?>' );
		},
		
    };
    
	$( function () {
		
		$( '#<?= $modalId ?>' ).one( yozh.Modal.EVENT_SUBMIT, function ( _response, status, xhr ) {
			$.pjax.reload( {
                container : '#<?= $pjaxId ?>',
                async : false,
			} );
		} );
		
	} );

    <?php break; case 'template' : ?>
	
	
	<?php break; default: ?>
	
	<?php endswitch; ?>
	<?php if( $printTags ?? false ) : ?></script><?php endif; ?>
