<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%lang}}`.
 */
class m190715_194709_create_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%lang}}', [
            'id' => $this->primaryKey(),
            'url'=>$this->string(255)->comment("Код языка"),
            'local'=>$this->string(255)->comment("Местное название"),
            'name'=>$this->string(255)->comment("Наименование"),
            'image'=>$this->string(255)->comment("Фотография"),
            'default'=>$this->integer()->defaultValue(0),
            'status'=>$this->integer()->defaultValue(0)->comment("Статус"),
            'date_update'=>$this->integer()->comment("Дата изменение"),
            'date_create'=>$this->integer()->comment("Дата создание"),
        ]);

         $this->insert('{{%lang}}',array(
            'url'=>'kr',
            'local'=>'ЎЗБ',
            'name'=>'ўзбекча - Крилица',
            'default'=>1,
            'status'=>1,
            'date_update'=>time(),
            'date_create'=>time(),
        ));

        $this->insert('{{%lang}}',array(
            'url'=>'uz',
            'local'=>'UZB',
            'name'=>'o\'zbekcha - O\'zbekcha',
            'default'=>1,
            'status'=>1,
            'date_update'=>time(),
            'date_create'=>time(),
        ));

        $this->insert('{{%lang}}',array(
            'url'=>'ru',
            'local'=>'РУС',
            'name'=>'russian - Russian',
            'default'=>1,
            'status'=>1,
            'date_update'=>time(),
            'date_create'=>time(),
        ));


        $this->insert('{{%lang}}',array(
            'url'=>'ru',
            'local'=>'ENG',
            'name'=>'english - English',
            'default'=>0,
            'status'=>1,
            'date_update'=>time(),
            'date_create'=>time(),
        ));
        
       

        // $this->insert('{{%lang}}',array(
        //     'url'=>'en',
        //     'local'=>'en-En',
        //     'name'=>'english - English',
        //     'default'=>1,
        //     'create' => 1,
        //     'status'=>0,
        //     'image'=>'/uploads/flags/en.png',
        //     'date_update'=>time(),
        //     'date_create'=>time(),
        // ));


        

        
        
        //   $this->batchInsert('{{%lang}}', [
        //     'url',
        //     'local',
        //     'image',
        //     'name',
        // ], $language);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%lang}}');
    }
}