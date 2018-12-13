<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 24.06.2018
 * Time: 10:16
 */

namespace yozh\crud\actions;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yozh\base\interfaces\models\ActiveRecordInterface;
use yii\db\Query;
use yozh\crud\widgets\NestedModel;
use yozh\widget\widgets\ActiveButton;
use yozh\widget\widgets\grid\ActionColumn;

class IndexAction extends \yozh\base\actions\IndexAction
{
	public function process()
	{
		$nestedAttributes = null;
		
		$jsId = $this->controller->jsId;
		
		/**
		 * @var ActiveRecordInterface $ModelSearch
		 */
		extract( parent::process() );
		
		$Model = $ModelSearch;
		
		$Shema = Yii::$app->db->getSchema();
		
		/*
		$tableName = $Shema->getRawTableName( $Model::tableName() );
		
		$tableSchema = $Shema->getTableSchema( $tableName );
		*/
		
		/**
		 * @var \yozh\crud\models\BaseActiveRecord $Model
		 */
		if( Yii::$app->request->isNested
			&& $nestedAttributes = ( Yii::$app->request->queryParams )[ $Model->formName() ] ?? []
		) {
			$columns = $Model->attributesIndexList( null, array_keys( $nestedAttributes ) );
		}
		else {
			$columns = $Model->attributesIndexList();
		}
		
		$shemaColumns = $Model->shemaColumns();
		
		foreach( $columns as $key => $attributeName ) {
			
			if( $references = $Model->getAttributeReferences( $attributeName ) ) {
				
				foreach( $references as $refName => $Reference ) {
					
					$label = Yii::t( 'app', preg_replace( '/\sId$/', '', Html::encode( $Model->getAttributeLabel( $attributeName ) ) ) );
					
					$refItems = $Model->getAttributeReferenceItems( $attributeName, $Reference );
					
					$columns[ $key ] = [
						'attribute' => $attributeName,
						'label'     => $label,
						'filter'    => $refItems,
						'value'     => function( $Model, $key, $index, $widget ) use ( $attributeName, $refItems ) {
							return $refItems[ $Model->$attributeName ] ?? null;
						},
					];
					
				}
				
			}
			
			else if( in_array( $shemaColumns[ $attributeName ]->dbType, [ 'set', 'enum' ] ) ) {
				
				$values = $shemaColumns[ $attributeName ]->enumValues ?? [];
				
				$columns[ $key ] = [
					'attribute' => $attributeName,
					'label'     => $Model->getAttributeLabel( $attributeName ),
					'filter'    => array_combine( $values, $values ),
				];
				
			}
		}
		
		$editAction = function( $url, $Model, $action, $icon ) use ( $nestedAttributes, $jsId ) {
			
			if( $nestedAttributes ) {
				$nestedAttributes[ NestedModel::PARAM_NESTED ] = 1;
			}
			
			return ActiveButton::widget( [
				'label'       => "<span class=\"glyphicon glyphicon-$icon\"></span>",
				'encodeLabel' => false,
				'tagName'     => 'a',
				'action'      => "$jsId.$action",
				'url'         => Url::to( [ $action ] + $Model->getPrimaryKey(true) ),
				'options'     => [
					//'class' => 'btn btn-success',
				],
				
				'model'      => $Model,
				'attributes' => [ 'id', ],
				'data'       => $nestedAttributes ?? [],
			
			] );
			
			/*
			return Html::a( '<span class="glyphicon glyphicon-pencil"></span>', $url, [
				'title' => Yii::t( 'app', 'Update' ),
			] );
			*/
		};
		
		$columns['_actions'] = [
			'class'          => ActionColumn::class,
			'header'         => 'Actions',
			'headerOptions'  => [ 'class' => 'actions' ],
			'filterOptions'  => [ 'class' => 'actions' ],
			'contentOptions' => [ 'class' => 'actions' ],
			
			'filter' => ''
				. Html::submitButton( Yii::t( 'app', 'Filter' ), [ 'class' => 'btn btn-primary' ] )
				. Html::a( Yii::t( 'app', 'Reset' ), [ 'index' ], [ 'class' => 'btn btn-primary' ] )
			,
			
			'template' => '{update}{clone}{delete}',
			'buttons'  => [
				
				'update' => function( $url, $Model ) use ( $editAction ) {
					
					return $editAction( $url, $Model, 'update', 'pencil' );
					
				},
				
				'clone' => function( $url, $Model ) use ( $editAction ) {
					
					return $editAction( $url, $Model, 'clone', 'duplicate' );
					
				},
				
				/*
				'delete' => function( $url, $Model ) {
					return Html::a( '<span class="glyphicon glyphicon-trash"></span>', $url, [
						'title'       => Yii::t( 'app', 'Delete' ),
						'data-method' => 'post',
					] );
				},
			
					*/
			],
			
			/*
			'urlCreator' => function( $action, $Model, $key, $index ) {
				
				$classname = strtolower( ( new\ReflectionObject( $Model ) )->getShortName() );
				
				return Url::to( "/$classname/{$Model->id}/$action" );
			}
			*/
		];
		
		return [
			'ModelSearch'         => $ModelSearch,
			'dataProvider'        => $dataProvider,
			'nestedAttributes'    => $nestedAttributes,
			'columns'             => &$columns,
		];
		
	}
	
}