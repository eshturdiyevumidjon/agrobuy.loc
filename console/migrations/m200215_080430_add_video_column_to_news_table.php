<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%news}}`.
 */
class m200215_080430_add_video_column_to_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%news}}', 'video', $this->string(255)->comment('Видео'));
        $this->addColumn('{{%news}}', 'video_title', $this->string(255)->comment('Заголовок видео'));

        $this->addColumn('{{%news}}', 'sort_title', $this->string(255)->comment('Выбираем сорт'));
        $this->addColumn('{{%news}}', 'sort_items', $this->text()->comment('Пункты сорта'));

        $this->addColumn('{{%news}}', 'landing_title', $this->string(255)->comment('Посадка'));
        $this->addColumn('{{%news}}', 'landing_text', $this->text()->comment('Текст посадки'));
        $this->addColumn('{{%news}}', 'important', $this->text()->comment('Важно'));

        $this->addColumn('{{%news}}', 'growing_title', $this->string(255)->comment('Выращивание'));
        $this->addColumn('{{%news}}', 'growing_text', $this->text()->comment('Текст выращивании'));
        $this->addColumn('{{%news}}', 'growing_items', $this->text()->comment('Пункты выращивании'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%news}}', 'video');
    }
}
