<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use yii\widgets\Pjax;

$this->title = "Карточка пользователя";
//$this->params['breadcrumbs']['users'] = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

if (!file_exists('uploads/avatars/' . $model->avatar) || $model->avatar == null) {
    $path = 'http://' . $_SERVER['SERVER_NAME'].'/backend/web/img/nouser.png';
} else {
    $path = 'http://' . $_SERVER['SERVER_NAME'].'/backend/web/uploads/avatars/'.$model->avatar;
}

?>

<div class="row">
    <div class="col-md-12">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#default-tab-1" data-toggle="tab" aria-expanded="true">Информация</a></li>
            <li class=""><a href="#default-tab-2" data-toggle="tab" aria-expanded="false">Default Tab 2</a></li>
            <li class=""><a href="#default-tab-3" data-toggle="tab" aria-expanded="false">Default Tab 3</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade active in" id="default-tab-1">
              <?= $this->render('basic', [
                'model' => $model,
                ]) ?>
            </div>
            <div class="tab-pane fade" id="default-tab-2">
              
            </div>
            <div class="tab-pane fade" id="default-tab-3">
              
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