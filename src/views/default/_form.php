<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yozh\crud\widgets\ActiveForm;
use yozh\form\ActiveField;
use yozh\base\components\helpers\ArrayHelper;

/*
$inputs = [];

foreach( ActiveField::getInputs() as $_name => $item ) {
	$inputs[ $_name ] = $item['label'];
}

$widgets = [];

if( $Model->type ) {
	foreach( ActiveField::getWidgets( $Model->type ) as $_name => $item ) {
		$widgets[ $_name ] = $item['label'];
	}
}

$fields = function( $form ) use ( $Model, $inputs, $widgets ) {
	
    $foo = $form->field( $Model, 'name' );
    
	return [
		
		'name' => $form->field( $Model, 'name' ),
		
		'type' => $form->field( $Model, 'type' )->dropDownList( $inputs, [
			'class'           => 'form-control yozh-widget yozh-widget-nested-select',
			'data-url'             => Url::to( [ 'get-widgets-list' ] ),
			'data-selector' => '#' . Html::getInputId( $Model, 'widget' ),
			'prompt'          => Yii::t( 'app', 'Select' ),
		] ),
		
		'widget' => $form->field( $Model, 'widget' )->dropDownList( $widgets, [
			'class'  => 'form-control',
			'prompt' => Yii::t( 'app', 'Select' ),
		] ),
		
		'config' => $form->field( $Model, 'config' )->baseWidget( ActiveField::WIDGET_TYPE_TEXTAREA ),
		
		'data' => $form->field( $Model, 'data' )->baseWidget( $Model->widget ),
	
	];
};
*/

$_renderInPlace_ = $_renderInPlace_ ?? true;

?>

<?php

$this->blocks['crud.form.wrapper'] = "<div class=\"crud-form\">{crud.form}</div>";

$this->beginBlock( 'crud.form', false );

$form = ActiveForm::begin();

print "{crud.form.body}";

ActiveForm::end();

$this->endBlock();

if( preg_match( '/(?<beginForm>\<form.*?\>).*?(?<csrf>\<input.*?\>).*?(?<endForm>\<\/form\>)/ms', $this->blocks['crud.form'], $matches ) ) {
	$this->blocks['crud.form']      = $matches['beginForm'] . '{crud.form.body}' . $matches['endForm'];
	$this->blocks['crud.form.csrf'] = $matches['csrf'];
}

$this->blocks['crud.form.body']    = ( $this->blocks['crud.form.csrf'] ?? false ? "{crud.form.csrf}\n" : '' ) . "{crud.form.fields}\n{crud.form.controls}";

$fields = $form->fields( $Model, $attributes ?? null, [
	'nestedAttributes' => $nestedAttributes,
	'fields' => $fields ?? [],
] );

foreach( $fields as $_fieldName => $_fieldOutput ) {
	$this->blocks['crud.form.fields'][ '{' . $_fieldName . '}' ] = $_fieldOutput;
}

$this->blocks['crud.form.controls'] = '<div class="form-group">' . Html::submitButton( Yii::t( 'app', 'Save' ), [ 'class' => 'btn btn-success' ] ) . '</div>';

if( $_renderInPlace_ ) {
	
	$this->blocks['crud.form.fields'] = implode( "\n", $this->blocks['crud.form.fields'] );
	
	$this->blocks['crud.form.body'] = strtr( $this->blocks['crud.form.body'], [
		'{crud.form.csrf}'     => $this->blocks['crud.form.csrf'] ?? '',
		'{crud.form.fields}'   => $this->blocks['crud.form.fields'] ?? '',
		'{crud.form.controls}' => $this->blocks['crud.form.controls'] ?? '',
	] );
	
	$this->blocks['crud.form'] =  strtr( $this->blocks['crud.form'], [
		'{crud.form.body}' => $this->blocks['crud.form.body'],
	] );
	
	$this->blocks['crud.form.wrapper'] =  strtr( $this->blocks['crud.form.wrapper'], [
		'{crud.form}' => $this->blocks['crud.form'],
	] );
	
	print $this->blocks['crud.form.wrapper'];
	
}

// garbage
unset( $_except );
unset( $_name );
unset( $_fieldName );
unset( $_fieldOutput );
unset( $_value );