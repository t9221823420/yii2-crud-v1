<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yozh\crud\widgets\ActiveForm;
use yozh\form\ActiveField;
use yozh\base\components\helpers\ArrayHelper;

$this->blocks['crud.form.wrapper'] = "<div class=\"crud-form\">{crud.form}</div>";

$this->beginBlock( 'crud.form', false );

$form = ActiveForm::begin( $formConfig ?? [] );

print "{crud.form.body}";

ActiveForm::end();

$this->endBlock();

if( preg_match( '/(?<beginForm>\<form.*?\>).*?(?<csrf>\<input.*?\>).*?(?<endForm>\<\/form\>)/ms', $this->blocks['crud.form'], $matches ) ) {
	$this->blocks['crud.form']      = $matches['beginForm'] . '{crud.form.body}' . $matches['endForm'];
	$this->blocks['crud.form.csrf'] = $matches['csrf'];
}

$this->blocks['crud.form.body']    = $this->blocks['crud.form.body'] ?? ( $this->blocks['crud.form.csrf'] ?? false ? "{crud.form.csrf}\n" : '' ) . "{crud.form.fields}\n{crud.form.controls}";

$fields = $form->fields( $Model, $attributes ?? null, [
	'fields' => $fields ?? [],
	'nestedAttributes' => $nestedAttributes ?? [],
] );

foreach( $fields as $_fieldName => $_fieldOutput ) {
	$this->blocks['crud.form.fields'][ '{' . $_fieldName . '}' ] = $_fieldOutput;
}

$this->blocks['crud.form.controls'] = $this->blocks['crud.form.controls'] ?? '<div class="form-group">' . Html::submitButton( Yii::t( 'app', 'Save' ), [ 'class' => 'btn btn-success' ] ) . '</div>';

if( $_renderInPlace_ ?? true ) {
	
	$render = function( $self, $fields ){
		
		$output = '';
		
		foreach( $fields as $field ) {
			
			if( is_string( $field ) || is_numeric( $field ) || $field instanceof \yii\widgets\ActiveField ) {
				$output .= $field;
			}
			
			else if( is_array( $field ) ) {
				
				$output .= $self( $self, $field);
				
			}
		}
		
		return $output;
	};
	
	$this->blocks['crud.form.fields'] = $render( $render, $this->blocks['crud.form.fields'] );
	
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