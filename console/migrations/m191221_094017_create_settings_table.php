<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m191221_094017_create_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->comment("Наименование"),
            'key' => $this->string(255)->comment("Ключ"),
            'value' => $this->text()->comment("Текст"),
            'priority' => $this->integer()->comment("Приоритет"),
            'view_in_footerser_id' => $this->boolean()->comment("Показать в футере"),
        ]);

        $this->insert('{{%settings}}',array(
            'name' => 'Пользовательское соглашение',
            'value' => 'Основания возникновения ответственности

1. Распространение запрещенной информации и материалов

В настоящее время существует достаточно широкий круг информации, распространение которой прямо запрещено законом. В первую очередь это материалы экстремистского характера, информация о наркотиках и способах их изготовления, порнографические материалы и т.д. В соответствии с «антипиратским законом» к числу запрещенной информации можно отнести любые сведения, направленные на получение доступа к фильмам (включая ссылки, каталогие торрент-сервисов и т.п.).

2. Нарушение договорных обязательств по срокам и/или качеству услуг

Соглашаясь с Пользовательским соглашением, пользователь заключает с владельцем интернет-сервиса гражданско-правовой договор, предмет которого, как правило, касается оказания услуг (выполнения работ) или предоставления лицензии. Поэтому в соглашении нужно обыграть возможные правовые риски. Особенно данное положение важно для сервисов, предоставляемых на платной основе.

3. Ненадлежащая реклама

Монетизация сервиса может выполняться на рекламной основе. В таком случае к вышеобозначенным рискам добавляется возможность привлечения к ответственности за распространение недобросовестной или недостоверной рекламы.

4. Внедоговорное причинение вреда имуществу, здоровью или жизни

Достаточно частая ситуация с учетом любви российских пользователей к самостоятельному решению задач, требующих высокой квалификации. К числу таких сервисов можно, например, отнести различные «медицинские» сайты, на которых размещаются консультации врачей, описание методов лечения, показания по применению лекарственных средств, диет и проч. средств и способов «улучшения» здоровья.

5. Ущемление личных неимущественных прав

Данное основание в первую очередь связано с распространением недостоверной информации, порочащей честь, достоинство или деловую репутацию третьего лица. Здесь же могут быть претензии в связи с нарушением права на изображение гражданина, авторского права на имя и т.п.

6. Недобросовестная конкуренция

Как правило данное основание связано с распространением недобросовестной рекламы или информации, порочащей деловую репутацию конкурента.

Способы ограничения ответственности путем определения вида и содержания договора

1. Безоговорочное присоединение к условиям публичной оферты

Для придания юридической силы дисклаймеру, включенному в текст соглашения с пользователем, необходимо подтвердить факт ознакомления и принятия пользователем его условий. Для этого используется предусмотренный законодательством механизм заключения договоров.

Как мы указали выше, размещение Пользовательского соглашения на сайте интернет-сервиса направлено на заключение с пользователем договора. Раздел 1 шаблона пользовательского соглашения направлен на обеспечение механизма легального скрепления отношений сторон на условиях Пользовательского соглашения без каких-либо оговорок.

2. Замена услуг лицензией на использование программно-аппаратных средств

Данный вопрос достоин отдельного обсуждения в рамках темы использования лицензии на сервис в рамках договора SaaS. Поэтому здесь мы не будем особо углубляться в его рассмотрение. Отметим лишь, что риски использования лицензионной схемы существуют у платных сервисов и связаны с возможностью переквалификации соглашения на договор возмездного оказания услуг. В случае применения владельцем сервиса льготы по НДС в связи с лицензированием программного обеспечения такого сервиса, переквалификация сделки повлечет вменение недоимки по НДС (18% с суммы реализации), пени и привлечение к налоговой ответственности (штраф от 20% суммы недоимки).

Рассматриваемый шаблон пользовательского соглашения разработан для бесплатных сервисов, поэтому у владельца отсутствуют приведенные выше налоговые риски. В то же время он получает дополнительные преимущества в снижении гражданских рисков, поскольку результаты творчества, к которым законом относятся сайты в целом и включаемые в их объекты авторских прав, защищаются вне зависимости от их достоинства и могут предоставляться в пользование «как есть», т.е. без дополнительных гарантий товарной пригодности и качества (см. раздел 3 шаблона Пользовательского соглашения).

3. Безвозмездность лицензии

Этот принцип позволяет использовать указанные в п.2 преимущества лицензионной схемы. В то же время безвозмездность лицензии препятствует применению Закона О защите прав потребителя в случае, когда на стороне пользователя – физическое лицо (см. п.6.1. шаблона Пользовательского соглашения).

4. Отказ от гарантий и предоставление сервиса «как есть»

Если требования в п.3 являются условием применения лицензионной схемы предоставления сервиса, то данные положения являются его следствием. В Пользовательском соглашении необходимо с достаточной ясностью изложить условия об ограничении ответственности за предоставление и использование сервиса, например, как это сделано в п.6.2. шаблона Пользовательского соглашения.

5. Ответственность при наличии вины

По общему правилу ответственность по обязательствам, не связанным с осуществлением предпринимательской деятельности, возникает только при наличии вины нарушителя (ст.400, 401 ГК РФ). Кроме того, закон позволяет заранее заключить соглашение об ограничении ответственности (кроме случаев умышленного нарушения).

Поэтому в Пользовательское соглашение на использование интернет-сервиса может быть включено условие о привлечении владельца сервиса к ответственности только при наличии его вины.

6. Форс-мажор и действия третьих лиц

Форс-мажор (обстоятельства непреодолимой силы) на основании п.3 ст.401 ГК РФ освобождает от ответственности также в случаях нарушения обязательства при отсутствии вины.

7. Введение предельной суммы компенсации

На основании ст.400 ГК РФ ответственность владельца интернет-сервиса может быть ограничена предельным размером. Исключение составляют случаи когда пользователь выступает в качестве потребителя и законом установлен определенный размер ответственности за данное нарушение.

Ранее мы указали, что в случае безвозмездного предоставления сервиса, пользователь на считается потребителем по смыслу гражданского законодательства. Поэтому данное исключение не действует. В случае предоставления платного сервиса размер ответственности определяется в том числе в зависимости от вида заключенного договора.

8. Получение лицензии на пользовательский контент (UGC) при его добавлении

В случае предоставления социального сервиса или платформы для размещения пользователями различных материалов в публичном доступе необходимо оформлять лицензионное соглашение на использование такого контента в рамках такого интернет-сервиса (см. раздел 5 шаблона Пользовательского соглашения).

Например, владелец сервиса может захотеть использовать пользовательский контент на иных страницах сайта, в презентациях, транслировать его на другие сайты и т.п., что невозможно без получения соответствующего разрешения.

9. Возложение ответственности за UGC на пользователей

Получение лицензии подтверждает факт использования контента с разрешения пользователя, который отвечает за наличие у него полномочий на выдачу такой лицензии (см. п.6.3, 6.5., 6.11 шаблона Пользовательского соглашения).

10. Отсутствие премодерации

Получение лицензии на пользовательский контент в полной мере не устраняет владельца интернет-сервиса от ответственности за нарушение исключительных прав действительного правообладателя. Помимо прочего необходимо подтвердить, что владелец не знал о возможном нарушении. Поэтому в Пользовательском соглашении нужно четко обозначить, что предварительная проверка контента не производится (см.п.6.4.).

11. Правила обращения правообладателя

Для упрощения работы с правообладателями в Пользовательское соглашение включаются условия о необходимости предоставления ссылки на страницу с контрафактным материалом и адрес для направления уведомления о нарушении прав (см. п.6.7. Пользовательского соглашения).

12. Введение процедуры вступления пользователя в спор (авторизации)

Для подтверждения факта существования пользователя, на которого в соответствии с законом и соглашением возлагается ответственность за размещение контрафактного материала, следует предусмотреть в Пользовательском соглашении требования о его авторизации в случае получения претензии (см. п.6.8. соглашения с пользователем).

13. Определение условий блокировки аккаунта и удаления контента

Соблюдение требований федерального закона Об информации в редакции нового антипиратского закона предполагает удаление информационным посредником спорных материалов по первому обращению правообладателя. Поэтому Пользовательское соглашение должно предоставлять владельцу интернет-сервиса такую возможность без предварительного согласования и уведомления пользователя (см. п.6.9 и 6.10).

Положения п.8-13 направлены на выполнение требований законодательства о совершении владельцем интернет-ресурса как информационным посредником всех необходимых действий для устранения возможных нарушений интеллектуальных прав третьих лиц.

14. Тестовый характер сервиса

Данная причина снижает налоговые риски безвозмездной реализации (раз) и служит дополнительным аргументов в пользу ограничения ответственности (два) и временном характере обязательств (три).

15. Упрощенный порядок изменения условий и отзыва оферты, прекращения договора

Статья 450 ГК РФ позволяет заранее достигнуть соглашение об упрощенном порядке изменения или расторжения договора путем включения таких условий в текст договора (см. п.9.4 Пользовательского соглашения).

16. Выделение условий предоставления платных услуг в отдельное соглашение

Если наряду с бесплатным использованием общего функционала сервиса вы предлагаете оплатить отдельные его возможности, необходимо оформить отдельный договор на платные услуги.

Это требуется, во-первых, для обоснования продолжения безвозмездного предоставления базового функционала, а во-вторых, для сохранения принятой модели снижения гражданских рисков.

17. Взимание платы за доступ к функционалу, а не услуги на его основе

Такой порядок значительно упрощает процесс доказывания факта оказания услуг, отражения сумм реализации и документооборота, т.к. услуги считаются оказанными с момента открытия доступа на определенный период, а не по истечении такого периода времени.

18. Снятие ответственности за использование учетных данных

Действия, совершенные с использованием логина и пароля пользователя, должны однозначно рассматриваться в качестве действий самого пользователя. На пользователя необходимо возложить ответственность за обеспечение сохранности своих учетных данных (см.2.3. шаблона).

19. Введение требований к размещаемым рекламным материалам

Если ваш сервис связан с размещением рекламы, необходимо предусмотреть требования к рекламным материалам, размещаемым с использованием вашей системы. Обычно это делается путем включения в Пользовательское соглашение ссылки на отдельный регламент, который имеет для сторон обязательный характер и включает условия размещения рекламы и требования к ее оформлению, содержанию и подтверждению соблюдения законодательства при ее размещении.

20. Получение согласия на использование персональных данных

В случае заключения Пользовательского соглашения с физическим лицом возникает необходимость соблюдения законодательства о персональных данных. У пользователя должно быть получено письменное согласие на обработку его персональных данных с указанием перечня таких данных, допустимых способов их обработки, целей и срока обработки и т.д. (см. раздел 8 шаблона).

21. Определение допустимого порядка уведомления пользователей

Данное положение Соглашения направлено на соблюдение требований о недопущении СПАМа (см. раздел 7 шаблона).

На этом мы завершаем описание основных принципов составления Пользовательского соглашения. Разумеется, предложенные положения должны применяться с учетом специфики конкретного интернет-сервиса. Поэтому условия соглашения могут быть существенно расширены или, наоборот, сокращены и адаптированы в зависимости от механики и коммерческих условий предоставления сервиса.',
        ));

        $this->insert('{{%settings}}',array(
            'name' => 'Политика конфиденциальности',
            'value' => 'Политика конфиденциальности приложения «Payme» (мобильные приложения для платформ iOS, Android и веб-версии www.payme.uz)

 

            Настоящая Политика устанавливает особенности сбора и обработки компанией Общество с ограниченной ответственностью «INSPIRED» (далее – Paycom™) данных физических лиц - пользователей Приложения «Payme» (включающее в себя мобильные приложения для платформ iOS, Android и веб-версии www.payme.uz, далее – «Приложение»).

            Настоящий документ («Политика») является неотъемлемой частью Публичной оферты об использовании Приложения. Настоящая Политика применяется исключительно к информации, которая была получена Paycom™ в результате использования Приложения Пользователями.

            При скачивании, установке Приложения, Пользователь в полном объеме принимает условия настоящей Политики и выражает свое добровольное определенное согласие на обработку персональных данных способом и в целях как это описано в настоящей Политике. Если Пользователь не согласен с настоящей Политикой, Paycom™ просит отказаться от загрузки Приложения.

            Paycom™ вправе в одностороннем порядке вносить изменения в настоящую Политику, информируя об этом Пользователя путем опубликования указанных изменений на сайте www.payme.uz или в информационных сообщениях в интерфейсе Приложения.

 

1. Получаемая и используемая информация Пользователей, а также цели ее использования.

            В рамках настоящей Политики конфиденциальности под информацией Пользователя понимается: персональная информация, которую Пользователь самостоятельно предоставляет Paycom™ при создании учетной записи, регистрации, добавлении банковской карты и т.п., а также в процессе использования Приложения (ФИО, пол, адрес электронной почты, номер телефона и т.д.); а также автоматически передаваемые данные в процессе использования Приложения, в том числе, но не ограничиваясь: IP-адрес, сведения о мобильном устройстве, с которого осуществляется доступ и т.д.

            При использовании Приложения может быть запрошена и получена следующая информация:

            Информация о Пользователе. При создании учетной записи и/или регистрации и добавлении банковской карты, Paycom™ запрашивается информация о пользователе, например, ФИО, пол, дата рождения, адрес электронной почты, номер телефона, а также реквизиты банковской карты или иного электронного средства платежа. Paycom™ также может быть запрошена дополнительная информация.

            В отдельных случаях использования дополнительного функционала Приложения Paycom™ может быть получена информация о контактных данных Пользователя (телефонная и/ или адресная книга, контакты в мобильном устройстве).

            Информация о мобильном устройстве. Paycom™ собираются данные о мобильных устройствах Пользователей, такие как модель мобильного устройства, версия операционной системы, уникальные идентификаторы устройства, а также данные о мобильной сети и номер мобильного телефона. Кроме того, идентификатор устройства и номер мобильного телефона могут быть привязаны к учетной записи Пользователя.

            Информация о местоположении. Сервисы Приложения, поддерживающие функцию географического местоположения мобильного устройства Пользователя, позволяют Paycom™ получать информацию о месте фактического местоположения Пользователя, включая данные GPS, отправляемые мобильным устройством.

            Информация о совершаемых операциях. При совершении операций оплаты товаров и услуг, денежных переводов и прочего, Paycom™ собираются данные о месте, времени и сумме совершенных операций, тип способа оплаты, данные о продавце и/или поставщике услуг, описания причины совершения операции, если таковые имеются, а также иную информацию, связанную с совершением указанных выше операций.

            Информация, полученная Paycom™ от Пользователя, может быть использована Paycom™ для предоставления Пользователю персонализированных сервисов, для таргетирования рекламы партнеров Paycom™ в рамках Приложения, в статистических и исследовательских целях, а также для улучшения Приложения и связанных с ним сервисов Paycom™.

            При использовании информации Пользователей Paycom™ руководствуется настоящей Политикой конфиденциальности, требованиями PCI DSS, а также действующим законодательством Республики Узбекистан и нормами международного права.

 

2. Предоставление информации Пользователя третьим лицам

            Paycom™ не передает полученную от Пользователей информацию третьим лицам за исключением случаев, предусмотренных действующим законодательством Республики Узбекистан или вытекающих из технических особенностей сервисов, предоставляемых Пользователям через Приложение. При этом лица, правомерно получающие информацию о Пользователях в силу технических особенностей сервисов, обязуются соблюдать настоящую Политику, требования PCI DSS, а также нормы действующего законодательства Республики Узбекистан и международного права.

 

3. Меры безопасности, используемые для сохранения конфиденциальности информации

            Paycom™ предпринимаются все возможные меры для обеспечения безопасности и защиты информации Пользователей от несанкционированных попыток доступа, изменения, раскрытия или уничтожения, а также иных видов ненадлежащего использования. В частности, Paycom™ постоянно совершенствуются способы сбора, хранения и обработки данных, включая физические меры безопасности, для противодействия несанкционированному доступу к системам Paycom™. Paycom™ также ограничивается доступ сотрудникам, подрядчикам и агентам к информации Пользователей, предусматривая строгие договорные обязательства в сфере конфиденциальности, за нарушение которых предусмотрены жесткие меры ответственности и штрафные санкции.

            Безопасность использования Приложения также зависит от соблюдения Пользователем рекомендаций по безопасности:

·         Хранить данные учетной записи, такие как логин и пароль, втайне от третьих лиц.

·         Установить на свой компьютер (или мобильное устройство) антивирусное программное обеспечение и регулярно производить его обновление и обновление других используемых программных продуктов (операционной системы и прикладных программ), это может защитить от проникновения вредоносного программного обеспечения.

·         Рекомендуется совершать покупки только с доверенного устройства в целях сохранения конфиденциальности персональных данных и (или) информации о банковской (ом) карте (счете). В случае если покупка совершается с использованием чужого устройства, не рекомендуется сохранять на нем персональные данные и другую информацию, а после завершения всех операций нужно убедиться, что персональные данные и другая информация не сохранились.

            Соблюдение Пользователем рекомендаций Paycom™ позволит обеспечить максимальную сохранность предоставляемой Paycom™ информации, в том числе реквизитов банковской карты Пользователя.',
        ));

        $this->insert('{{%settings}}',array(
            'name' => 'Быстрая продажа',
            'value' => 'Приобрестите сейчас VIP на неделю пакет и получите с возможностью
            оставлять неограниченное количество объявлений в течении 10 дней',
        ));

        $this->insert('{{%settings}}',array(
            'name' => 'Турбо-продажа',
            'value' => 'Приобрестите сейчас VIP на неделю пакет и получите с возможностью
            оставлять неограниченное количество объявлений в течении 10 дней',
        ));

        $this->insert('{{%settings}}',array(
            'name' => 'Премиум-объявления',
            'value' => 'Приобрестите сейчас VIP на неделю пакет и получите с возможностью
            оставлять неограниченное количество объявлений в течении 10 дней',
        ));


        $this->insert('{{%settings}}',array(
            'name' => 'VIP-объявлений',
            'value' => 'Приобрестите сейчас VIP на неделю пакет и получите с возможностью
            оставлять неограниченное количество объявлений в течении 10 дней',
        ));

        $this->insert('{{%settings}}',array(
            'name' => 'Выделение объявлений',
            'value' => 'Приобрестите сейчас VIP на неделю пакет и получите с возможностью
            оставлять неограниченное количество объявлений в течении 10 дней',
        ));

        $this->insert('{{%settings}}',array(
            'name' => 'Поднятие объявлений',
            'value' => 'Приобрестите сейчас VIP на неделю пакет и получите с возможностью
            оставлять неограниченное количество объявлений в течении 10 дней',
        ));

        $this->insert('{{%settings}}',array(
            'name' => 'Продление срока публикации',
            'value' => 'Приобрестите сейчас VIP на неделю пакет и получите с возможностью
            оставлять неограниченное количество объявлений в течении 10 дней',
        ));

        $this->insert('{{%settings}}',array(
            'name' => 'Лимит объявлений',
            'value' => 'Приобрестите сейчас VIP на неделю пакет и получите с возможностью
            оставлять неограниченное количество объявлений в течении 10 дней',
        ));

        $this->insert('{{%settings}}',array(
            'name' => 'Правила проведения сделок',
            'value' => 'Приобрестите сейчас VIP на неделю пакет и получите с возможностью
            оставлять неограниченное количество объявлений в течении 10 дней',
        ));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}
