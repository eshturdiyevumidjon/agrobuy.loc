<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%users}}`.
 */
class m200206_053511_add_access_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'access', $this->integer()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'access');
    }
}
