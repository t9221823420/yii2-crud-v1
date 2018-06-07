<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yozh\form\ActiveForm;
use yozh\form\ActiveField;

/*
$inputs = [];

foreach( ActiveField::getInputs() as $name => $item ) {
	$inputs[ $name ] = $item['label'];
}

$widgets = [];

if( $model->type ) {
	foreach( ActiveField::getWidgets( $model->type ) as $name => $item ) {
		$widgets[ $name ] = $item['label'];
	}
}

$fields = function( $form ) use ( $model, $inputs, $widgets ) {
	
    $foo = $form->field( $model, 'name' );
    
	return [
		
		'name' => $form->field( $model, 'name' ),
		
		'type' => $form->field( $model, 'type' )->dropDownList( $inputs, [
			'class'           => 'form-control yozh-widget yozh-widget-nested-select',
			'url'             => Url::to( [ 'get-widgets-list' ] ),
			'nested-selector' => '#' . Html::getInputId( $model, 'widget' ),
			'prompt'          => Yii::t( 'app', 'Select' ),
		] ),
		
		'widget' => $form->field( $model, 'widget' )->dropDownList( $widgets, [
			'class'  => 'form-control',
			'prompt' => Yii::t( 'app', 'Select' ),
		] ),
		
		'config' => $form->field( $model, 'config' )->baseWidget( ActiveField::WIDGET_TYPE_TEXTAREA ),
		
		'data' => $form->field( $model, 'data' )->baseWidget( $model->widget ),
	
	];
};
*/


?>

<div class="">
	
	<?php $form = ActiveForm::begin(); ?>
	
	<?php $fields = $form->fields( $model, $model->attributeEditList()
		//,[ 'print' => false, ]
	);?>

    <div class="form-group">
		<?= Html::submitButton( Yii::t( 'app', 'Save' ), [ 'class' => 'btn btn-success' ] ) ?>
    </div>
	
	<?php ActiveForm::end(); ?>

</div>