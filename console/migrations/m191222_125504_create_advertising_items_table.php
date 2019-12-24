<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advertising_items}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%advertising}}`
 */
class m191222_125504_create_advertising_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advertising_items}}', [
            'id' => $this->primaryKey(),
            'advertising_id' => $this->integer()->comment("Рекламные баннеры"),//(advertisings jadvali bn bog'lanadi)
            'title' =>$this->string(255)->comment("Заголовок"),
            'text' =>$this->text()->comment("Текст"),
            'link' =>$this->string(255)->comment("Ссылка"),
            'type' =>$this->integer()->comment("Тип рекламы"),//(1 => Фотография, 2 => Видео)
            'file' =>$this->string(255)->comment("Файл"),
        ]);

        // creates index for column `advertising_id`
        $this->createIndex(
            '{{%idx-advertising_items-advertising_id}}',
            '{{%advertising_items}}',
            'advertising_id'
        );

        // add foreign key for table `{{%advertising}}`
        $this->addForeignKey(
            '{{%fk-advertising_items-advertising_id}}',
            '{{%advertising_items}}',
            'advertising_id',
            '{{%advertisings}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%advertising}}`
        $this->dropForeignKey(
            '{{%fk-advertising_items-advertising_id}}',
            '{{%advertising_items}}'
        );

        // drops index for column `advertising_id`
        $this->dropIndex(
            '{{%idx-advertising_items-advertising_id}}',
            '{{%advertising_items}}'
        );

        $this->dropTable('{{%advertising_items}}');
    }
}
