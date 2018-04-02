<?php

namespace yozh\crud\controllers;

use yozh\crud\traits\CRUDTrait;
use yozh\crud\models\BaseModel;
use yozh\crud\AssetBundle;

use yozh\base\controllers\DefaultController as Controller;

class DefaultController extends Controller
{
	use CRUDTrait {
		actionIndex as protected traitActionIndex;
	}
	
	protected static function defaultModel()
	{
		return BaseModel::className();
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
