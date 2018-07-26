<?php

namespace yozh\crud\controllers;

use yozh\crud\actions\CreateAction;
use yozh\crud\actions\EditAction;
use yozh\crud\actions\IndexAction;
use yozh\crud\actions\NestedIndexAction;
use yozh\crud\actions\UpdateAction;
use yozh\crud\interfaces\ActiveRecordInterface;
use yozh\crud\interfaces\CrudInterface;
use yozh\crud\traits\CRUDControllerTrait;
use yozh\crud\models\BaseModel;
use yozh\crud\AssetBundle;

use yozh\base\controllers\DefaultController as Controller;

abstract class DefaultController extends Controller implements CrudInterface
{
	
	const PARAM_NESTED = '_nested';
	
	use CRUDControllerTrait {
		CRUDControllerTrait::actions as private _actions;
	}
	
	public function actions()
	{
		return array_merge( $this->_actions(), [
			
			'index' => [
				'class' => IndexAction::class,
			],
		
			'edit' => [
				'class' => EditAction::class,
			],
		
			'update' => [
				'class' => UpdateAction::class,
			],
		
			'create' => [
				'class' => CreateAction::class,
			],
		
		] );
	}
	
	/**
	 * @return BaseModel::class
	 */
	abstract public static function defaultModelClass();
	
	public function beforeAction( $action )
	{
		AssetBundle::register( $this->view );
		
		return parent::beforeAction( $action );
	}
	
}
