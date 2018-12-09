<?php

use yii\helpers\Html;
use yozh\widget\widgets\DetailView;

include __DIR__ . '/_header.php';

/* @var $this yii\web\View */

if( $Model instanceof \yozh\base\interfaces\models\ActiveRecordInterface ) {
	
	foreach( $Model->shemaReferences() as $refName => $reference ) {
		
		foreach( $reference as $fk => $pk ) {
			$attributeReferences[ $fk ][ $refName ] = $reference;
		}
		
	}
	
	$fk = $pk = null;
}

$trap = 1;

?>
<div class="<?= "$modelId-$actionId" ?>">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <p>
		<?= Html::a( Yii::t( 'app', 'Update'), [ 'update', 'id' => $Model->id ], [ 'class' => 'btn btn-primary' ] ) ?>
		<?= Html::a( Yii::t( 'app', 'Delete'), [ 'delete', 'id' => $Model->id ], [
			'class' => 'btn btn-danger',
			'data'  => [
				'confirm' => Yii::t( 'app', 'Are you sure you want to delete this item?'),
				'method'  => 'post',
			],
		] ) ?>
    </p>
	
	<?= DetailView::widget( [
		'model'      => $Model,
		'attributes' => array_keys( $Model->attributes ),
	] ) ?>
 
</div>