<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 03.12.2018
 * Time: 20:00
 */

namespace yozh\crud\components;

use yozh\crud\widgets\NestedModel;

class Request extends \yozh\base\components\Request
{
	public function getIsNested(){
		return $this->get( NestedModel::PARAM_NESTED ) ? true : false;
	}
}