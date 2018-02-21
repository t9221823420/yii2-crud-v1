<?php

use yii\db\Migration;

/**
 * Handles the creation of table `table`.
 */
class m180219_103041_create_table_table extends Migration
{
	protected static $_table = 'table';
	
	protected static $_references = [
		/*
		[
			'refTable'  => 'tree',
			'refColumn' => 'id',
			'column'    => 'tree_id',
		],
		*/
	];
	
	public function safeUp()
	{
		$table = static::$_table;
		
		$this->createTable( $table, [
			'id'      => $this->primaryKey(),
		] );
		
		$refTable = $refColumn = $column = null;
		
		foreach( self::$_references as $ref ) {
			
			extract( $ref );
			
			$this->createIndex(
				"idx-$table-$column",
				$table,
				$column
			);
			
			$this->addForeignKey(
				"fk-$table-$column",
				$table,
				$column,
				$refTable,
				$refColumn,
				'CASCADE'
			);
		}
		
	}
	
	public function safeDown()
	{
		$table = static::$_table;
		
		$column = null;
		
		foreach( self::$_references as $ref ) {
			
			extract( $ref );
			
			$this->dropForeignKey(
				"fk-$table-$column",
				$table
			);
			
			$this->dropIndex(
				"idx-$table-$column",
				$table
			);
			
		}
		
		$this->dropTable( $table );
	}
	
}
