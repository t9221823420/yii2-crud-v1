<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 22.06.2018
 * Time: 20:33
 */

namespace yozh\crud\traits\actions;

trait ViewActionTrait
{
	
	public function process( $id )
	{
		return [
			'model' => $this->_findModel( $id ),
		];
	}
	
	
	public function run( $id )
	{
		return $this->_render( 'view', $this->process( $id ) );
	}
}