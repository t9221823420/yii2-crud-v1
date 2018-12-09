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
		
		extract( parent::process() );
		
		$Model = $searchModel;
		
		$Shema = Yii::$app->db->getSchema();
		
		/*
		$tableName = $Shema->getRawTableName( $Model::tableName() );
		
		$tableSchema = $Shema->getTableSchema( $tableName );
		*/
		
		/**
		 * @var \yozh\crud\models\BaseActiveRecord $Model
		 */
		if( Yii::$app->request->isNested
			&& $nestedAttributes = ( Yii::$app->request->queryParams )[ $searchModel->formName() ] ?? []
		) {
			$columns = $Model->attributesIndexList( null, array_keys( $nestedAttributes ) );
		}
		else {
			$columns = $Model->attributesIndexList();
		}
		
		$attributeReferences = [];
		if( $Model instanceof ActiveRecordInterface ) {
			
			foreach( $Model->shemaReferences() as $refName => $reference ) {
				foreach( $reference as $fk => $pk ) {
					$attributeReferences[ $fk ][ $refName ] = $reference;
				}
			}
			
		}
		
		$shemaColumns = $Model->shemaColumns();
		
		foreach( $columns as $key => $attributeName ) {
			
			if( isset( $attributeReferences[ $attributeName ] ) ) {
				
				foreach( $attributeReferences[ $attributeName ] as $refName => $reference ) {
					
					$refAttributes = $Shema->getTableSchema( $reference[0] )->columns;
					
					if( isset( $refAttributes['name'] ) ) {
						$refLabel = 'name';
					}
					else if( isset( $refAttributes['title'] ) ) {
						$refLabel = 'title';
					}
					else {
						$refLabel = $reference[ $attributeName ];
					}
					
					$refQuery = ( new Query() )
						->select( [ $refLabel, $reference[ $attributeName ] ] )
						->from( $reference[0] )
						//->andFilterWhere( $refCondition )
					;
					
					$attributeReferences[ $attributeName ]['items'] = $refQuery->indexBy( $reference[ $attributeName ] )->column();
					
					$label = Yii::t( 'app', preg_replace( '/\sId$/', '', Html::encode( $Model->getAttributeLabel( $attributeName ) ) ) );
					
					$columns[ $key ] = [
						'attribute' => $attributeName,
						'label'     => $label,
						'filter'    => $attributeReferences[ $attributeName ]['items'],
						'value'     => function( $Model, $key, $index, $widget ) use ( $attributeReferences, $attributeName ) {
							return $attributeReferences[ $attributeName ]['items'][ $Model->$attributeName ] ?? null;
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
			'searchModel'         => $searchModel,
			'dataProvider'        => $dataProvider,
			'nestedAttributes'    => $nestedAttributes,
			'columns'             => &$columns,
			'attributeReferences' => $attributeReferences,
		];
		
	}
	
}