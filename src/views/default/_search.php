<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yozh\form\ActiveForm;
use kartik\date\DatePicker;
use yozh\crud\AssetBundle;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

$fields = $fields ?? [];

$fields = function( $form, $searchModel ) use ( $fields ) {
	
	if( property_exists( $searchModel, 'filter_dateFrom' ) || property_exists( $searchModel, 'filter_dateFrom' ) ) {
		
		$dateConfig = [
			'type'          => DatePicker::TYPE_COMPONENT_APPEND,
			'options'       => [
				'class'       => 'form-control',
				'placeholder' => Yii::t( 'app', 'Select date' ),
			],
			'pluginOptions' => [
				'format'         => 'd.mm.yyyy',
				'todayHighlight' => true,
				'todayBtn'       => true,
				'autoclose'      => true,
			],
		];
		
	}
	
	if( property_exists( $searchModel, 'filter_dateFrom' ) ) {
		
		$fields['filter_dateFrom'] = $form->field( $searchModel, 'filter_dateFrom' )
		                                  ->label( Yii::t( 'app', 'Date from' ) )
		                                  ->widget( DatePicker::class, $dateConfig )
		;
		
	}
	
	if( property_exists( $searchModel, 'filter_dateTo' ) ) {
		
		$fields['filter_dateTo'] = $form->field( $searchModel, 'filter_dateTo' )
		                                ->label( Yii::t( 'app', 'Date to' ) )
		                                ->widget( DatePicker::class, $dateConfig )
		;
		
	}
	
	return $fields;
};

AssetBundle::register( $this );

?>

<?php $form = $form ?? ActiveForm::begin( [
	//'id'     => 'search-form',
	//'action' => Url::to( [ 'search' ] ),
	'method' => 'get',
] ); ?>

<?php if( property_exists( $searchModel, 'filter_search' ) ): ?>


    <div class="w-100 valign-bottom-container inline-block-container form-group">

        <div class="common-search">
			
			<?= $form->field( $searchModel, 'filter_search', [
				'options' => [
					'class'  => 'w-50 form-item',
					'prompt' => Yii::t( 'app', 'Name' ),
				],
			] )->label( false ) ?>
			
			<?= Html::submitButton( Yii::t( 'app', 'Search' ), [ 'class' => 'btn btn-success form-control' ] ) ?>

        </div>

    </div>


<?php endif; ?>

<div class="w-100 valign-bottom-container inline-block-container form-group">
 
	<?php foreach( $fields( $form, $searchModel ) as $field ) : ?>
		<?= $field; ?>
	<?php endforeach; ?>
    
    <div class="form-group">
	    <?= Html::submitButton( Yii::t( 'app', 'Filter' ), [ 'class' => 'btn btn-primary' ] ) ?>
    </div>
    
    <div class="form-group">
	    <?= Html::a( Yii::t( 'app', 'Reset' ), [ 'index' ], [ 'class' => 'btn btn-primary' ] ) ?>
    </div>
 
</div>

<?php ActiveForm::end(); ?>
