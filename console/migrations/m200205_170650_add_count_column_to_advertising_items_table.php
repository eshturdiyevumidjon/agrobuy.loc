<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%advertising_items}}`.
 */
class m200205_170650_add_count_column_to_advertising_items_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%advertising_items}}', 'count', $this->integer()->comment('Счетчик'));
        $this->addColumn('{{%advertising_items}}', 'status', $this->integer()->comment('Статус'));
        $this->addColumn('{{%advertising_items}}', 'click_count', $this->integer()->comment('Кол-во кликов'));
        $this->addColumn('{{%advertising_items}}', 'limit', $this->integer()->comment('Лимит'));
        $this->addColumn('{{%advertising_items}}', 'view_count', $this->integer()->comment('Кол-во просмотров'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%advertising_items}}', 'view_count');
        $this->dropColumn('{{%advertising_items}}', 'count');
        $this->dropColumn('{{%advertising_items}}', 'status');
        $this->dropColumn('{{%advertising_items}}', 'click_count');
        $this->dropColumn('{{%advertising_items}}', 'limit');
    }
}
