<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%advertisings}}`.
 */
class m200214_131424_add_time_column_to_advertisings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%advertisings}}', 'time', $this->float()->defaultValue(5)->comment('Время'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%advertisings}}', 'time');
    }
}
