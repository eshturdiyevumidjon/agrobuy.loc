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
        $language=[
            ['ru','ru-RU','/uploads/flags/ru.png','Russian - Русский'],
            ['en','en-EN','/uploads/flags/en.png','English - English'],
            ['af','af-ZA','/uploads/flags/af.png','Afrikaans - Africaans'],
            ['ar','ar-AR','/uploads/flags/ar.png','‏Arabic -العربية‏'],
            ['az','az-AZ','/uploads/flags/az.png','Azerbaijani - Azərbaycan dili'],
            ['be','be-BY','/uploads/flags/be.png','Belarusian - Беларуская' ],
            ['bg','bg-BG','/uploads/flags/bg.png','Bulgarian - Български' ],
            ['bs','bs-BA','/uploads/flags/bs.png','Bosnian - Bosanski'],
            ['cs','cs-CZ','/uploads/flags/cs.png','Czech - Čeština' ],
            ['da','da-DK','/uploads/flags/da.png','Danish - Dansk'],
            ['de','de-DE','/uploads/flags/de.png','German - Deutsch'],
            ['el','el-GR','/uploads/flags/el.png','Greek - Ελληνικά'],
            ['es','es-ES','/uploads/flags/es.png','Spanish - Español'],
            ['et','et-EE','/uploads/flags/et.png','Estonian - Eesti'],
            ['fa','fa-IR','/uploads/flags/fa.png','Persian -فارسی‏'] ,
            ['fi','fi-FI','/uploads/flags/fi.png','Finnish - Suomi'],
            ['fr','fr-FR','/uploads/flags/fr.png','French - Français'],
            ['he','he-IL','/uploads/flags/he.png','Hebrew - ברית‏'],
            ['hr','hr-HR','/uploads/flags/hr.png','Croatian - Hrvatski'],
            ['hu','hu-HU','/uploads/flags/hu.png','Hungarian - Magyar'],
            ['hy','hy-AM','/uploads/flags/hy.png','Armenian - Հայերեն'],
            ['id','id-ID','/uploads/flags/id.png','Indonesian - Bahasa Indonesia'] ,
            ['it','it-IT','/uploads/flags/it.png','Italian - Italiano'],
            ['ja','ja-JP','/uploads/flags/ja.png','Japanese - 日本語'],
            ['ka','ka-GE','/uploads/flags/ka.png','Georgian - ქართული'],
            ['kk','kk-KK','/uploads/flags/kk.png','Kazakh - Qazaqşa'],
            ['ko','ko-KR','/uploads/flags/ko.png','Korean - 한국어'],
            ['lv','lv-LV','/uploads/flags/lv.png','Latvian - Latviešu'],
            ['ms','ms-MY','/uploads/flags/ms.png','Malay - Bahasa Malayu' ],
            ['nb','nb-NO','/uploads/flags/nb.png','Norwegian - Norsk'],
            ['nl','nl-NL','/uploads/flags/nl.png','Dutch - Nederlands' ],
            ['pl','pl-PL','/uploads/flags/pl.png','Polish - Polski'],
            ['pt','pt-PT','/uploads/flags/pt.png','Portuguese-Portugal'],
            ['pt-BR','pt-BR','/uploads/flags/pt-BR.png','Portuguese-Brazil'],
            ['ro','ro-RO','/uploads/flags/ro.png','Romanian - Română'],
            ['sk','sk-SK','/uploads/flags/sk.png','Slovak - Slovenčina'],
            ['sl','sl-SI','/uploads/flags/sl.png','Slovenian - Slovenščina'],
            ['sr','sr-RS','/uploads/flags/sr.png','Serbian - Српски'],
            ['sv','sv-SE','/uploads/flags/sv.png','Swedish - Svenska'],
            ['th','th-TH','/uploads/flags/th.png','Thai - ภาษาไทย'],
            ['tr','tr-TR','/uploads/flags/tr.png','Turkish - Türkçe'],
            ['uk','uk-UA','/uploads/flags/uk.png','Ukrainian - Українська'],
            ['uz','uz-Uz','/uploads/flags/uz.png','Uzbek - O\'zbekcha'],
            ['vi','vi-VN','/uploads/flags/vi.png','Vietnamese - Tiếng Việt'],
            ['zh-CN','zh-CN','/uploads/flags/zh-CN.png','Simplified Chinese (China)-中文(简体)'],
            ['zh-TW','zh-TW','/uploads/flags/zh-TW.png','Traditional Chinese (Taiwan)-中文(台灣)'],
            ];
        $this->createTable('{{%lang}}', [
            'id' => $this->primaryKey(),
            'url'=>$this->string(255)->comment("Код языка"),
            'local'=>$this->string(255)->comment("Местное название"),
            'name'=>$this->string(255)->comment("Наименование"),
            'image'=>$this->string(255)->comment("Фотография"),
            'default'=>$this->integer()->defaultValue(0)->comment("Заметка"),
            'create'=>$this->integer()->defaultValue(0)->comment("Заметка"),
            'status'=>$this->integer()->defaultValue(0)->comment("Статус"),
            'date_update'=>$this->integer()->comment("Дата изменение"),
            'date_create'=>$this->integer()->comment("Дата создание"),
        ]);

        $this->insert('{{%lang}}',array(
            'url'=>'uz',
            'local'=>'o\'z-O\'z',
            'name'=>'o\'zbekcha - O\'zbekcha',
            'default'=>1,
            'create' => 1,
            'status'=>1,
            'image'=>'/uploads/flags/uz.png',
            'date_update'=>time(),
            'date_create'=>time(),
        ));

        $this->insert('{{%lang}}',array(
            'url'=>'ru',
            'local'=>'ру-Ру',
            'name'=>'russian - Russian',
            'default'=>1,
            'create' => 1,
            'status'=>0,
            'image'=>'/uploads/flags/ru.png',
            'date_update'=>time(),
            'date_create'=>time(),
        ));
        
       
        $this->insert('{{%lang}}',array(
            'url'=>'en',
            'local'=>'en-En',
            'name'=>'english - English',
            'default'=>1,
            'create' => 1,
            'status'=>0,
            'image'=>'/uploads/flags/en.png',
            'date_update'=>time(),
            'date_create'=>time(),
        ));


        

        
        
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