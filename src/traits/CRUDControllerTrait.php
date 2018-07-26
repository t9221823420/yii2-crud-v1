<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 11.01.2018
 * Time: 12:04
 */

namespace yozh\crud\traits;

use Yii;
use yozh\base\interfaces\models\ActiveRecordSearchInterface;
use yozh\base\actions\CreateAction;
use yozh\base\actions\DeleteAction;
use yozh\base\actions\EditAction;
use yozh\base\actions\IndexAction;
use yozh\base\actions\UpdateAction;
use yozh\base\actions\ViewAction;
use yozh\base\actions\UpdateAttributeAction;

trait CRUDControllerTrait
{
	
	public function actions()
	{
		return [
			
			'index' => [
				'class' => IndexAction::class,
			],
			
			'view' => [
				'class' => ViewAction::class,
			],
			
			'edit' => [
				'class' => EditAction::class,
			],
			
			'create' => [
				'class' => CreateAction::class,
			],
			
			'update' => [
				'class' => UpdateAction::class,
			],
			
			'delete' => [
				'class' => DeleteAction::class,
			],
			
			'update-attribute' => [
				'class' => UpdateAttributeAction::class,
			],
			
		];
	}
	
	public static function defaultSearchModelClass()
	{
		$defaultModelClass = static::defaultModelClass();
		
		if( class_exists( $defaultModelClass . 'Search' )
			&& ( new \ReflectionClass( $defaultModelClass . 'Search' ) )->implementsInterface( ActiveRecordSearchInterface::class )
		) {
			return $defaultModelClass . 'Search';
		}
		
	}
	
	public static function renderSelectItems( $items )
	{
		$output = '<option>' . Yii::t( 'app', 'Select' ) . '</option>';
		
		foreach( $items as $optionValue => $optionLabel ) {
			$output .= "<option value=\"$optionValue\">$optionLabel</option>";
		}
		
		return $output;
		
	}
	
}