<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency}}`.
 */
class m200202_090403_create_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currency}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment('Наименование'),
        ]);

        $this->insert('currency',array(
            'name' => 'Сўм',
        ));

        $this->insert('currency',array(
            'name' => 'Рубль',
        ));

        $this->insert('currency',array(
            'name' => 'Доллар',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currency}}');
    }
}
