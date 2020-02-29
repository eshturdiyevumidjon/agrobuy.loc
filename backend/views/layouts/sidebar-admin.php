<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\Menu;
use common\models\Ads;
use common\models\Users;

    $model = Users::findOne(Yii::$app->user->identity->id);
    $adsCount = Ads::find()->where(['is_checked' => 0])->count();
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
                
            <?= Menu::widget([
                'options' => ['class' => 'nav'],
                'encodeLabels' => false,
                'items' => [
                    //['label' => 'Меню', 'options' => ['class' => 'nav-header']],
                    ['label' => 'Главная страница', 'icon' => 'dashboard', 'url' => ['/site'], 'active' => $this->context->id == 'site'],
                    ['label' => 'Пользователи', 'icon' => 'user', 'url' => ['/users'], 'active' => $this->context->id == 'users'],
                    ['label' => 'Объявления' . Html::tag('span', $adsCount, ['class' => 'pull-right badge badge-danger', 'style' => 'background: #ff5b57 !important;']), 'icon' => 'file-sound-o', 'url' => ['/ads'], 'active' => $this->context->id == 'ads'],
                    // ['label' => 'Курсы', 'icon' => 'table', 'url' => ['/courses'],],
                    ['label' => 'Новости', 'icon' => 'bookmark', 'url' => ['/news'], 'active' => $this->context->id == 'news'],
                    ['label' => 'Слайдеры', 'icon' => 'bars', 'url' => ['/banners'], 'active' => $this->context->id == 'banners'],
                    ['label' => 'Рекламные баннеры', 'icon' => 'photo ', 'url' => ['/advertisings'], 'active' => $this->context->id == 'advertisings'],
                    ['label' => 'Чат и рассылка', 'icon' => 'send', 'url' => ['/chats']],
                    ['label' => 'Справочники', 'icon' => 'book', 'url' => ['/nothealth'], 'active' => $model->getActiveMenu($this->context->id),
                        'items' => [
                            ['label' => 'Валюты', 'icon' => 'dollar', 'url' => ['/currency'], 'active' => $this->context->id == 'currency'],
                            ['label' => 'Платные услуги', 'icon' => 'tags', 'url' => ['/promotions'], 'active' => $this->context->id == 'promotions'],
                            ['label' => 'Категории', 'icon' => 'book', 'url' => ['/categories'], 'active' => $this->context->id == 'categories'],
                            ['label' => 'Регионы', 'icon' => 'book', 'url' => ['/regions'], 'active' => $this->context->id == 'regions'],
                            ['label' => 'Ссылки подвала сайта', 'icon' => 'book', 'url' => ['/settings'], 'active' => $this->context->id == 'settings'],
                            ['label' => 'Настройки пополнения счета', 'icon' => 'fas fa-th-list', 'url' => ['/price-list'], 'active' => $this->context->id == 'price-list'],
                            ['label' => 'Языки', 'icon' => 'language', 'url' => ['/language'], 'active' => $this->context->id == 'language'],
                        ],
                    ],
                    ['label' => 'О компании', 'icon' => 'university', 'url' => ['/about-company/view','id'=>1], 'active' => $this->context->id == 'about-company'],
                ],
            ]) ?>

            <li style="list-style: none;"><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
                <!-- end sidebar nav -->
            </div>
            <!-- end sidebar scrollbar -->
    </div>
</div>
        <div class="sidebar-bg"></div>