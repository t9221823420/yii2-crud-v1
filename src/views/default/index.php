<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yozh\widget\widgets\grid\GridView;
use yii\widgets\Pjax;
use yozh\widget\widgets\Modal;
use yozh\widget\widgets\ActiveButton;
use yozh\crud\widgets\NestedModel;

/**
 * @var $this \yii\web\View
 */

include __DIR__ . '/_header.php';

$columns = $columns ?? $searchModel->attributesIndexList();

if( Yii::$app->request->isNested ) {
	$nestedAttributes[ NestedModel::PARAM_NESTED ] = 1;
}

?>

<div class="<?= "$modelId-$actionId" ?>">
	
	<?php if( !Yii::$app->request->isAjax ): ?>
		
		<?= $this->render( '_search', $_params_ ); ?>

        <h1><?= Html::encode( $this->title ) ?></h1>
	
	<?php endif; ?>
	
	<?php Pjax::begin( [
		'id' => $pjaxId = 'pjax' . $jsId,
		//'timeout' => 10000,
	] ); ?>

    <p>
		<?= Modal::widget( [
			'id'           => $modalId = 'modal' . $jsId,
			'ajaxSubmit'   => true,
			'header'       => Yii::t( 'app', 'Add new' ),
			'footer'       => false,
			'toggleButton' => ActiveButton::widget( [
				'tagName' => 'a',
				'url'     => Url::to( [ 'create' ] ),
				'type'    => ActiveButton::TYPE_YES,
				'label'   => Yii::t( 'app', 'Add' ),
				'action'  => $jsId . '.create',
				'data'    => $nestedAttributes ?? [],
                'options' => [
	                'data-pjax' => 0,
                ],
			] ),
		] ); ?>
    </p>
	
	<?= GridView::widget( [
		'dataProvider' => $dataProvider,
		'filterModel'  => Yii::$app->request->isNested
                ? null
                : $searchModel instanceof \yozh\base\interfaces\models\ActiveRecordSearchInterface
                    ? $searchModel
                    : null,
		'layout'       => "{items}\n{pager}{limits}",
		'showHeader'   => $dataProvider->getCount() > 0,
		'tableOptions' => [
			'class' => 'table table-striped table-hover',
		],
		
		'columns' => $columns,
	
	] ); ?>
	
	<?php $this->registerJs( $this->render( '_js.php', [
		'section' => 'modal',
		'jsId'    => $jsId,
		'modalId' => $modalId,
		'pjaxId'  => $pjaxId,
	] ), $this::POS_END ); ?>
	
	<?php Pjax::end(); ?>

</div>