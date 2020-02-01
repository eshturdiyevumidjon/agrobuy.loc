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
            "Biz bilan boshlang" => "Биз билан бошланг",
            "Qadam" => "Қадам",
            "Ro'yhatdan o'ting" => "Рўйхатдан ўтинг",
            "Kompaniyangizni qo'shing" => "Компаниянгизни қўшинг",
            "E'loningizni qo'shing" => "Эълонингизни қўшинг",
            "Soting" => "Сотинг",
            "Batafsil" => "Батафсил",
            "E'lon berish" => "Эълон бериш",
            "Kirish" => "Кириш",
            "Filtrlar" => "Фильтрлар",
            "Sayt bo'yicha qidirish" => "Сайт бўйича қидириш",
            "Bosh sahifa" => "Бош саҳифа",
            "Chat" => "Чат",
            "Profil" => "Профиль",
            "Kategoriya" => "Категория",
            "Qidirish" => "Қидириш",
            "Joylashuvi" => "Жойлашуви",
            "So'rovingizni kiriting" => "Сўровингизни киритинг",
            "Kategoriyani tanlang" => "Категорияни танланг",
            "Xabarlar" => "Хабарлар",
            "Barcha huquqlar himoyalangan" => "Барча ҳуқуқлар ҳимояланган",
            "Yangi e'lonlar" => "Янги эълонлар",
            "Ularga ishonishadi" => "Уларга ишонишади",
            "Pullik e'lonlar" => "Пуллик эълонлар",
            "Soting" => "Сотинг",
        ];

        $translations_uz_ru = [
            "Biz bilan boshlang" => "Начните вместе с нами",
            "Qadam" => "Шаг",   
            "Ro'yhatdan o'ting" => "Зарегистрируйся",
            "Kompaniyangizni qo'shing" => "Добавь компанию",
            "E'loningizni qo'shing" => "Подать объявление",
            "Soting" => "Продай",
            "Batafsil" => "Подробнее",
            "E'lon berish" => "Подать объявление",
            "Kirish" => "Войти",
            "Filtrlar" => "Фильтры",
            "Sayt bo'yicha qidirish" => "Поиск по сайту",
            "Bosh sahifa" => "Главная",
            "Chat" => "Чаты",
            "Profil" => "Профиль",
            "Kategoriya" => "Категория",
            "Qidirish" => "Найти",
            "Joylashuvi" => "Местоположение",
            "So'rovingizni kiriting" => "Введите запрос",
            "Kategoriyani tanlang" => "Выберите категорию",
            "Xabarlar" => "Новости",
            "Barcha huquqlar himoyalangan" => "Все права защищены",
            "Yangi e'lonlar" => "Новые объявления",
            "Ularga ishonishadi" => "Им доверяют",
            "Pullik e'lonlar" => "Премиум объявления",
            "Soting" => "Продай",
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

        foreach ($values as $key => $value) {
            $this->insert('{{%message}}',array(
                'id' => ($key+1),
                'language' => 'kr',
                'translation' => $value
            ));
        }

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
