<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 22.11.2018
 * Time: 15:09
 */

namespace yozh\crud\widgets;

use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\Url;
use yozh\form\ActiveField;
use yozh\base\components\helpers\ArrayHelper;

class ActiveForm extends \yozh\form\ActiveForm
{
	public function fields( Model $Model, $attributes = null, $params = [] )
	{
		static::$defaultFieldParams['nestedAttributes'] = [];
		static::$defaultFieldParams['fields'] = [];
		static::$defaultFieldParams['print'] = false;
		
		/**
		 * @var Array|Closure  $fields
		 */
		extract( ArrayHelper::setDefaults( $params, static::$defaultFieldParams, ArrayHelper::DEFAULTS_MODE_FILTER ) );
		
		if( isset( $fields ) && $fields instanceof \Closure ) {
			$fields = $fields( $this, $Model, $attributes, $params );
		}
		
		// convert $nestedAttributes to hidden if set
		if( $nestedAttributes ?? false ) {
			
			$_except = array_unique( array_merge( array_keys( $nestedAttributes ), $Model->primaryKey() ));
			
			foreach( ( $nestedAttributes ?? [] ) as $_name => $_value ) {
				if( isset( $fields[ $_name ] ) ) {
					$fields[ $_name ] = $this->field( $Model, $_name, [ 'template' => '{input}', 'options' => [ 'tag' => null ] ] )->hiddenInput();
				}
			}
		}
		
		// remove attributes wich set to false
		foreach( $fields as $_fieldName => $_fieldValue ) {
			if( $_fieldValue === false ){
				$_except[] = $_fieldName;
				unset($fields[$_fieldName]);
			}
		}
		
		$fields = ArrayHelper::merge( parent::fields( $Model
			, $Model->attributesEditList( null, $_except ?? null)
			, [
				'print' => $print ?? false,
			]
		), $fields );
		
		return $fields; // TODO: Change the autogenerated stub
	}
	
	
}