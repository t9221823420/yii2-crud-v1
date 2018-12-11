<?php

use yii\helpers\Html;
use yii\helpers\Inflector;

if( !isset( $Model ) && isset( $ModelSearch ) ) {
	$Model = $ModelSearch;
}
// $ModelSearch need to render _search.php
/*
elseif( !isset( $ModelSearch ) && isset( $Model ) ){
	$ModelSearch = $Model;
}
*/

$_params_['actionId']    = $actionId = $this->context->action->id;
$_params_['actionTitle'] = $actionTitle = Yii::t( 'app', Inflector::camel2words( $this->context->action->id ) );

$_params_['modelId'] = $modelId = Inflector::camel2id( ( new\ReflectionObject( $Model ) )->getShortName() );

$modelTitle = Yii::t( 'app', Inflector::camel2words( ( new\ReflectionObject( $Model ) )->getShortName() ) );

$modelTitle = trim( preg_replace( '/(Search|)/', '', $modelTitle ) );

$_params_['modelTitle'] = $modelTitle;

if( 0 && isset($ModelSearch) && Yii::$app->request->get( $ModelSearch->formName() ) ){
	$this->title = Yii::t( 'app', 'Search result') . ": $modelTitle";
}
else{
	$this->title = $this->title ?? "$actionTitle: $modelTitle";
}

//костыль
if( !($this->params['breadcrumbs'] ?? false && (end($this->params['breadcrumbs'])['label'] ?? '') == $modelTitle)){
	$this->params['breadcrumbs'][] = [ 'label' => $modelTitle, 'url' => [ 'index' ] ];
}

$jsId = $jsId ?? $this->context->jsId;