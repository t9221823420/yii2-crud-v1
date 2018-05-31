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
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yozh\crud\interfaces\ActiveRecordSearchInterface;
use yozh\crud\models\BaseModel as ActiveRecord;
use yozh\form\interfaces\AttributeActionListInterface;
use yozh\form\traits\ActiveBooleanColumnTrait;

trait CRUDTrait
{
	
	use ActiveBooleanColumnTrait;
	
	protected static function _defaultSearchModelClass()
	{
		$defaultModelClass = static::defaultModelClass();
		
		if( class_exists( $defaultModelClass . 'Search' )
			&& ( new \ReflectionClass( $defaultModelClass . 'Search' ) )->implementsInterface( ActiveRecordSearchInterface::class )
		) {
			return $defaultModelClass . 'Search';
		}
		
	}
	
	public function actionEdit()
	{
		$result = $this->_action();
		
		if( $result instanceof Response ) { //
			return $result;
		}
		else if( $result instanceof ActiveRecord ) { //
			
			return $this->_render( 'edit', [
				'model' => $result,
			] );
			
		}
		
	}
	
	public function actionCreate()
	{
		
		$result = $this->_action();
		
		if( $result instanceof Response ) { //
			return $result;
		}
		else if( $result ) { //
			
			if( $result instanceof \yii\db\ActiveRecord ) {
				
				return $this->_render( 'create', [
					'model' => $result,
				] );
				
			}
			
			throw new \yii\base\ErrorException( get_class( $result ) . " have to be extends \yii\db\ActiveRecord" );
			
		}
		else {
			throw new \yii\web\NotFoundHttpException();
		}
		
	}
	
	public function actionUpdate()
	{
		$result = $this->_action();
		
		if( $result instanceof Response ) { //
			return $result;
		}
		else if( $result ) { //
			
			if( $result instanceof \yii\db\ActiveRecord ) {
				
				return $this->_render( 'update', [
					'model' => $result,
				] );
				
			}
			
			throw new \yii\base\ErrorException( get_class( $result ) . " have to be extends \yii\db\ActiveRecord" );
			
		}
		else {
			throw new \yii\web\NotFoundHttpException();
		}
		
	}
	
	public function actionView( $id )
	{
		return $this->_render( 'view', [
			'model' => $this->_findModel( $id ),
		] );
	}
	
	public function actionIndex()
	{
		/** @var ActiveRecord $searchModel */
		
		$defaultModelClass = static::defaultModelClass();
		
		if( $searchModelClass = static::_defaultSearchModelClass() ) {
			$searchModel  = new $searchModelClass;
			$dataProvider = $searchModel->search( Yii::$app->request->queryParams );
		}
		else {
			
			$searchModel = new $defaultModelClass;
			
			$dataProvider = new ActiveDataProvider( [
				'query' => $searchModel::find(),
			] );
			
		}
		
		return $this->_render( 'index', [
			'searchModel'  => $searchModel,
			'dataProvider' => $dataProvider,
		] );
	}
	
	public function actionDelete( $id )
	{
		$this->_findModel( $id )->delete();
		
		return $this->redirect( [ 'index' ] );
	}
	
	public function actionCopy()
	{
		$result = $this->_action();
		
		if( $result instanceof Response ) { //
			return $result;
		}
		else if( $result instanceof ActiveRecord ) { //
			
			/**
			 * @var ActiveRecord $result
			 */
			$result->isNewRecord = true;
			
			foreach( $result->primaryKey() as $attribute ) {
				$result->$attribute = null;
			}
			
			return $this->_render( 'update', [
				'model' => $result,
			] );
			
		}
		else {
			throw new \yii\web\NotFoundHttpException();
		}
		
	}
	
	protected function _action( ActiveRecord $Model = null )
	{
		/**
		 * @var ActiveRecord $defaultModelClass
		 * @var array $primaryKey
		 */
		$defaultModelClass = static::defaultModelClass(); // like app\models\Model
		$primaryKey        = array_intersect_key( $_GET, array_flip( $defaultModelClass::primaryKey() ) ); // because of composite key
		
		// Event AFTER_LOAD_PRIMARY_KEY
		
		if( !$Model ) {
			
			if( empty( $primaryKey ) ) { // create
				$Model = new $defaultModelClass();
				// Event AFTER_NEW_MODEL
			}
			else if( ( $Model = $defaultModelClass::findOne( $primaryKey ) ) !== null ) { // update
				// Event AFTER_FIND_MODEL
			}
			else {
				throw new NotFoundHttpException( Yii::t( 'app', 'The requested page does not exist.' ) );
			}
			
		}
		
		// Event BEFORE_PRELOAD_MODEL
		
		/**
		 * Leave it here because we may have to load some initial data to new model (for example parent_id)
		 * and if there is not POST data the model would not be saved
		 */
		$Model->load( Yii::$app->request->get(), '' );
		
		// Event AFTER_PRELOAD_MODEL
		
		// Event BEFORE_LOAD_MODEL
		
		/**
		 * for Load only POST data
		 */
		if( $Model->load( Yii::$app->request->post() ) ) {
			
			// Event AFTER_LOAD_MODEL
			
			// @todo к load прикрутить конвертер типов на основании rules
			//$Model->entity_id = (int)$Model->entity_id;
			
			if( $Model->validate() ) {
				
				// Event AFTER_VALIDATE_MODEL
				
				if( $Model->save( false ) ) {
					
					Yii::$app->session->setFlash( 'kv-detail-success', Yii::t( 'app', 'Record saved successfully' ) );
					
					// Event AFTER_SAVE_RECORD
					
					//return $this->redirect( [ 'index' ] + $Model->getPrimaryKey( true ) );
					
					if( Yii::$app->request->isAjax ) {
						
						$Response = Yii::$app->getResponse();
						
						$Response->format = Response::FORMAT_JSON;
						$Response->data   = true;
						
						return $Response;
					}
					else {
						return $this->redirect( [ 'index' ] );
					}
					
				}
				
			}
		}
		
		// Event BEFORE_RENDER
		
		return $Model;
		
	}
	
	protected function _render( $view, $params = [] )
	{
		if( Yii::$app->request->isAjax ) {
			return $this->renderAjax( $view, $params );
		}
		else {
			return $this->render( $view, $params );
		}
	}
	
	protected function _renderSelectItems( $items )
	{
		$output = '<option>' . Yii::t( 'app', 'Select' ) . '</option>';
		
		foreach( $items as $optionValue => $optionLabel ) {
			$output .= "<option value=\"$optionValue\">$optionLabel</option>";
		}
		
		return $output;
		
	}
	
}