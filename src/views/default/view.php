<?php

use yii\helpers\Html;
use yozh\widget\widgets\DetailView;

include __DIR__ . '/_header.php';

/**
 * @var \yozh\crud\models\BaseActiveRecord $Model
 * @var $this yii\web\View
 */

?>
<div class="<?= "$modelId-$actionId" ?>">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <p>
		<?= Html::a( Yii::t( 'app', 'Update' ), [ 'update', 'id' => $Model->id ], [ 'class' => 'btn btn-primary' ] ) ?>
		<?= Html::a( Yii::t( 'app', 'Delete' ), [ 'delete', 'id' => $Model->id ], [
			'class' => 'btn btn-danger',
			'data'  => [
				'confirm' => Yii::t( 'app', 'Are you sure you want to delete this item?' ),
				'method'  => 'post',
			],
		] ) ?>
    </p>
	
	<?= DetailView::widget( [
		'model'      => $Model,
		'attributes' => $Model instanceof \yozh\base\interfaces\models\ActiveRecordInterface
			? $Model->attributesViewList()
			: array_keys( $Model->attributes ),
	] ) ?>

</div>