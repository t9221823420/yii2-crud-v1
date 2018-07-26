<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 22.06.2018
 * Time: 20:33
 */

namespace yozh\crud\traits\actions;

use Yii;
use yii\data\ActiveDataProvider;

trait CloneActionTrait
{
	
	public function process()
	{
		
		return [
		];
	}
	
	
	public function run( $id )
	{
		return $this->render( $this->id, $this->process( $id ) );
	}
}