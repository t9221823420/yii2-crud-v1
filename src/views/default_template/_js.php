<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php if( $printTags ?? false ) : ?>
<script type='text/javascript'><?php endif; ?>
	
	<?php switch($section) : case 'onload' : ?>
	
	$( function () {
		
		/*
			$(document).on('change', 'select.yozh-nested-select', function () {
				$($(this).data('selector')).load($(this).attr('url'), 'value=' + $(this).val());
			});
		*/
		
	} );
	
	<?php break; case 'template' : ?>
	
	<?php break; default: ?>
	
	<?php endswitch; ?>
	<?php if( $printTags ?? false ) : ?></script><?php endif; ?>
