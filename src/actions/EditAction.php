<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 22.06.2018
 * Time: 20:41
 */

namespace yozh\crud\actions;

use Yii;
use yozh\crud\widgets\NestedModel;
use yozh\base\models\BaseActiveRecord as ActiveRecord;

class EditAction extends \yozh\base\actions\EditAction
{
	public function process( ActiveRecord $Model = null, bool $clone = false )
	{
		$result = parent::process( $Model, $clone );
		
		if( is_array( $result ) ) {
			
			$result['nestedAttributes'] = ( Yii::$app->request->queryParams ) ?? [];
			
			return $result;
			
		}
		else if( $result ) {
			return $result;
		}
		
	}
	
}