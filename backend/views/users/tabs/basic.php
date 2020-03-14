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

<?php Pjax::begin(['enablePushState' => false, 'id' => 'crud-datatable-pjax']); ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('<i class="fa fa-pencil"></i>', ['/users/change-personal?id='.$model->id.'&type=1'],['role'=>'modal-remote','title'=> 'Изменить', 'class' => 'btn-sm btn-icon btn-circle btn-info'])?>
             <?=Html::a('Назад', ['/users'],['data-pjax'=>'0','title'=> 'Назад', 'class' => ' btn-warning btn btn-xs'])?>
        </div>
        <h4 class="panel-title"><b>Личные данные</b></h4>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
        <tr>
            <td rowspan="6">
                <?=Html::img($path, ['style' => 'width:150px; height:150px;object-fit: cover;', 'class'=>'img-circle',])?>
            </td>
            <th><?=Yii::t('app', 'Fio')?></th>
            <td><?=$model->fio?></td>
            <th><?=Yii::t('app', 'Type')?></th>
            <td><?=$model->getTypeDescription()?></td>
        </tr>
        <tr>
            <th><?=Yii::t('app', 'Birthday')?></th>
            <td><?=$model->birthday?></td>
            <th><?=Yii::t('app', 'Login ')?></th>
            <td><?=$model->login?></td>
        </tr>
        <tr>
            <th><?=Yii::t('app', 'Phone')?></th>
            <td><?=$model->phone?></td>
            <th>Доступ</th>
            <td><?=$model->getAccessType()[$model->access]?></td>
        </tr>
        <tr>
            <th><?=Yii::t('app', 'E-mail')?></th>
            <td><?=$model->email?></td>
            <th><?=Yii::t('app', 'Telegram')?></th>
            <td><?=$model->telegram?></td>
        </tr>
        <tr>
            <th><?=Yii::t('app', 'Instagram')?></th>
            <td><?=$model->instagram?></td>
            <th><?=Yii::t('app', 'Web Site')?></th>
            <td><?=$model->web_site?></td>
        </tr>
        <tr>
            <th><?=Yii::t('app', 'Facebook')?></th>
            <td><?=$model->facebook?></td>
        </tr>
        </table>
    </div>
</div>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('<i class="fa fa-pencil"></i>', ['/users/change-personal?id='.$model->id.'&type=2'],['role'=>'modal-remote','title'=> 'Изменить', 'class' => 'btn-sm btn-icon btn-circle btn-info'])?>
             
        </div>
        <h4 class="panel-title"><b>Юридический статус</b></h4>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th>Юридический статус</th>
                <td><?=$model->getLegal()[$model->legal_status]?></td>
            </tr>        
        </table>
    </div>
</div>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('<i class="fa fa-pencil"></i>', ['/users/change-personal?id='.$model->id.'&type=3'],['role'=>'modal-remote','title'=> 'Изменить', 'class' => 'btn-sm btn-icon btn-circle btn-info'])?>
        </div>
        <h4 class="panel-title"><b>Паспортные данные</b></h4>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th><?=Yii::t('app', 'Passport Serial Number')?></th>
                <td><?=$model->passport_serial_number?></td>
                <th><?=Yii::t('app', 'Passport Number')?></th>
                <td><?=$model->passport_number?></td>
            </tr>
            <tr>
                <th><?=Yii::t('app', 'Birthday')?></th>
                <td><?=$model->birthday?></td>
                <th><?=Yii::t('app', 'Passport Date')?></th>
                <td><?=$model->passport_date?></td>
            </tr>
            <tr>
                <th><?=Yii::t('app', 'Passport Issue')?></th>
                <td><?=$model->passport_issue?></td>
                <th><?=Yii::t('app', 'Passport File ')?></th>
                <td><?=Html::a('Скачать', ['/users/download-passport?id='.$model->id],['data-pjax'=>'0','title'=> 'Скачать', 'class' => 'btn-sm btn-warning'])?></td>
            </tr>        
        </table>
    </div>
</div>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('<i class="fa fa-pencil"></i>', ['/users/change-personal?id='.$model->id.'&type=4'],['role'=>'modal-remote','title'=> 'Изменить', 'class' => 'btn-sm btn-icon btn-circle btn-info'])?>
        </div>
        <h4 class="panel-title"><b>Данные о физ./юр.лисе</b></h4>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th><?=Yii::t('app', 'Inn')?></th>
                <td><?=$model->inn?></td>
            </tr>
        </table>
    </div>
</div>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('<i class="fa fa-pencil"></i>', ['/users/change-personal?id='.$model->id.'&type=5'],['role'=>'modal-remote','title'=> 'Изменить', 'class' => 'btn-sm btn-icon btn-circle btn-info'])?>
        </div>
        <h4 class="panel-title"><b>Заявка на добавление компании</b></h4>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th><?=Yii::t('app', 'Company Name')?></th>
                <td><?=$model->company_name?></td>
                <th><?=Yii::t('app', 'Company Files')?></th>
                <td><?=$model->company_files?></td>
            </tr>        
        </table>
    </div>
</div>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('<i class="fa fa-pencil"></i>', ['/users/change-personal?id='.$model->id.'&type=6'],['role'=>'modal-remote','title'=> 'Изменить', 'class' => 'btn-sm btn-icon btn-circle btn-info'])?>
        </div>
        <h4 class="panel-title"><b>Доступы</b></h4>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <tr>
                <th>Проверка телефона</th>
                <td><?=$model->check_phone == 1 ? 'Да' : 'Нет'?></td>
                <th>Проверка почту</th>
                <td><?=$model->check_mail == 1 ? 'Да' : 'Нет'?></td>
                <th>Instagram</th>
                <td><?=$model->instagram != null ? 'Да' : 'Нет'?></td>
                <th>Facebook</th>
                <td><?=$model->facebook != null ? 'Да' : 'Нет'?></td>
            </tr>
            <tr>
                <th>Проверка паспорта</th>
                <td><?=$model->check_passport == 1 ? 'Да' : 'Нет'?></td>
                <th>Проверка машины</th>
                <td><?=$model->check_car == 1 ? 'Да' : 'Нет'?></td>
                <th>Telegram</th>
                <td><?=$model->telegram != null ? 'Да' : 'Нет'?></td>
                <th>Web Site</th>
                <td><?=$model->web_site != null ? 'Да' : 'Нет'?></td>
            </tr>
        </table>
    </div>
</div>
<?php Pjax::end(); ?>
