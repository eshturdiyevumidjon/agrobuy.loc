<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use yii\widgets\Pjax;

$this->title = "Карточка пользователя";
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#default-tab-1" data-toggle="tab" aria-expanded="true">Информация</a></li>
            <li class=""><a href="#default-tab-2" data-toggle="tab" aria-expanded="false">Продвижение</a></li>
            <li class=""><a href="#default-tab-3" data-toggle="tab" aria-expanded="false">Каталог пользователя</a></li>
            <li class=""><a href="#default-tab-4" data-toggle="tab" aria-expanded="false">История оплат</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="default-tab-1">
                <?= $this->render('tabs/basic', [
                    'model' => $model,
                ]) ?>
            </div>
            <div class="tab-pane fade" id="default-tab-2">
                <?= $this->render('tabs/promotions', [
                    'promotions' => $promotions,
                ]) ?>
            </div>
            <div class="tab-pane fade" id="default-tab-3">
                <?= $this->render('tabs/catalog', [
                    'catalogProvider' => $catalogProvider,
                ]) ?>
            </div>
            <div class="tab-pane fade" id="default-tab-4">
                <?= $this->render('tabs/history_payment', [
                    'histories' => $histories,
                ]) ?>
            </div>
        </div>
    </div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "options" => [
        "tabindex" => false,
    ],
    "footer"=>"",
])?>
<?php Modal::end(); ?>