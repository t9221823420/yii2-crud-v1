<?php

use yii\helpers\Html;
use yii\helpers\Url;

include( Yii::getAlias( $parentViewPath . DIRECTORY_SEPARATOR . basename( __FILE__ ) ) );

?>

<?php if( $printTags ?? false ) : ?>
<script type='text/javascript'><?php endif; ?>
	
	<?php switch($section) : case 'onload' : ?>
	
	$( function () {
		
	} );
	
	<?php break; case 'template' : ?>
	
	<?php break; default: ?>
	
	<?php endswitch; ?>
	
	<?php if( $printTags ?? false ) : ?>
</script><?php endif; ?>
