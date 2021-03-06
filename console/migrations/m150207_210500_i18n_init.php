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
            "Soting" => "Сотинг",
            "Batafsil" => "Батафсил",
            "Kirish" => "Кириш",
            "Filtrlar" => "Фильтрлар",
            "Sayt bo'yicha qidirish" => "Сайт бўйича қидириш",
            "Bosh sahifa" => "Бош саҳифа",
            "Chat" => "Чат",
            "Profil" => "Профиль",
            "Kategoriya" => "Категория",
            "Qidirish" => "Қидириш",
            "Joylashuvi" => "Жойлашуви",
            "So'rovingizni kiriting" => "Сўровингизни киритинг", //Qidiruv
            "Kategoriyani tanlang" => "Категорияни танланг",
            "Xabarlar" => "Хабарлар",
            "Barcha huquqlar himoyalangan" => "Барча ҳуқуқлар ҳимояланган",
            "Yangi e'lonlar" => "Янги эълонлар",
            "Ularga ishonishadi" => "Уларга ишонишади",
            "Pullik e'lonlar" => "Пуллик эълонлар", //Premium e’lonlar
            "Maxfiylik siyosati" => "Махфийлик сиёсати",
            "Tez sotish" => "Тез сотиш",
            "Foydalanuvchi shartnomasi" => "Фойдаланувчи шартномаси",
            "Turbo" => "Турбо",
            "Pullik" => "Пуллик",
            "Vip" => "Vip",
            "Reklamalarni ajratib ko'rsatish" => "Рекламани ажратиб кўрсатиш",
            "E'lonni yuqoriga chiqarish" => "Эълонни юқорига чиқариш",
            "Nashrni kengaytirish" => "Нашрни кенгайтириш",
            "E'lon cheklovi" => "Эълон чеклови",
            "Bitim qoidalari" => "Битимлар қоидаси",
            "Ishonishadi" => "Ишонишади",
            "Login" => "Логин",
            "Parol" => "Пароль",
            "Registratsiyadan o'tish" => "Регистрациядан ўтиш",
            "Avtorizatsiya" => "Авторизация",
            "Parolni unutdingizmi?" => "Парольни унутдингизми?",
            "yoki" => "ёки",
            "Avtorizatsiyadan o'tish" => "Авторизациядан ўтиш",
            "Kompaniya nomi" => "Компания номи",
            "ID" => "ID",
            "Katalogni baham ko'ring" => "Каталогни бахам кўриш",
            "Hisobni to'ldirish" => "Хисобни тўлдириш",
            "Summani tanlang" => "Суммани танланг",
            "To'lov usulini tanlang" => "Тўлов усулини танланг",
            "Parol o'ylab toping" => "Пароль ўйлаб топинг",
            "Loginni o'ylab toping" => "Логинни ўйлаб топинг",
            "Kodni yuborish" => "Кодни юбориш",
            "Sizda akkaunt bormi?" => "Сизда аккаунт борми?",
            "Ro'yxatdan o'tish" => "Рўйхатдан ўтиш",
            "Bu sahifa mavjud emas" => "Бу сахифа мавжуд эмас",
            "Siz notog'ri yoki o'chib ketgan havoladan foydalangan bo'lishingiz mumkin" => "Сиз нотўғри ёки ўчиб кетган хаволадан фойдаланган бўлишингиз мумкин",
            "E'lon qo'shish" => "Эълон қўшиш", // E’lon berish
            "ga" => "га",
            "So'm" => "Сўм",
            "Chiqish" => "Чиқиш",
            "Shaxshiy kabinet" => "Шахсий кабинет",
            "O'xshash e'lonlar" => "Ўхшаш эълонлар",
            "Baham ko'rish" => "Бахам кўриш",
            "Muallifga yozish" => "Муаллифга ёзиш",
            "Shikoyat qilish" => "Шикоят қилиш",
            "Xabar yozish..." => "Хабар ёзиш...",
            "E'lon yaratish" => "Эълон яратиш",
            "Sotib olish" => "Сотиб олиш",
            "Katalogga qo'shish" => "Каталогга қўшиш",
            "Rasm qo'shish" => "Расм қўшиш",
            "Bir nechta rasmlarni yuklashingiz mumkin" => "Бир нечта расмларни юклашингиз мумкин",
            "Fayl qo'shish" => "Файл қўшиш",
            "Kategoriyani tanlang" => "Категорияни танланг",
            "Subkategoriyani tanlang" => "Субкатегорияни танланг",
            "Shahar,viloyat qo'shing" => "Шахар,вилоят қўшинг",
            "E'lon sarlavhasi" => "Эълон сарлавхаси",
            "E'lon haqida batafsil ma'lumot berish" => "Эълон хақида батафсил маълумот бериш",
            "Narxni ko'rsating" => "Нархни кўрсатинг",
            "Narxi" => "Нархи",
            "Birlikni kiriting" => "Бирликни киритинг",
            "Kelishilgan" => "Келишилган",
            "E'lonni qo'shish" => "Эълонни қўшиш",
            "Profilni tahrirlash" => "Профильни тахрирлаш",
            "Shaxsiy ma'lumot" => "Шахсий маълумот",
            "F.I.O." => "Ф.И.О.",
            "Tug'ilgan kun" => "Туғилган кун",
            "Telefon nomer" => "Телефон номер",
            "E-mail" => "E-mail",
            "Huquqiy maqomi" => "Хуқуқий мақоми",
            "Jis. shaxs" => "Жис. шахс",
            "Yakka tadbirkor yoki yur. shaxs" => "ИП ёки Юр. шахс",
            "Saqlash" => "Сақлаш",
            "Pasport ma'lumotlari" => "Паспорт маълумотлари",
            "Pasport seriyasi" => "Паспорт серияси",
            "Kim tomonidan berilgan" => "Ким томонидан берилган",
            "Berilgan vaqti" => "Берилган вақти",
            "Foto biriktirish" => "Фото бириктириш",
            "Pasport nomeri" => "Паспорт номери",
            "Jis. yoki yur. shaxs haqida mu'lumot" => "Жис. ёки юридик шахс хақида маълумот",
            "INN" => "ИНН",
            "Kompaniyani qo'shish uchun ariza" => "Компанияни қўшиш учун ариза",
            "So'rov yuborish" => "Сўров юбориш",
            "Reyting" => "Рейтинг",
            "Hisoblash sababi" => "Хисоблаш сабаби",
            "Hisoblash formulasi" => "Хисоблаш формуласи",
            "Profilning to'ldirilganligi" => "Профильнинг тўлдирилганлиги",
            "Saytga tashriflar" => "Сайтга ташрифлар",
            "E'lonlarga javoblar" => "Эълонларга жавоблар",
            "Platformada sarflangan pul" => "Платформада сарфланган пул",
            "E'lonlar soni" => "Эълонлар сони",
            "Bayram kunlari soni uchun reyting" => "Байрам кунлари сони учун рейтинг",
            "Jami" => "Жами",
            "Saytdan chiqish" => "Сайтдан чиқиш",
            "Siz haqiqatdan ham saytdan chiqmoqchimisiz?" => "Сиз хақиқатдан хам сайтдан чиқмоқчимисиз",
            "Profil rasmini o'zgartirish" => "Профиль расмини ўзгартириш",
            "Ishonch" => "Ишонч",
            "Mening katalogim" => "Менинг каталогим",
            "Mening chatim" => "Менинг чатим", //Chatlar
            "Mening e'lonlarim" => "Менинг эълонларим",
            "Sevimlilarim" => "Севимлиларим",
            "Pullik xizmatlar" => "Пуллик хизматлар",
            "Operatsiyalar tarixi" => "Операциялар тарихи",
            "Yozish" => "Ёзиш",
            "Foydalanuvching e'lonlari" => "Фойдаланувчининг эълонлари",
            "Foydalanuvchini baholash" => "Фойдаланувчини бахолаш",
            "Statistika" => "Статистика",
            "Sotish" => "Сотиш",
            "Saralash" => "Саралаш",
            "Narxi bo'yicha" => "Нархига",
            "Sanasi bo'yicha" => "Санасига",
            "Afsuski sizning so'rovingiz bo'yicha hech narsa topilmadi" => "Афсуски сизнинг сўровингиз бўйича хеч нарса топилмади",
            "Profilni tahrirlash" => "Профильни таҳрирлаш",
            "Mening e'lonlarim" => "Менинг эълонларим",
            "E'lonni tahrirlash" => "Эълонни таҳрирлаш",
            "Targ'ib qilish" => "Тарғиб қилиш",
            "Faollashtirish/O'chirish" => "Фаоллаштириш/Ўчириш",
            "E'lonni o'chirish" => "Эълонни ўчириш",
            "Mening katalogimga qo'shish/o'chirish" => "Менинг каталогимга қўшиш/ўчириш",
            "Mening katalogimga qo'shish" => "Менинг каталогимга қўшиш",
            "Mening katalogimdan o'chirish" => "Менинг каталогимдан ўчириш",
            "Operatsiya" => "Операция",
            "Yaratilgan vaqti" => "Яратилган вақти",
            "E'lon nomeri" => "Эълон номери",
            "Summa" => "Сумма",
            "Hisobni to'ldirish" => "Хисобни тўлдириш",
            "Sotib olaman" => "Сотиб оламан",
            "Sotaman" => "Сотаман",
            "Faollashtirilmagan" => "Фаоллаштирилмаган",
            "Siz haqiqatdan ham e'lonni o'chirmoqchimisiz?" => "Сиз хақиқатдан хам эълонни ўчирмоқчимисиз?",
            "Ha" => "Ха",
            "Kerakli fayllar ro'yxati" => "Керакли файллар рўйхати",
            "E'tirozningizni yuboring" => "Эътирозингизни юборинг",
            "E'tirozningizni batafsil bayon eting" => "Эътирозингизни батафсил bayon eting",
            "Valyuta" => "Валюта",
            "Katalog" => "Каталог",
            "Tanlang" => "Танланг",
            "Tahrirlash" => "Таҳрирлаш",
            "Barchasini ko'rish" => "Барчасини кўриш",
            "Ushbu login allaqachon band qilingan." => "Ушбу логин аллақачон банд қилинган",
            "Ushbu telefon nomer allaqachon band qilingan." => "Ушбу телефон номер аллақачон банд қилинган",
            "Sort" => "Сорт",
            "Nomlanishi" => "Номланиши",
            "Og'irligi" => "Оғирлиги",
            "Hosildorlik" => "Хосилдорлик",
            "Muhim" => "Мухим",
            "Amalga oshirish" => "Амалга ошириш",
            "Xabar matni" => "Хабар матни",
            "Orqaga" => "Орқага",
            "O'chirish" => "ўчириш",
            "Siz haqiqatdan ham chatni o'chirmoqchimisiz?" => "Сиз хақиқатдан хам чатни ўчирмоқчимисиз?",
            "Kimga yozmoqchi ekanligingizni tanlang" => "Кимга ёзмоқчи эканлигингизни танланг",
            "Tumanni tanlang" => "Туманни танланг",
            "Bosh S." => "Бош С.",
            "Pullik xizmat vaqtinchalik mavjud emas. Administratorga murojaat qiling" => "Платное объявление временно не доступно. Обратитесь к администратору",
            "Siz bu pullik xizmatni sotib olgansiz. Muddat tugashini kuting" => "Сиз бу пуллик хизматни сотиб олгансиз. Муддат тугашини кутинг",
            "Parolni tiklash" => "Парольни тиклаш",
            "Kodni kiriting" => "Кодни киритинг",
            "Yangi parol" => "Янги пароль",
            "Takroriy parol" => "Такрорий пароль",
            "Parolni tiklash" => "Парольни тиклаш",
            "Telefon raqamingizga kodli xabar yuborildi" => "Телефон рақамингизга кодли хабар юборилди",
        ];

        $translations_uz_ru = [
            "Biz bilan boshlang" => "Начните вместе с нами",
            "Qadam" => "Шаг",   
            "Ro'yhatdan o'ting" => "Зарегистрируйся",
            "Kompaniyangizni qo'shing" => "Добавь компанию",
            "Soting" => "Продай",
            "Batafsil" => "Подробнее",
            "Kirish" => "Войти",
            "Filtrlar" => "Фильтры",
            "Sayt bo'yicha qidirish" => "Поиск по сайту",
            "Bosh sahifa" => "Главная",
            "Chat" => "Чаты",
            "Profil" => "Профиль",
            "Kategoriya" => "Категория",
            "Qidirish" => "Найти",
            "Joylashuvi" => "Местоположение",
            "So'rovingizni kiriting" => "Введите запрос", //Qidiruv
            "Kategoriyani tanlang" => "Выберите категорию",
            "Xabarlar" => "Новости",
            "Barcha huquqlar himoyalangan" => "Все права защищены",
            "Yangi e'lonlar" => "Новые объявления",
            "Ularga ishonishadi" => "Им доверяют",
            "Pullik e'lonlar" => "Премиум объявления", // Premium e’lonlar
            "Maxfiylik siyosati" => "Политика конфиденциальности",
            "Tez sotish" => "Быстрая продажа",
            "Foydalanuvchi shartnomasi" => "Пользовательское соглашение",
            "Turbo" => "Турбо",
            "Pullik" => "Премиум",
            "Vip" => "Vip",
            "Reklamalarni ajratib ko'rsatish" => "Выделение объявлений",
            "E'lonni yuqoriga chiqarish" => "Поднятие объявлений",
            "Nashrni kengaytirish" => "Продление срока публикации",
            "E'lon cheklovi" => "Лимит объявлений",
            "Bitim qoidalari" => "Правила проведения сделок",
            "Ishonishadi" => "Доверяют",
            "Login" => "Логин",
            "Parol" => "Пароль",
            "Registratsiyadan o'tish" => "Зарегистрироваться",
            "Avtorizatsiya" => "Авторизация",
            "Parolni unutdingizmi?" => "Забыли пароль?",
            "yoki" => "или",
            "Avtorizatsiyadan o'tish" => "Авторизоваться",
            "Kompaniya nomi" => "Название компании",
            "ID" => "ID",
            "Katalogni baham ko'ring" => "Поделиться каталогом",
            "Hisobni to'ldirish" => "Пополнить счёт",
            "Summani tanlang" => "Выберите сумму",
            "To'lov usulini tanlang" => "Выберите метод оплаты",
            "Parol o'ylab toping" => "Придумайте пароль",
            "Loginni o'ylab toping" => "Придумайте логин",
            "Kodni yuborish" => "Отправить код",
            "Sizda akkaunt bormi?" => "Уже есть аккаунт?",
            "Ro'yxatdan o'tish" => "Регистрация",
            "Bu sahifa mavjud emas" => "Эта страница недоступна",
            "Siz notog'ri yoki o'chib ketgan havoladan foydalangan bo'lishingiz mumkin" => "Возможно вы воспользовались недействительной ссылкой или страница была удалена",
            "E'lon qo'shish" => "Подать объявления", //E’lon berish
            "ga" => "За",
            "So'm" => "Сум",
            "Chiqish" => "Выход",
            "Shaxshiy kabinet" => "Личный кабинет",
            "O'xshash e'lonlar" => "Похожие объявления",
            "Baham ko'rish" => "Поделиться",
            "Muallifga yozish" => "Написать автору",
            "Shikoyat qilish" => "Пожаловаться",
            "Xabar yozish..." => "Написать сообщение...",
            "E'lon yaratish" => "Создайте объявление",
            "Sotib olish" => "Купить",
            "Katalogga qo'shish" => "Добавить в каталог",
            "Rasm qo'shish" => "Прикрепить фото",
            "Bir nechta rasmlarni yuklashingiz mumkin" => "Можно загрузить несколько фото",
            "Fayl qo'shish" => "Прикрепить файл",
            "Kategoriyani tanlang" => "Выберите категорию",
            "Subkategoriyani tanlang" => "Выберите подкатегорию",
            "Shahar,viloyat qo'shish" => "Добавьте город,регион",
            "E'lon sarlavhasi" => "Заголовок объявления",
            "E'lon haqida batafsil ma'lumot berish" => "Подробно опишите объявление",
            "Narxni ko'rsating" => "Укажите цену",
            "Narxi" => "Цена за",
            "Birlikni kiriting" => "Введите единицу",
            "Kelishilgan" => "Договорная",
            "E'lonni qo'shish" => "Опубликовать объявление",
            "Profilni tahrirlash" => "Редактирование профиля",
            "Shaxsiy ma'lumot" => "Личные данные",
            "F.I.O." => "Ф.И.О.",
            "Tug'ilgan kun" => "Дата рождения",
            "Telefon nomer" => "Номер телефона",
            "E-mail" => "E-mail",
            "Huquqiy maqomi" => "Юридический статус",
            "Jis. shaxs" => "Физ. лицо",
            "Yakka tadbirkor yoki yur. shaxs" => "ИП или Юр. лицо",
            "Saqlash" => "Cохранить",
            "Pasport ma'lumotlari" => "Паспортные данные",
            "Pasport seriyasi" => "Серия паспорта",
            "Kim tomonidan berilgan" => "Кем выдан",
            "Berilgan vaqti" => "Дата выдачи",
            "Foto biriktirish" => "Прикрепить фото",
            "Pasport nomeri" => "Номер паспорта",
            "Jis. yoki yur. shaxs haqida mu'lumot" => "Данные о физ./Юр. лице",
            "INN" => "ИНН",
            "Kompaniyani qo'shish uchun ariza" => "Заявка на добавление компании",
            "So'rov yuborish" => "Отправить заявку",
            "Reyting" => "Рейтинг",
            "Hisoblash sababi" => "Причина начисления",
            "Hisoblash formulasi" => "Формула расчета",
            "Profilning to'ldirilganligi" => "Заполненность профиля",
            "Saytga tashriflar" => "Посещения сайта",
            "E'lonlarga javoblar" => "Ответы на объявления ",
            "Platformada sarflangan pul" => "Деньги потраченные на платформе",
            "E'lonlar soni" => "Количество объявлений",
            "Bayram kunlari soni uchun reyting" => "Рейтинг на численный в дни праздников",
            "Jami" => "Итого",
            "Saytdan chiqish" => "Выйти",
            "Siz haqiqatdan ham saytdan chiqmoqchimisiz?" => "Вы уверены, что хотите выйти?",
            "Profil rasmini o'zgartirish" => "Сменить фото профиля",
            "Ishonch" => "Доверие",
            "Mening katalogim" => "Мой каталог",
            "Mening chatim" => "Мои чаты", //Chatlar
            "Mening e'lonlarim" => "Мои объявление",
            "Sevimlilarim" => "Избранное",
            "Pullik xizmatlar" => "Платные услуги ",
            "Operatsiyalar tarixi" => "История операций",
            "Yozish" => "Написать",
            "Foydalanuvching e'lonlari" => "Объявления пользователя",
            "Foydalanuvchini baholash" => "Оценить пользователя",
            "Statistika" => "Статистика",
            "Sotish" => "Продать",
            "Saralash" => "Сортировать",
            "Narxi bo'yicha" => "Цене",
            "Sanasi bo'yicha" => "Дате",
            "Afsuski sizning so'rovingiz bo'yicha hech narsa topilmadi" => "К сожалению, по Вашему запросу ничего не найденно",
            "Profilni tahrirlash" => "Редактировать профиль",
            "Mening e'lonlarim" => "Мои объявления",
            "E'lonni tahrirlash" => "Редактировать объявление",
            "Targ'ib qilish" => "Продвинуть",
            "Faollashtirish/O'chirish" => "Деактивировать/активировать",
            "E'lonni o'chirish" => "Удалить объявление",
            "Mening katalogimga qo'shish/o'chirish" => "Добавить/удалить объявление в/из мой каталог",
            "Mening katalogimga qo'shish" => "Добавить объявление в мой каталог",
            "Mening katalogimdan o'chirish" => "Удалить объявление из мой каталог",
            "Operatsiya" => "Операция",
            "Yaratilgan vaqti" => "Дата и время",
            "E'lon nomeri" => "№ объявления",
            "Summa" => "Сумма",
            "Hisobni to'ldirish" => "Пополнение счета",
            "Sotib olaman" => "Куплю",
            "Sotaman" => "Продам",
            "Faollashtirilmagan" => "Не активировано",
            "Siz haqiqatdan ham e'lonni o'chirmoqchimisiz?" => "Вы уверены, что хотите удалить объявление?",
            "Ha" => "Да",
            "Kerakli fayllar ro'yxati" => "Список необходимых файлов",
            "E'tirozningizni yuboring" => "Отправьте жалобу",
            "E'tirozningizni batafsil bayon eting" => "Подробно опишите причину жалобы",
            "Valyuta" => "Валюта",
            "Katalog" => "Каталог",
            "Tanlang" => "Выберите",
            "Tahrirlash" => "Изменить",
            "Barchasini ko'rish" => "Смотреть все",
            "Ushbu login allaqachon band qilingan." => "Этот логин уже был занят.",
            "Ushbu telefon nomer allaqachon band qilingan." => "Этот телефон номер уже был занят.",
            "Sort" => "Сорт",
            "Nomlanishi" => "Название",
            "Og'irligi" => "Вес",
            "Hosildorlik" => "Урожайность",
            "Muhim" => "Важно",
            "Amalga oshirish" => "Применить",
            "Xabar matni" => "Текст сообщении",
            "Orqaga" => "Назад",
            "O'chirish" => "Удалить",
            "Siz haqiqatdan ham chatni o'chirmoqchimisiz?" => "Вы уверены, что хотите удалить чата?",
            "Kimga yozmoqchi ekanligingizni tanlang" => "Выберите, кому хотели бы написать",
            "Tumanni tanlang" => "Выберите район",
            "Bosh S." => "Главная",
            /*"Sizning e'loningiz rivojlanmoqda. Muddat tugashini kuting" => "Ваше объявление продвигается. Дождитесь окончания срока продвижения",
            "Siz bu pullik xizmatni sotib olgansiz. Muddat tugashini kuting" => "Вы приобрели платную услугу. Дождитесь окончания срока",*/
            "Pullik xizmat vaqtinchalik mavjud emas. Administratorga murojaat qiling" => "Платное объявление временно не доступно",
            "Siz bu pullik xizmatni sotib olgansiz. Muddat tugashini kuting" => "Вы приобрели платную услугу. Дождитесь окончания срока",
            "Parolni tiklash" => "Восстановление пароля",
            "Kodni kiriting" => "Введите Код",
            "Yangi parol" => "Новый пароль",
            "Takroriy parol" => "Повторный ввод паролья",
            "Parolni tiklash" => "Востановление пароля",
            "Telefon raqamingizga kodli xabar yuborildi" => "На указанный Вами номер телефона было выслано сообщение с кодом",
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

        foreach ($val as $key => $value) {
            $this->insert('{{%message}}',array(
                'id' => ($key+1),
                'language' => 'ru',
                'translation' => $value
            ));
        }

        foreach ($values as $key => $value) {
            $this->insert('{{%message}}',array(
                'id' => ($key+1),
                'language' => 'en',
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
