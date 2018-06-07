<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yozh\widget\widgets\Modal;
use yozh\widget\widgets\ActiveButton;

include '_header.php';

/**
 * @var \yozh\crud\models\BaseModel $model
 */
$columns = $model->attributeIndexList();

array_push( $columns, [
		'class'          => 'yii\grid\ActionColumn',
		'header'         => 'Actions',
		'contentOptions' => [ 'class' => 'actions' ],
		'template'       => '{update}{delete}',
		'buttons'        => [
			
			'update' => function( $url, $model ) {
				
				return ActiveButton::widget( [
					'label'       => '<span class="glyphicon glyphicon-pencil"></span>',
					'encodeLabel' => false,
					'tagName'     => 'a',
					'action'      => '_update',
					'options'     => [
						//'class' => 'btn btn-success',
					],
					
					'model'      => $model,
					'attributes' => [ 'id', ],
				
				] );
				
				return Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $url, [
					'title' => Yii::t( 'app', 'Update' ),
				] );
			},
			
			/*
			'delete' => function( $url, $model ) {
				return Html::a( '<span class="glyphicon glyphicon-trash"></span>', $url, [
					'title'       => Yii::t( 'app', 'Delete' ),
					'data-method' => 'post',
				] );
			},
		
				*/
		],
		
		/*
		'urlCreator' => function( $action, $model, $key, $index ) {
			
			$classname = strtolower( ( new\ReflectionObject( $model ) )->getShortName() );
			
			return Url::to( "/$classname/{$model->id}/$action" );
		}
		*/
	]

);

?>

<?= $this->render( '_search', $_params_ ); ?>

<div class="<?= "$modelId-$actionId" ?>">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <p>
		<?= Modal::widget( [
			'id'           => Modal::PLUGIN_ID,
			'ajaxSubmit'   => true,
			'header'       => Yii::t( 'app', 'Add new' ),
			'footer'       => false,
			'toggleButton' => ActiveButton::widget( [
				'type'        => ActiveButton::TYPE_YES,
				'label'       => Yii::t( 'app', 'Add' ),
				'action'      => '_create',
			] ),
		] ); ?>
    </p>
	
	<?php Pjax::begin( [ 'id' => 'pjax-container' ] ); ?>
	
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<?= GridView::widget( [
		'dataProvider' => $dataProvider,
		//'filterModel' => $searchModel,
		//'layout'       => "{items}\n{pager}",
		//'showHeader'   => false,
		'tableOptions' => [
			'class' => 'table table-striped table-hover',
		],
		
		'columns' => $columns,
	
	] ); ?>
	
	<?php Pjax::end(); ?>

</div>

<?php $this->registerJs( $this->render( '_js.php', [ 'section' => 'onload' ] ), $this::POS_END ); ?>
<?php $this->registerJs( $this->render( '_js.php', [ 'section' => 'modal' ] ), $this::POS_END ); ?>
