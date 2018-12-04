<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 15.04.2018
 * Time: 13:28
 */

namespace yozh\crud\traits;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yozh\base\components\validators\Validator;
use yozh\base\interfaces\models\ActiveRecordInterface;
use yozh\form\interfaces\DefaultFiltersInterface;

trait ModelSearchTrait
{
	use \yozh\form\traits\ModelSearchTrait;
	
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
			
			if( Yii::$app->request->isNested ){
				$dataProvider->query->where('1=0');
			}
			
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