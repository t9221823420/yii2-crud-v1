<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

include __DIR__ . '/_header.php';

/* @var $this yii\web\View */

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
