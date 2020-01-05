<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use yii\widgets\Pjax;

$this->title = "Карточка объявлении";
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);
?>

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#default-tab-1" data-toggle="tab" aria-expanded="true">Информация</a></li>
            <li class=""><a href="#default-tab-2" data-toggle="tab" aria-expanded="false">Жалобы</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="default-tab-1">
                <?= $this->render('information', [
                    'model' => $model,
                ]) ?>
            </div>
            <div class="tab-pane fade" id="default-tab-2">
                <?= $this->render('complaints', [
                    'complaintsProvider' => $complaintsProvider,
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