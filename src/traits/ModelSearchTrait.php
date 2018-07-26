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
use yozh\form\interfaces\AttributesFilterInterface;

trait ModelSearchTrait
{
	public function rules()
	{
		$rules = [];
		
		if( $this instanceof AttributesFilterInterface ) {
			$rules = array_merge( $rules, parent::rules() );
		}
		
		return $rules;
	}
	
	public function scenarios()
	{
		$scenarios = Model::scenarios();
		
		if( $this instanceof AttributesFilterInterface ) {
			
			$scenarios[ static::SCENARIO_FILTER ] = $this->attributesFilter();
			
			$this->scenario = static::SCENARIO_FILTER;
		}
		
		// bypass scenarios() implementation in the parent class
		return $scenarios;
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
		
		if( $this instanceof AttributesFilterInterface ) {
			$this->_addDefaultFilters( $query );
		}
		
		return $dataProvider;
	}
	
	public function attributesFilter( ?array $only = null, ?array $except = null, ?bool $schemaOnly = false )
	{
		return parent::attributesDefaultList(
			$this->attributesIndexList()
			, $except
			, $schemaOnly
		);
	}
}