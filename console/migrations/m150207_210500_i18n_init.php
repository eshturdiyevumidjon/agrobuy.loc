<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

use yii\db\Migration;

/**
 * Initializes i18n messages tables.
 *
 *
 *
 * @author Dmitry Naumenko <d.naumenko.a@gmail.com>
 * @since 2.0.7
 */
class m150207_210500_i18n_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%source_message}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(255)->comment("Категория"),
            'message'=> $this->text()->comment("Текст"),
        ], $tableOptions);

        $this->createTable('{{%message}}', [
            'id' => $this->integer()->notNull(),
            'language' => $this->string(16)->notNull(),
            'translation' => $this->text(),
        ], $tableOptions);

        $this->addPrimaryKey('pk_message_id_language', '{{%message}}', ['id', 'language']);
        $this->addForeignKey('fk_message_source_message', '{{%message}}', 'id', '{{%source_message}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('idx_source_message_category', '{{%source_message}}', 'category');
        $this->createIndex('idx_message_language', '{{%message}}', 'language');

        $translations = [
                'Kutubxona'=>'',
                'Manzilimiz'=>'',
                'Barchasini ko\'rish'=>'',
                'Ko\'chirib olish'=>'',
                'Ko\'p o\'qilgan maqolalar'=>'',
                'Oylik va haftalik nashrlar'=>'',
                'Video'=>'',
                'Galereya'=>'',
                'Audiolar'=>'',
                'Biz bilan aloqa'=>'',
                'Ijtimoiy tarmoqlar'=>'Ижтимоий тармоқлар',
                'Saytdan materiallar olib chop etilganda «www.ijod.uz saytidan olindi» deb ko\'rsatilishi shart'=>'Сайтдан материаллар олиб чоп етилганда «www.ijod.uz сайтидан олинди» деб кўрсатилиши шарт',
                '"Ijod" jamoat fondi'=>'"Ижод" жамоат фонди',
                'Batafsil'=>'Батафсил',
                'Bosh sahifa'=>'Бош саҳифа',
                'Adabiy jarayonlar'=>'Адабий жараёнлар',
                'Sayt bo\'limlari'=>'Сайт бўлимлари',
                'Hujjatlar'=>'Ҳужжатлар',
                'Uyushma haqida'=>'Уюшма ҳақида',
                'Muallif'=>'Муаллиф',
                'Janr'=>'Жанр',
                'Soat oldin'=>'Соат олдин',
                'Bosh muharrir'=>'Бош муҳаррир',
                'Elektron kutubxona'=>'Электрон кутубхона',
                'Uyushma rahbariyati'=>'Уюшма раҳбарияти',
                '"Do\'rmon" ijod uyi'=>'"Дўрмон" ижод уйи',
                '"Ijod" fondi'=>'"Ижод" фонди',
                'Nashrlar'=>'Нашрлар',
                'O\'zbekiston Yozuvchilar uyushmasi a\'zolari soni to\'g\'risida ma\'lumot'=>'Ўзбекистон Ёзувчилар уюшмаси аъзолари сони тўғрисида маълумот',
                'Nomi'=>'Номи',
                'Matn'=>'Матн',
                'Sarlavha'=>'Сарлавҳа',
                'FIO' => 'ФИО',
                'Tug\'ilgan joyi' => 'Туғилган жойи',
                'Ijod qilgan' =>'Ижод қилган',
                'Mukofotlari'=>'Мукофотлари',
                'Qisqacha ma\'lumot'=>'Қисқача маълумот',
                'Yig\'ilish nomi'=>'Йиғилиш номи',
                'Manzili'=>'Ианзили',
                'Ishtirok etish tartibi'=>'Иштирок етиш тартиби',
                'Muassis' => 'Муассис',
                'Bosh muharir o\'rinbosari'=>'Бош муҳарир ўрибосари',
                'Nazm bo\'limi mudiri'=>'Назм бўлими мудири',
                'Nasr bo\'limi mudiri'=>'Наср бўлими мудири',
                'Adabiyot shunoslik bo\'limi mudiri'=>'Адабиёт шунослик мудири',
                'Telefonlar'=>'Телефонлар',
                'E-mail'=>'Э-маил',
                'Web-sayt'=>'Веб-сайт',
                'Manzil'=>'Манзил',
                'Foydali resurslar'=>'Фойдали ресурслар',
                'O\'zbekiston respublikasi hukumat portali'=>'Ўзбекистон республикаси хукумат портали',
                'Davlat xizmatlari portali'=>'Давлат хизматлари портали',
                'Madaniyat vazirligi'=>'Маданият вазирлиги',
                'Adiblar'=>'Адиблар',
                'Yig\'ilishlar'=>'Йиғилишлар',
                'Bizning nashrlar'=>'Бизнинг нашрлар',
                'Davomini o\'qish'=>'Давомини ўқиш',
                'Video albom'=>'Видео албом',
                'Audio Kutubxona'=>'Аудио кутубхона',
                'Bizning yangiliklarimizga yoziling'=>'Бизнинг янгиликларимизка ёзилинг',
                'Jo\'natish'=>'Жўнатиш',
                'Aloqa'=>'Алоқа',
                'Yordam va ko\'mak'=>'Ёрдам ва кўмак',
                'Qo\'llanmalar'=>'Қўлланмалар',
                'Qayta aloqa'=>'Қайта алоқа',
                'Savollar va takliflar'=>'Саволлар ва таклифлар',
                'Videolar'=>'Видео',
                'Asosiy'=>'Асосий',
                'Asosiy'=>'Асосий',
                'Uyushma tarixi'=>'Уюшма тарихи',
                'Rahbariyat'=>'Раҳбарият',
                'Top adabiy jarayonlar'=>'Топ адабий жараёнлар',
                'So\'ngi adabiy jarayonlar'=>'Сўнги адабий жараёнлар',
                'Hududiy bo\'limlar'=>'Ҳудудий бўлимлар',
                'Poliklinika'=>'Поликлиника',
                'Yozuvchilar uyushmasi poliklinikasi'=>'Ёзувчилар уюшмаси поликлиникаси',
                'Mavzuga doir'=>'Мавзуга доир',
                'Yangi kitoblar'=>'Янги китоблар',
                'Bosh muharir'=>'Бош муҳарир',
                'Sizning so\'rovingiz muvaffaqiyatli jo\'natildi'=>'Сизнинг сўровингиз муваффаыиятли жўнатилди',
                'Telefon'=>'Телефон',
                'Qidiruv natijasi'=>'Қидириш натижаси',
                'Qidirsh'=>'Қидириш',
                'Maqolalar'=>'Мақолалар',


            ];

            $translations_uz_ru = [
                'Kutubxona'=>'Библиотека',
                'Manzilimiz'=>'Наш адрес',
                'Barchasini ko\'rish'=>'Увидеть всех',
                'Ko\'chirib olish'=>'Скачать',
                'Ko\'p o\'qilgan maqolalar'=>'Самые читаемые статьи',
                'Oylik va haftalik nashrlar'=>'Ежемесячные и еженедельные публикации',
                'Video'=>'Видео',
                'Galereya'=>'Галерея',
                'Audiolar'=>'Аудиозаписи',
                'Biz bilan aloqa'=>'Связаться с нами',
                'Ijtimoiy tarmoqlar'=>'Социальные сети',
                'Saytdan materiallar olib chop etilganda «www.ijod.uz saytidan olindi» deb ko\'rsatilishi shart'=>'При копировании и распечатке материалов с сайта «www.ijod.uz» это должно отображаться как скопированное с сайта',
                '"Ijod" jamoat fondi'=>'Общественный фонд "Ижод"',
                'Batafsil'=>'Читать далее',
                'Bosh sahifa'=>'Главный',
                'Adabiy jarayonlar'=>'Литературные процессы',
                'Sayt bo\'limlari'=>'Разделы сайта',
                'Hujjatlar'=>'Документы',
                'Uyushma haqida'=>'О нас',
                'Muallif'=>'Автор',
                'Janr'=>'Жанр',
                'Soat oldin'=>'Час до',
                'Bosh muharrir'=>'Главный редактор',
                'Elektron kutubxona'=>'Электронная библиотека',
                'Uyushma rahbariyati'=>'Управление ассоциацией',
                '"Do\'rmon" ijod uyi'=>'Дом творчества "Дурмон"',
                '"Ijod" fondi'=>'Фонд "Ижод"',
                'Nashrlar'=>'Публикации',
                'O\'zbekiston Yozuvchilar uyushmasi a\'zolari soni to\'g\'risida ma\'lumot'=>'Информация о количестве членов Союза писателей Узбекистана',
                'Nomi'=>'Названия',
                'Matn'=>'Текст',
                'Sarlavha'=>'Заголовок',
                'FIO' => 'ФИО',
                'Tug\'ilgan joyi' => 'Место рождения',
                'Ijod qilgan' =>'Творчество',
                'Mukofotlari'=>'Награды',
                'Qisqacha ma\'lumot'=>'Краткое описание',
                'Yig\'ilish nomi'=>'Название встречи',
                'Manzili'=>'Адрес',
                'Ishtirok etish tartibi'=>'Порядок участия',
                'Muassis' => 'Основатель',
                'Bosh muharir o\'rinbosari'=>'Заместитель главного редактора',
                'Nazm bo\'limi mudiri'=>'Начальник отдела',
                'Nasr bo\'limi mudiri'=>'Руководитель отдела прозы',
                'Adabiyot shunoslik bo\'limi mudiri'=>'Начальник отдела литературы',
                'Telefonlar'=>'Телефоны',
                'E-mail'=>'Электронная почта.',
                'Web-sayt'=>'Веб-сайт',
                'Manzil'=>'Адрес',
                'Foydali resurslar'=>'Полезные ресурсы',
                'O\'zbekiston respublikasi hukumat portali'=>'Правительственный портал Республики Узбекистан',
                'Davlat xizmatlari portali'=>'Портал государственных услуг',
                'Madaniyat vazirligi'=>'Министерство культуры',
                'Adiblar'=>'Писатели',
                'Yig\'ilishlar'=>'Встречи',
                'Bizning nashrlar'=>'Наши публикации',
                'Davomini o\'qish'=>'Читать дальше',
                'Video albom'=>'Видео албом',
                'Audio Kutubxona'=>'Библиотека Аудио',
                'Bizning yangiliklarimizga yoziling'=>'Подпишитесь на нашу рассылку',
                'Jo\'natish'=>'Отправить',
                'Aloqa'=>'Связь',
                'Yordam va ko\'mak'=>'Помощь и поддержка',
                'Qo\'llanmalar'=>'Инструкция',
                'Qayta aloqa'=>'Повторное связь',
                'Savollar va takliflar'=>'Вопросы и предложения',
                'Videolar'=>'Видео',
                'Asosiy'=>'Главный',
                'Uyushma tarixi'=>'История Ассоциации',
                'Rahbariyat'=>'Управление',
                'Top adabiy jarayonlar'=>'Лучшие литературные процессы',
                'So\'ngi adabiy jarayonlar'=>'Недавние литературные процессы',
                'Hududiy bo\'limlar'=>'Региональные разделы',
                'Poliklinika'=>'Поликлиника',
                'Yozuvchilar uyushmasi poliklinikasi'=>'Союз писателей-поликлиника',
                'Mavzuga doir'=>'Связанные с темой',
                'Yangi kitoblar'=>'Новые книги',
                'Bosh muharir'=>'Главний редактор',
                'Sizning so\'rovingiz muvaffaqiyatli jo\'natildi'=>'Ваш запрос был успешно отправлен',
                'Telefon'=>'Телефон',
                'Qidiruv natijasi'=>'Результаты поиска',
                'Qidirsh'=>'Поиск',
                'Maqolalar'=>'Статьи',


                
            ];

        $keys = array_keys($translations);
        $values = array_values($translations);
        $val = array_values($translations_uz_ru);

        foreach ($keys as $key => $value) {
              $this->insert('{{%source_message}}',array(
            'message' => $value,
            'category' => 'app'
            ));
        };

        foreach ($keys as $key => $value) {
              $this->insert('{{%message}}',array(
            'id' => ($key+1),
            'language' => 'uz',
            'translation' => $value
            ));
        };
        foreach ($values as $key => $value) {
              $this->insert('{{%message}}',array(
            'id' => ($key+1),
            'language' => 'en',
            'translation' => $value
            ));
        }
         foreach ($val as $key => $value) {
              $this->insert('{{%message}}',array(
            'id' => ($key+1),
            'language' => 'ru',
            'translation' => $value
            ));
        }
    }

    public function down()
    {
        $this->dropForeignKey('fk_message_source_message', '{{%message}}');
        $this->dropTable('{{%message}}');
        $this->dropTable('{{%source_message}}');
    }
}
