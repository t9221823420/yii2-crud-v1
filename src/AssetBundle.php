<?php

namespace yozh\crud;

class AssetBundle extends \yii\web\AssetBundle
{

    public $sourcePath = __DIR__ .'/../assets/';
	
	public $css = [
		'css/yozh-crud.css',
		//['css/yozh-settings.print.css', 'media' => 'print'],
	];
	
	public $js = [
		'js/yozh-crud.js',
	];
	
	public $depends = [
		\yozh\base\AssetBundle::class,
	];
	
	public $publishOptions = [
		'forceCopy'       => true,
	];
	
}