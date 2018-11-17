<?php

namespace yozh\crud\controllers;

use yozh\base\actions\CloneAction;
use yozh\crud\actions\CreateAction;
use yozh\crud\actions\EditAction;
use yozh\crud\actions\IndexAction;
use yozh\crud\actions\NestedIndexAction;
use yozh\crud\actions\UpdateAction;
use yozh\crud\interfaces\ActiveRecordInterface;
use yozh\crud\interfaces\CrudInterface;
use yozh\crud\traits\CRUDControllerTrait;
use yozh\crud\models\BaseActiveRecord;
use yozh\crud\AssetBundle;

use yozh\base\controllers\DefaultController as Controller;

abstract class DefaultController extends Controller implements CrudInterface
{
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
		
			'clone' => [
				'class' => CloneAction::class,
			],
		
		] );
	}
	
	/**
	 * @return BaseActiveRecord::class
	 */
	abstract public static function defaultModelClass();
	
	public function beforeAction( $action )
	{
		AssetBundle::register( $this->view );
		
		return parent::beforeAction( $action );
	}
	
}
