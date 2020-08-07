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
            'image' => $this->string(255)->comment("Картинка"),
            'name' => $this->string(255)->comment("Наименование"),
            'text' => $this->text()->comment("Текст"),
            'price' => $this->float()->comment("Сумма"),
            'days' => $this->integer()->comment("Количество дней"),
            'premium' => $this->boolean()->comment("Премиум"),
            'top' => $this->boolean()->comment("Топ"),
            'discount' => $this->integer()->comment("Скидка %"),
        ]);

        $this->insert('{{%promotions}}',array(
            'name' => 'Поднять в топ',
            'text' => 'Данная платная услуга, выделяет ваше объявление и поднимает его в топ в своей категории сроком на 7 дней',
            'price' => 0,
            'image' => 'premium.png',
            'days' => 7,
            'premium' => false,
            'top' => true,
            'discount' => 0,
        ));

        $this->insert('{{%promotions}}',array(
            'name' => 'VIP на неделю',
            'text' => 'Данная услуга выводит Ваше объявление на главную страницу в раздел "ПРЕМИУМ" сроком на 7 дней',
            'price' => 0,
            'days' => 7,
            'image' => 'vip.png',
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
