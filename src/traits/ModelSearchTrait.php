<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 15.04.2018
 * Time: 13:28
 */

namespace yozh\crud\traits;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yozh\form\interfaces\DefaultFiltersInterface;

trait ModelSearchTrait
{
	use \yozh\form\traits\ModelSearchTrait;
	
	public $filter_search;
	
	public function rules()
	{
		$rules = [
			'filter_search' => [ [ 'filter_search', ], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process' ],
		];
		
		if( $this instanceof DefaultFiltersInterface ) {
			$rules = array_merge( $rules, parent::rules() );
		}
		
		return $rules;
	}
	
	/**
	 * @param array $params
	 * @return ActiveDataProvider
	 */
	public function search( $params )
	{
		/**
		 * @var $query ActiveQuery
		 */
		$query = parent::find();
		
		$dataProvider = new ActiveDataProvider( [
			'query' => $query,
			//'sort'  => [ 'defaultOrder' => [ 'id' => SORT_DESC ] ],
		] );
		
		if( !( $this->load( $params ) && $this->validate() ) ) {
			return $dataProvider;
		}
		
		if( $this instanceof DefaultFiltersInterface ) {
			$this->_addDefaultFiltersConditions( $query );
		}
		
			$query->andFilterWhere( [ 'or',
				$this->attributes( [ 'title' ] ) ? [ 'like', 'title', $this->filter_search ] : null,
				$this->attributes( [ 'name' ] ) ? [ 'like', 'name', $this->filter_search ] : null,
			] );
		
		return $dataProvider;
	}
	
}