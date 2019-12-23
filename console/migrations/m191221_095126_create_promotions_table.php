<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%promotions}}`.
 */
class m191221_095126_create_promotions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%promotions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'text' => $this->text()->comment("Текст"),
            'price' => $this->float()->comment("Сумма"),
            'days' => $this->integer()->comment("Количество дней"),
            'premium' => $this->boolean()->comment("Премиум"),
            'top' => $this->boolean()->comment("Топ"),
            'discount' => $this->integer()->comment("Скидка %"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%promotions}}');
    }
}
