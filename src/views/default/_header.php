<?php

use yii\helpers\Html;
use yii\helpers\Inflector;

if( !isset( $model ) && isset( $searchModel ) ) {
	$model = $searchModel;
}

$_params_['actionId']    = $actionId = $this->context->action->id;
$_params_['actionTitle'] = $actionTitle = Yii::t( 'app', Inflector::camel2words( $this->context->action->id ) );

$_params_['modelId'] = $modelId = Inflector::camel2id( ( new\ReflectionObject( $model ) )->getShortName() );

$modelTitle = Yii::t( 'app', Inflector::camel2words( ( new\ReflectionObject( $model ) )->getShortName() ) );

$modelTitle = trim( preg_replace( '/(Search|)/', '', $modelTitle ) );

$_params_['modelTitle'] = $modelTitle;

if( isset($searchModel) && Yii::$app->request->get( $searchModel->formName() ) ){
	$this->title = Yii::t( 'app', 'Search result') . ": $modelTitle";
}
else{
	$this->title = "$actionTitle: $modelTitle";
}

$this->params['breadcrumbs'][] = [ 'label' => $modelTitle, 'url' => [ 'index' ] ];
//$this->params['breadcrumbs'][] = $actionTitle;

?>