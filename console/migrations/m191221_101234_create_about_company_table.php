<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%about_company}}`.
 */
class m191221_101234_create_about_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%about_company}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'logo' => $this->string(255)->comment("Лого"),
            'mail' => $this->string(255)->comment("E-mail"),
            'phone' => $this->string(255)->comment("Телефон"),
        ]);

        $this->insert('{{%about_company}}',array(
          'id' => 1,
          'logo' => 'logo.png',
          'name' => 'AgroBuy',
          'mail' => 'agro@gmail.com',
          'phone' => '+998-90-999-99-99',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%about_company}}');
    }
}
