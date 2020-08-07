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
        
        $subcategories1 = [
            '1' =>   'Яблоко',    
            '2' =>   'Груши',   
            '3' =>   'Абрикос', 
            '4' =>   'Слива',   
            '5' =>   'Персик',  
            '6' =>   'Нектарин',    
            '7' =>   'Нектарин',    
            '8' =>   'Нектарин',    
            '9' =>   'Виноград',    
            '10' =>  'Хурма',   
            '11' =>  'Гранат',  
            '12' =>  'Грушы',   
            '13' =>  'Инжир',   
            '14' =>  'Айва',    
            '15' =>  'Вишня',   
            '16' =>  'Лимон',   
            '17' =>  'Мандарины',   
            '18' =>  'Манго',   
            '19' =>  'Лайм',    
            '20' =>  'Кокос',
            '21' =>  'Грейпфрут',   
            '22' =>  'Банан',   
            '23' =>  'Апельсин',    
            '24' =>  'Ананас',  
            '25' =>  'Киви',    
            '26' =>  'Авокадо',
        ];
        //category 1
        foreach ($subcategories1 as $key => $value) {
            $this->insert('subcategory',array(
                'category_id' => 1,
                'name' => $value,
            ));
        }

        //category 2
        $this->insert('subcategory',array(
            'category_id' => 2,
            'name' => 'Лук',
        ));

        $this->insert('subcategory',array(
            'category_id' => 2,
            'name' => 'Картошка',
        ));

        //catgeory 3
        $this->insert('subcategory',array(
            'category_id' => 3,
            'name' => 'Деревья',
        ));

        $this->insert('subcategory',array(
            'category_id' => 3,
            'name' => 'Газоны',
        ));

        //category 4
        $this->insert('subcategory',array(
            'category_id' => 4,
            'name' => 'Изюм',
        ));

        $this->insert('subcategory',array(
            'category_id' => 4,
            'name' => 'Курага',
        ));

        //category 5
        $this->insert('subcategory',array(
            'category_id' => 5,
            'name' => 'Маш',
        ));

        $this->insert('subcategory',array(
            'category_id' => 5,
            'name' => 'Нут',
        ));

        //catgeory 6
        $this->insert('subcategory',array(
            'category_id' => 6,
            'name' => 'Арахис',
        ));

        $this->insert('subcategory',array(
            'category_id' => 6,
            'name' => 'Фундук',
        ));

        //catgeory 6
        $this->insert('subcategory',array(
            'category_id' => 6,
            'name' => 'Вариант 1',
        ));

        $this->insert('subcategory',array(
            'category_id' => 6,
            'name' => 'Вариант 2',
        ));

        //category 8
        $this->insert('subcategory',array(
            'category_id' => 8,
            'name' => 'Пшеница',
        ));

        $this->insert('subcategory',array(
            'category_id' => 8,
            'name' => 'Кукуруза',
        ));

        //category 9
        $this->insert('subcategory',array(
            'category_id' => 9,
            'name' => 'Вариант 3',
        ));

        $this->insert('subcategory',array(
            'category_id' => 9,
            'name' => 'Вариант 4',
        ));

        //category 10
        $this->insert('subcategory',array(
            'category_id' => 10,
            'name' => 'Баранина',
        ));

        $this->insert('subcategory',array(
            'category_id' => 10,
            'name' => 'Говядина',
        ));

        //category 11
        $this->insert('subcategory',array(
            'category_id' => 11,
            'name' => 'Корова',
        ));

        $this->insert('subcategory',array(
            'category_id' => 11,
            'name' => 'Курица',
        ));

        //category 12
        $this->insert('subcategory',array(
            'category_id' => 12,
            'name' => 'Семена 1',
        ));

        $this->insert('subcategory',array(
            'category_id' => 12,
            'name' => 'Семена 2',
        ));

        //category 13
        $this->insert('subcategory',array(
            'category_id' => 13,
            'name' => 'Средства защиты растений',
        ));

        $this->insert('subcategory',array(
            'category_id' => 13,
            'name' => 'Минеральные удобрения',
        ));

        //category 14
        $this->insert('subcategory',array(
            'category_id' => 14,
            'name' => 'Холодильник1',
        ));

        $this->insert('subcategory',array(
            'category_id' => 14,
            'name' => 'Холодильник2',
        ));

        //category 15
        $this->insert('subcategory',array(
            'category_id' => 15,
            'name' => 'Древесина1',
        ));

        $this->insert('subcategory',array(
            'category_id' => 15,
            'name' => 'Древесина2',
        ));

        //category 16
        $this->insert('subcategory',array(
            'category_id' => 16,
            'name' => 'Трактор1',
        ));

        $this->insert('subcategory',array(
            'category_id' => 16,
            'name' => 'Трактор2',
        ));

        //category 17
        $this->insert('subcategory',array(
            'category_id' => 17,
            'name' => 'Оборудование 1',
        ));

        $this->insert('subcategory',array(
            'category_id' => 17,
            'name' => 'Оборудование 2',
        ));

        //category 18
        $this->insert('subcategory',array(
            'category_id' => 18,
            'name' => 'Молоко',
        ));

        $this->insert('subcategory',array(
            'category_id' => 18,
            'name' => 'Сыр',
        ));

        //category 19
        $this->insert('subcategory',array(
            'category_id' => 19,
            'name' => 'Капельные1',
        ));

        $this->insert('subcategory',array(
            'category_id' => 19,
            'name' => 'Капельные2',
        ));

        //category 20
        $this->insert('subcategory',array(
            'category_id' => 20,
            'name' => 'Логистика',
        ));

        $this->insert('subcategory',array(
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
