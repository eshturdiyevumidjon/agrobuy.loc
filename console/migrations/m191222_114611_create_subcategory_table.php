<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subcategory}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%category}}`
 */
class m191222_114611_create_subcategory_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subcategory}}', [
            'id' => $this->primaryKey(),
            'name' =>$this->string(255)->comment("Наименование"),
            'category_id' => $this->integer()->comment("Категогия"),

        ]);

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-subcategory-category_id}}',
            '{{%subcategory}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-subcategory-category_id}}',
            '{{%subcategory}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );

        $this->insert('subcategory',array(
            'id' => 1,
            'category_id' => 1,
            'name' => 'Яблоко',
        ));

        $this->insert('subcategory',array(
            'id' => 2,
            'category_id' => 1,
            'name' => 'Груши',
        ));

        $this->insert('subcategory',array(
            'id' => 3,
            'category_id' => 2,
            'name' => 'Лук',
        ));

        $this->insert('subcategory',array(
            'id' => 4,
            'category_id' => 2,
            'name' => 'Картошка',
        ));

        $this->insert('subcategory',array(
            'id' => 5,
            'category_id' => 3,
            'name' => 'Деревья',
        ));

        $this->insert('subcategory',array(
            'id' => 6,
            'category_id' => 3,
            'name' => 'Газоны',
        ));

        $this->insert('subcategory',array(
            'id' => 7,
            'category_id' => 4,
            'name' => 'Арахис',
        ));

        $this->insert('subcategory',array(
            'id' => 8,
            'category_id' => 4,
            'name' => 'Фундук',
        ));

        $this->insert('subcategory',array(
            'id' => 9,
            'category_id' => 5,
            'name' => 'Маш',
        ));

        $this->insert('subcategory',array(
            'id' => 10,
            'category_id' => 5,
            'name' => 'Нут',
        ));

        $this->insert('subcategory',array(
            'id' => 11,
            'category_id' => 6,
            'name' => 'Изюм',
        ));

        $this->insert('subcategory',array(
            'id' => 12,
            'category_id' => 6,
            'name' => 'Курага',
        ));

        $this->insert('subcategory',array(
            'id' => 13,
            'category_id' => 7,
            'name' => 'Вариант 1',
        ));

        $this->insert('subcategory',array(
            'id' => 14,
            'category_id' => 7,
            'name' => 'Вариант 2',
        ));

        $this->insert('subcategory',array(
            'id' => 15,
            'category_id' => 8,
            'name' => 'Пшеница',
        ));

        $this->insert('subcategory',array(
            'id' => 16,
            'category_id' => 8,
            'name' => 'Кукуруза',
        ));

        $this->insert('subcategory',array(
            'id' => 17,
            'category_id' => 9,
            'name' => 'Вариант 3',
        ));

        $this->insert('subcategory',array(
            'id' => 18,
            'category_id' => 9,
            'name' => 'Вариант 4',
        ));

        $this->insert('subcategory',array(
            'id' => 19,
            'category_id' => 10,
            'name' => 'Баранина',
        ));

        $this->insert('subcategory',array(
            'id' => 20,
            'category_id' => 10,
            'name' => 'Говядина',
        ));

        $this->insert('subcategory',array(
            'id' => 21,
            'category_id' => 11,
            'name' => 'Молоко',
        ));

        $this->insert('subcategory',array(
            'id' => 22,
            'category_id' => 11,
            'name' => 'Сыр',
        ));

        $this->insert('subcategory',array(
            'id' => 23,
            'category_id' => 12,
            'name' => 'Корова',
        ));

        $this->insert('subcategory',array(
            'id' => 24,
            'category_id' => 12,
            'name' => 'Курица',
        ));

        $this->insert('subcategory',array(
            'id' => 25,
            'category_id' => 13,
            'name' => 'Семена 1',
        ));

        $this->insert('subcategory',array(
            'id' => 26,
            'category_id' => 13,
            'name' => 'Семена 2',
        ));

        $this->insert('subcategory',array(
            'id' => 27,
            'category_id' => 14,
            'name' => 'Средства защиты растений',
        ));

        $this->insert('subcategory',array(
            'id' => 28,
            'category_id' => 14,
            'name' => 'Минеральные удобрения',
        ));

        $this->insert('subcategory',array(
            'id' => 29,
            'category_id' => 15,
            'name' => 'Древесина1',
        ));

        $this->insert('subcategory',array(
            'id' => 30,
            'category_id' => 15,
            'name' => 'Древесина2',
        ));

        $this->insert('subcategory',array(
            'id' => 31,
            'category_id' => 16,
            'name' => 'Трактор1',
        ));

        $this->insert('subcategory',array(
            'id' => 32,
            'category_id' => 16,
            'name' => 'Трактор2',
        ));

        $this->insert('subcategory',array(
            'id' => 33,
            'category_id' => 17,
            'name' => 'Оборудование 1',
        ));

        $this->insert('subcategory',array(
            'id' => 34,
            'category_id' => 17,
            'name' => 'Оборудование 2',
        ));

        $this->insert('subcategory',array(
            'id' => 35,
            'category_id' => 18,
            'name' => 'Холодильник1',
        ));

        $this->insert('subcategory',array(
            'id' => 36,
            'category_id' => 18,
            'name' => 'Холодильник2',
        ));

        $this->insert('subcategory',array(
            'id' => 37,
            'category_id' => 19,
            'name' => 'Капельные1',
        ));

        $this->insert('subcategory',array(
            'id' => 38,
            'category_id' => 19,
            'name' => 'Капельные2',
        ));

        $this->insert('subcategory',array(
            'id' => 39,
            'category_id' => 20,
            'name' => 'логистика',
        ));

        $this->insert('subcategory',array(
            'id' => 40,
            'category_id' => 20,
            'name' => 'Документация',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-subcategory-category_id}}',
            '{{%subcategory}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-subcategory-category_id}}',
            '{{%subcategory}}'
        );

        $this->dropTable('{{%subcategory}}');
    }
}
