<?php

use yii\db\Migration;

/**
 * Class m200526_182535_create_table_log
 */
class m200526_182535_create_table_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('log', [
            'id' => $this->primaryKey(),
            'updated_at' => $this->dateTime(),
            'updated_by' => $this->integer(),
            'page_id' => $this->integer(),
            'update_description' => $this->text(),
            'status' => $this->tinyInteger()
        ]);

        $this->addForeignKey(
            'fk-log-page_id',
            'log',
            'page_id',
            'page',
            'id',
            'CASCADE'
        );
    }



    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200526_182535_create_table_log cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200526_182535_create_table_log cannot be reverted.\n";

        return false;
    }
    */
}
