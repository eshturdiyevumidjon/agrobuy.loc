<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%translates}}`.
 */
class m190721_085836_create_translates_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%translates}}', [
            'id' => $this->primaryKey(),
            'table_name' => $this->string(255)->comment("Наименование таблицы"),
            'field_id' => $this->integer()->comment("ID строка"),
            'field_name' => $this->string(255)->comment("Наименование строка"),
            'field_description'=> $this->string(255)->comment("Описание поля"),
            'field_value' => $this->text()->comment("Значение"),
            'language_code' => $this->string(255)->comment("Код языка"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%translates}}');
    }
}
