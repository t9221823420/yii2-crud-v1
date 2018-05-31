<?php
/**
 * Created by PhpStorm.
 * User: bw_dev
 * Date: 24.05.2018
 * Time: 13:51
 */

namespace yozh\crud\interfaces;

use yii\db\ActiveRecordInterface;

interface ActiveRecordSearchInterface extends ActiveRecordInterface
{
	public function search( $params );
}