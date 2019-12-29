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
            'number' => 1,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 2000,
            'number' => 2,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 5000,
            'number' => 3,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 10000,
            'number' => 4,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 15000,
            'number' => 5,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 20000,
            'number' => 6,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 25000,
            'number' => 7,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 30000,
            'number' => 8,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 35000,
            'number' => 9,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 40000,
            'number' => 10,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 50000,
            'number' => 11,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 60000,
            'number' => 12,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 70000,
            'number' => 13,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 80000,
            'number' => 14,
        ));
        $this->insert('{{%price_list}}',array(
            'price' => 100000,
            'number' => 15,
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
