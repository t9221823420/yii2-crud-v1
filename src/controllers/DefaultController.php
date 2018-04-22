<?php

namespace yozh\crud\controllers;

use yozh\crud\traits\CRUDTrait;
use yozh\crud\models\BaseModel;
use yozh\crud\AssetBundle;

use yozh\base\controllers\DefaultController as Controller;

abstract class DefaultController extends Controller
{
	use CRUDTrait {
		actionIndex as protected traitActionIndex;
	}
	
	/**
	 * @return BaseModel::class
	 */
	abstract protected static function defaultModel();
	
	protected static function defaultSearchModel()
	{
		return static::defaultModel() . 'Search';
	}
	
	public function actionIndex()
	{
		return $this->traitActionIndex();
	}
	
	public function beforeAction( $action )
	{
		AssetBundle::register( $this->view );
		return parent::beforeAction( $action );
	}
	
}
