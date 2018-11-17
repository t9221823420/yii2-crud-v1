<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 22.09.2018
 * Time: 10:37
 */

namespace yozh\crud\widgets;

use Yii;
use yii\bootstrap\Html;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yozh\base\components\helpers\ArrayHelper;
use yozh\base\components\helpers\Inflector;
use yozh\widget\widgets\BaseWidget as Widget;

class NestedModel extends Widget
{
	const PARAM_NESTED = '_nested';
	
	/**
	 * @var ActiveRecord $model for server ation.
	 */
	public $model;
	
	/**
	 * @var mixed url for server ation.
	 */
	public $url = 'index';
	
	/**
	 * @var array $params for server ation.
	 */
	public $params = [];
	
	/**
	 * @var string the tag to use to render the button
	 */
	public $tagName = 'div';
	
	/**
	 * @var string the tag to use to render the button
	 */
	public $bodyContent;
	
	
	/**
	 * Renders the widget.
	 */
	public function run()
	{
		$options = $this->options;
		
		$Model = $this->model;
		
		Html::addCssClass( $options, [ 'yozh-widget-nested-models' ] );
		
		$title = Yii::t( 'app', Inflector::pluralize( Inflector::camel2words( $Model->formName() ) ) );
		$id    = Inflector::camel2id( $Model->formName() );
		
		$this->params = ArrayHelper::merge( [ $Model->formName() => $Model->getAttributes() ], $this->params );
		
		if( !is_array( $this->url ) ) {
			if( $url = parse_url( $this->url ) ) {
				
				$this->url = $url['path'];
				parse_str( html_entity_decode( $url['query'] ?? '' ), $params );
				$this->params = $params + (array)$this->params;
				
			}
			else {
				throw new \yii\base\InvalidParamException( "Can not parse $url." );
			}
			
		}
		else if( is_string() ) {
			throw new \yii\base\InvalidParamException( "\$url have to be an array or a string." );
		}
		
		$url = Url::to( [ $this->url ] + [ NestedModel::PARAM_NESTED => true ] + $this->params );
		
		$script = "$( function () { $( '#nested-{$id}' ).load( '{$url}' ); });";
		
		$View = Yii::$app->controller->view;
		
		$View->registerJs( $script, $View::POS_END );
		
		\yozh\widget\AssetBundle::register( $View );
		
		return implode( "\n", [
			Html::beginTag( $this->tagName, $options ),
			$this->bodyContent ?? $this->_renderBody( [
				'id'    => $id,
				'title' => $title,
			] ),
			Html::endTag( $this->tagName ),
		] );
		
	}
	
	protected function _renderBody( $params )
	{
		extract( $params );
		
		$loading = Yii::t( 'app', 'Loading' );
		
		$output = <<< HTML
		
        <h3>{$title}</h3>

        <div id="nested-{$id}" class="">{$loading}
            <div class="yozh-spinner"></div>
        </div>

HTML;
		
		return $output;
	}
	
}