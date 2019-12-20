<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sub_categories}}`.
 */
class m191205_071858_create_sub_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sub_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sub_categories}}');
    }
}
