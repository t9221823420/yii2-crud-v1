<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 22.06.2018
 * Time: 20:41
 */

namespace yozh\crud\actions;

use Yii;
use yozh\crud\controllers\DefaultController as CRUDController;
use yozh\base\models\BaseModel as ActiveRecord;

class EditAction extends \yozh\base\actions\EditAction
{
	public function process( ActiveRecord $Model = null )
	{
		$result = parent::process( $Model );
		
		if( is_array( $result ) ) {
			
			$result['nestedAttributes'] = ( Yii::$app->request->queryParams ) ?? [];
			
			return $result;
			
		}
		else if( $result ) {
			return $result;
		}
		
	}
	
}