<?php

namespace yozh\crud;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
	
	public function bootstrap( $app )
	{
		
		$moduleId = ( ( new \ReflectionObject( $this ) )->getNamespaceName() . '\Module' )::MODULE_ID;
		
		$app->getUrlManager()->addRules( [
			$moduleId => $moduleId . '/default/index',
		], false )
		;
		
		$app->setModule( $moduleId, 'yozh\\' . $moduleId . '\Module' );
		
	}
	
}