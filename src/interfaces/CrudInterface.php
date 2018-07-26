<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 24.05.2018
 * Time: 13:51
 */

namespace yozh\crud\interfaces;

interface CrudInterface
{
	/**
	 * @return BaseModel::class
	 */
	public static function defaultModelClass();
	
	//public Fstatic function defaultModelSearchClass();
	
}