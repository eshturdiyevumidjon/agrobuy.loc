<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%news}}`.
 */
class m200218_164158_add_type_column_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'data_type', $this->integer()->defaultValue(1)->comment('Тип'));
        $this->addColumn('{{%news}}', 'in_photo', $this->string(255)->comment('Картинка'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%news}}', 'data_type');
        $this->dropColumn('{{%news}}', 'in_photo');
    }
}
