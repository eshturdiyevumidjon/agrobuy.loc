<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%price_list}}`.
 */
class m191221_095922_create_price_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%price_list}}', [
            'id' => $this->primaryKey(),
            'price' => $this->float()->comment("Сумма"),
            'number' => $this->integer()->comment("Порядковый номер"),
        ]);

        $this->insert('{{%price_list}}',array(
            'price' => 1000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 2000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 5000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 10000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 15000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 20000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 25000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 30000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 35000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 40000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 50000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 60000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 70000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 80000,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 100000,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%price_list}}');
    }
}
