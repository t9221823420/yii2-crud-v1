<?php

namespace yozh\crud\models;

use yozh\form\models\BaseModel as ActiveRecord;

abstract class BaseModel extends ActiveRecord
{
	
	public static function getList( $condition = [] )
	{
		
		$attributes = static::getTableSchema()->columns;
		
		if( !$value && isset( $attributes['name'] ) ) {
			$value = 'name';
		}
		if( !$value && isset( $attributes['title'] ) ) {
			$value = 'title';
		}
		else {
			$value = null;
		}
		
		
		return static::getListQuery( $condition, null, $value )->column();
	}

}
