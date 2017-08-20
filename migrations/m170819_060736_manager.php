<?php

use yii\db\Migration;
use yii\db\Schema;

class m170819_060736_manager extends Migration
{
    public function safeUp()
    {
		$this->createTable('manager', [
			'id' => Schema::TYPE_PK,
			'first_name' => Schema::TYPE_STRING,
			'second_name' => Schema::TYPE_STRING,
			'salary' => Schema::TYPE_INTEGER,
		]);
		$this->createTable('bonus', [
			'id' => Schema::TYPE_PK,
			'bonus_step' => Schema::TYPE_INTEGER,
			'category' => Schema::TYPE_STRING,
			'bonus_amount' => Schema::TYPE_STRING
		]);
		$this->createTable('statistic', [
			'id' => Schema::TYPE_PK,
			'date' => Schema::TYPE_DATE,
			'manager_id' => Schema::TYPE_INTEGER,
			'calls_count' => Schema::TYPE_INTEGER
		]);

		$this->addForeignKey(
			'fk-statistic-manager_id',
			'statistic',
			'manager_id',
			'manager',
			'id',
			'CASCADE'
		);
    }

    public function safeDown()
    {
		$this->dropForeignKey(
			'fk-statistic-manager_id',
			'statistic'
		);
		$this->dropTable('manager');
		$this->dropTable('bonus');
		$this->dropTable('statistic');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170819_060736_manager cannot be reverted.\n";

        return false;
    }
    */
}
