<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 11.01.2018
 * Time: 12:04
 */

namespace yozh\crud\traits;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

trait CRUDTrait
{
	
	
	public function actionEdit()
	{
		$result = $this->_action();
		
		if( $result instanceof Response ) { //
			return $result;
		}
		else if( $result instanceof ActiveRecord ) { //
			
			return $this->render( 'edit', [
				'model' => $result,
			] );
			
		}
		
		return;
	}
	
	protected function _action()
	{
		
		/**
		 * @var ActiveRecord $defaultModel
		 * @var array $primaryKey
		 */
		$defaultModel = static::defaultModel(); // like app\models\Model
		$primaryKey   = array_intersect_key( $_GET, array_flip( $defaultModel::primaryKey() ) ); // because of composite key
		
		// Event AFTER_LOAD_PRIMARY_KEY
		
		if( empty( $primaryKey ) ) { // create
			$model = new $defaultModel();
			// Event AFTER_NEW_MODEL
		}
		else if( ( $model = $defaultModel::findOne( $primaryKey ) ) !== null ) { // update
			// Event AFTER_FIND_MODEL
		}
		else {
			throw new NotFoundHttpException( Yii::t( 'app', 'The requested page does not exist.' ) );
		}
		
		// Event BEFORE_PRELOAD_MODEL
		
		/**
		 * Leave it here because we may have to load some initial data to new model (for example parent_id)
		 * and if there is not POST data the model would not be saved
		 */
		$model->load( Yii::$app->request->get(), '' );
		
		// Event AFTER_PRELOAD_MODEL
		
		// Event BEFORE_LOAD_MODEL
		
		/**
		 * for Load only POST data
		 */
		if( $model->load( Yii::$app->request->post() ) ) {
			
			// Event AFTER_LOAD_MODEL
			
			// @todo к load прикрутить конвертер типов на основании rules
			//$model->entity_id = (int)$model->entity_id;
			
			if( $model->validate() ) {
				
				// Event AFTER_VALIDATE_MODEL
				
				if( $model->save( false ) ) {
					
					Yii::$app->session->setFlash( 'kv-detail-success', Yii::t( 'app', 'Record saved successfully' ) );
					
					// Event AFTER_SAVE_RECORD
					
					return $this->redirect( [ 'index' ] + $model->getPrimaryKey( true ) );
				}
				
			}
		}
		
		// Event BEFORE_RENDER
		
		return $model;
		
	}
	
	public function actionCreate()
	{
		
		$result = $this->_action();
		
		if( $result instanceof Response ) { //
			return $result;
		}
		else if( $result instanceof ActiveRecord ) { //
			
			return $this->render( 'create', [
				'model' => $result,
			] );
			
		}
		
		return;
		
	}
	
	public function actionUpdate()
	{
		$result = $this->_action();
		
		if( $result instanceof Response ) { //
			return $result;
		}
		else if( $result instanceof ActiveRecord ) { //
			
			return $this->render( 'update', [
				'model' => $result,
			] );
			
		}
	}
	
	public function actionView( $id )
	{
		return $this->render( 'view', [
			'model' => $this->_findModel( $id ),
		] );
	}
	
	public function actionIndex()
	{
		
		$defaultModel = static::defaultModel();
		$searchModel  = new $defaultModel();
		
		/** @var ActiveRecord $searchModel */
		$dataProvider = new ActiveDataProvider( [
			'query' => $searchModel::find(),
		] );
		
		return $this->render( 'index', [
			'model'        => $searchModel,
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		] );
	}
	
	public function actionDelete( $id )
	{
		$this->_findModel( $id )->delete();
		
		return $this->redirect( [ 'index' ] );
	}
	
	public function actionCopy( $id )
	{
		$original = $this->_findModel( $id );
		
		$className = $original::className();
		
		$copy = new $className( array_diff_assoc( $original->attributes, $original->getPrimaryKey( true ) ) );
		$copy->save();
		
		return $this->redirect( Url::to( array_merge_recursive( [ 'update' ], $copy->getPrimaryKey( true ) ) ) );
		
	}
	
	public function actionSwitch( $id, $attribute, $value )
	{
		$model = $this->findModel( (int)$id );
		
		if( isset( $model->$attribute ) ) {
			
			$model->setAttribute( $attribute, (int)$value ? false : true );
			
			if( $model->save() ) {
				return $value;
			}
		}
		
		throw new \yii\web\NotFoundHttpException();
		
	}
	
}