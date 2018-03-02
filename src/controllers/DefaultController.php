<?php

namespace yozh\crud\controllers;

use yozh\crud\traits\CRUDTrait;
use yozh\crud\models\CRUDModel;
use yozh\crud\AssetsBundle;

use yozh\base\controllers\DefaultController as Controller;

class DefaultController extends Controller
{
	use CRUDTrait {
		actionIndex as protected traitActionIndex;
	}
	
	
	protected static function primaryModel()
	{
		return CRUDModel::className();
	}
	
	public function actionIndex()
	{
		//AssetsBundle::register( $this->view );
		return $this->traitActionIndex();
	}
	
}
