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


        $this->insert('{{%promotions}}',array(
            'name' => 'Поднять на первое место',
            'text' => 'Приобрестите сейчас Поднять на первое место пакет и получите скидку в 30% с 
            возможностью оставлять неограниченное количество объявлений в течении 7 дней',
            'price' => 5000,
            'days' => 7,
            'premium' => false,
            'top' => true,
            'discount' => 30,
        ));

        $this->insert('{{%promotions}}',array(
            'name' => 'VIP на неделю',
            'text' => 'Приобрестите сейчас VIP на неделю пакет и получите с возможностью
            оставлять неограниченное количество объявлений в течении 10 дней',
            'price' => 10000,
            'days' => 10,
            'premium' => true,
            'top' => false,
            'discount' => 0,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%promotions}}');
    }
}
