<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m191221_103028_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->comment("Наименование"),
            'image' => $this->string(255)->comment("Фотография"),
        ]);

        $this->insert('category',array(
            'id' => 1,
            'title' => 'Фрукты',
            'image' => 'fruit.png',
        ));

        $this->insert('category',array(
            'id' => 2,
            'title' => 'Овощи',
            'image' => 'vegetable.png',
        ));

        $this->insert('category',array(
            'id' => 3,
            'title' => 'Зелень',
            'image' => 'Greens.png',
        ));

        $this->insert('category',array(
            'id' => 4,
            'title' => 'Бахчевые и ягоды',
            'image' => 'Dried fruits.png',
        ));

        $this->insert('category',array(
            'id' => 5,
            'title' => 'Зерновые и Бобовые културы',
            'image' => 'Legumes of culture.png',
        ));

        $this->insert('category',array(
            'id' => 6,
            'title' => 'Орехи и сухофрукты',
            'image' => 'Nuts.png',
        ));

        $this->insert('category',array(
            'id' => 7,
            'title' => 'Замороженные и консервированные продукты',
            'image' => 'Canned foods.png',
        ));

        $this->insert('category',array(
            'id' => 8,
            'title' => 'Логистика',
            'image' => 'Corn.png',
        ));

        $this->insert('category',array(
            'id' => 9,
            'title' => 'Упаковка',
            'image' => 'Compound feed.png',
        ));

        $this->insert('category',array(
            'id' => 10,
            'title' => 'Мясо и рыба',
            'image' => 'Meat and fish.png',
        ));

        $this->insert('category',array(
            'id' => 11,
            'title' => 'Животные и птица',
            'image' => 'Animals and bird.png',
        ));

        $this->insert('category',array(
            'id' => 12,
            'title' => 'Семена и посадочный материал',
            'image' => 'Seeds and planting material (Ornamental crops).png',
        ));

        $this->insert('category',array(
            'id' => 13,
            'title' => 'Минеральное удобрения и агрохимия',
            'image' => 'Agrochemistry.png',
        ));

        $this->insert('category',array(
            'id' => 14,
            'title' => 'Хранения и холод',
            'image' => 'Refrigeration Greenhouse complexes.png',
        ));

        $this->insert('category',array(
            'id' => 15,
            'title' => 'Техническое сырье и корм',
            'image' => 'Technical raw materials.png',
        ));

        $this->insert('category',array(
            'id' => 16,
            'title' => 'Сельхозтехника и запчасти',
            'image' => 'Agricultural machinery and spare parts.png',
        ));

        $this->insert('category',array(
            'id' => 17,
            'title' => 'Агро оборудования',
            'image' => 'Equipment.png',
        ));

        $this->insert('category',array(
            'id' => 18,
            'title' => 'Сельхозяйственные земли и объекты',
            'image' => 'Dairy.png',
        ));

        $this->insert('category',array(
            'id' => 19,
            'title' => 'Агромагазин',
            'image' => 'Drip irrigation.png',
        ));

        $this->insert('category',array(
            'id' => 20,
            'title' => 'Услуги',
            'image' => 'Services.png',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
