<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yozh\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

//$searchModel = $searchModel ?? new \backend\modules\prosell\models\prosell\OrderSearch();

?>

<style>

    .panel.search .panel-heading .form-item,
    .panel.search .panel-heading .form-control,
    .common-search > * {
        display: inline-block;
    }

    .panel.search .panel-heading .form-control.btn,
    .common-search .form-control.btn {
        margin-left: 10px;
        width: auto;
    }

    .common-search,
    .advanced-search,
    .advanced-search > .panel-group {
        position: relative;
        width: 100%;
    }

</style>

<?php if( $searchModel->filter_search ?? false ): ?>
	
	<?php $form = ActiveForm::begin( [
		//'id'     => 'search-form',
		//'action' => Url::to( [ 'search' ] ),
		'method' => 'get',
	] ); ?>


    <div class="w-100 valign-bottom-container inline-block-container form-group">

        <div class="common-search">
			<?= $form->field( $searchModel, 'filter_search', [
				'options' => [
					'class'  => 'w-50 form-item',
					'prompt' => Yii::t( 'app', 'Name' ),
				],
			] )
			         ->label( false ) ?>
			
			<?= Html::submitButton( Yii::t( 'app', 'Search' ), [ 'class' => 'btn btn-success form-control' ] ) ?>

        </div>

    </div>
	
	<?php ActiveForm::end(); ?>

<?php endif; ?>