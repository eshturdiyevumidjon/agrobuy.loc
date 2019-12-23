<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m191220_204735_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' =>$this->primaryKey(),
            'user_id' =>$this->integer()->comment("Пользователь"),
            'created_date'=>$this->datetime()->comment("Дата создание"),
            'amount'=>$this->float()->comment("Сумма"),
            'state'=>$this->integer()->comment("Статус заказа"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
