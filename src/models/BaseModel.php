<?php

namespace yozh\crud\models;

use yozh\form\models\BaseModel as ActiveRecord;

abstract class BaseModel extends ActiveRecord
{
	/*
	public function attributesDefaultList( ?array $only = null, ?array $except = null, ?bool $schemaOnly = false )
	{
		if( !(is_array( $except ) && count( $except ) === 0) ) {
			$except = array_merge( $this->primaryKey( true ), $except ?? [] );
		}
		
		return parent::attributesDefaultList( $only, $except, $schemaOnly );
		
	}
	*/
}
