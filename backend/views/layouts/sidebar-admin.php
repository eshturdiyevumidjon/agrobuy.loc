<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\Menu;
use common\models\Users;

    $model = Users::findOne(Yii::$app->user->identity->id);
?>

<div id="sidebar" class="sidebar sidebar-transparent" >
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;">
            <!-- begin sidebar scrollbar -->
            <div data-scrollbar="true" data-height="100%" style="margin-top: 0px; overflow: hidden; width: auto; height: 100%;" data-init="true">
                <!-- begin sidebar user -->

                <ul class="nav">
                    <li class="nav-profile">
                        <a href="javascript:;" data-toggle="nav-profile">
                            <div class="cover with-shadow"></div>
                            <div class="image">
                                <img src="/admin/img/user-13.jpg" alt="" />
                            </div>
                            <div class="info">
                                <b class="caret pull-right"></b>
                               <?=$model->fio?>
                                <small><?= Users::getPerDescription($model->type);?></small>
                            </div>
                        </a>
                    </li>
                    <li>
                        <ul class="nav nav-profile">
                            <li><?= Html::a('<i class="fa fa-cogs"></i> Изменит Профиль', ['/users/profile'], []); ?></li>
                            <li><?= Html::a(
                                    '<i class="fa fa-sign-out"></i>Выйти',
                                    ['/site/logout'], 
                                    ['data-method' => 'post',]   
                                ) ?></li>
                        </ul>
                    </li>
                </ul>
                <!-- end sidebar user -->
                <!-- begin sidebar nav -->
                
                <?= Menu::widget(
            [
                'options' => ['class' => 'nav'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'nav-header']],
                    
                    ['label' => 'Домашняя страница', 'icon' => 'dashboard', 'url' => ['/site']],
                    ['label' => 'Пользователи', 'icon' => 'user', 'url' => ['/users']],
                    ['label' => 'Объявление', 'icon' => 'university', 'url' => ['/ads']],
                    // ['label' => 'Группы', 'icon' => 'users', 'url' => ['/groups/index']],
                    // ['label' => 'Тарифы', 'icon' => 'bar-chart-o', 'url' => ['/tariffs/index']],
                    // ['label' => 'Курсы', 'icon' => 'table', 'url' => ['/courses/index'],],
                    ['label' => 'Новосты', 'icon' => 'bookmark', 'url' => ['/news'],],
                    ['label' => 'Баннеры', 'icon' => 'bars', 'url' => ['/banners'],],
                    // ['label' => 'Уведомления', 'icon' => 'bell', 'url' => ['/alerts/index'],],
                    ['label' => 'Рекламные баннеры', 'icon' => 'send', 'url' => ['/advertisings'],],
                    ['label' => 'Справочники', 'icon' => 'book', 'url' => ['/nothealth'],

                        'items' => [
                            ['label' => 'Продвижения', 'icon' => 'tags', 'url' => ['/promotions'],],
                            ['label' => 'Категория', 'icon' => 'book', 'url' => ['/categories'],],
                            ['label' => 'Настройки', 'icon' => 'book', 'url' => ['/settings'],],
                            ['label' => 'Суммы пополнение счета', 'icon' => 'fas fa-th-list', 'url' => ['/price-list'],],
                            ['label' => 'Языки', 'icon' => 'language', 'url' => ['/language'],],
                        ],
                    ] ,
                     ['label' => 'О компаниях', 'icon' => 'university', 'url' => ['/about-company/view','id'=>1],],
                ],
            ]
        ) ?>
            <li style="list-style: none;"><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
                <!-- end sidebar nav -->
            </div>
            <!-- end sidebar scrollbar -->
    </div>
</div>
        <div class="sidebar-bg"></div>