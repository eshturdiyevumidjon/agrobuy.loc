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
            'table_name' => $this->string(255)->comment("Жадвал номи"),
            'field_id' => $this->integer()->comment("ID сатр"),
            'field_name' => $this->string(255)->comment("сатр номи"),
            'field_value' => $this->text()->comment("Қиймфти"),
            'language_code' => $this->string(255)->comment("Тил коди"),
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
