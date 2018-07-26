<?php

namespace yozh\crud;

use yozh\base\Module as BaseModule;

class Module extends BaseModule
{
	const MODULE_ID = 'crud';
	
	public $controllerNamespace = 'yozh\\' . self::MODULE_ID . '\controllers';

}
