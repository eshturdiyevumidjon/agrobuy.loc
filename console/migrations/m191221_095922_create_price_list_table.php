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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%price_list}}');
    }
}
