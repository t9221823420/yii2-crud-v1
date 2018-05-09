<?php

namespace yozh\crud\models;

use yozh\form\models\BaseModel as ActiveRecord;

abstract class BaseModel extends ActiveRecord
{

	/*
	protected static $_list;
	
	public static function getList()
	{
		if( !static::$_list ){
			static::$_list = static::getListQuery()
			                       ->enabledOnly()
			                       ->notDeleted()
			                       ->column()
			;
		}
		
		return static::$_list;
		
	}
	*/	
	
	/*
	public static function getList( $condition = [] )
	{
		
		$attributes = static::getTableSchema()->columns;
		
		$value = null;
		
		if( !$value && isset( $attributes['name'] ) ) {
			$value = 'name';
		}
		if( !$value && isset( $attributes['title'] ) ) {
			$value = 'title';
		}
		
		return static::getListQuery( $condition, null, $value )->column();
	}
	*/
	
}
