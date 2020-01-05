<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\PreferenceBooks;

?>

<?php Pjax::begin(['enablePushState' => false, 'id' => 'crud-datatable-pjax']); ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('<i class="fa fa-pencil"></i>', ['/ads/update?id='.$model->id],['role'=>'modal-remote','title'=> 'Изменить', 'class' => 'btn-sm btn-icon btn-circle btn-info'])?>
            <?=Html::a('Назад', ['/ads'],['data-pjax'=>'0','title'=> 'Назад', 'class' => ' btn-warning btn btn-xs'])?>
        </div>
        <h4 class="panel-title"><b>Личные данные</b></h4>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
        <tr>
            <td rowspan="6" style="width: 350px;"><?=$model->getImage()?></td>
            <th><?=$model->getAttributeLabel('type')?></th>
            <td><?=$model->getType()[$model->type]?></td>
            <th><?=$model->getAttributeLabel('title')?></th>
            <td><?=$model->title?></td>
        </tr>
        <tr>
            <th><?=$model->getAttributeLabel('category_id')?></th>
            <td><?=$model->getCategoryList()[$model->category_id]?></td>
            <th><?=$model->getAttributeLabel('subcategory_id')?></th>
            <td><?=$model->getSubcategoryList()[$model->subcategory_id]?></td>
        </tr>
         
        <tr>
            <th><?=$model->getAttributeLabel('city_name')?></th>
            <td><?=$model->city_name?></td>
            <th><?=$model->getAttributeLabel('date_cr')?></th>
            <td><?=PreferenceBooks::getDateTime($model->date_cr)?></td>
        </tr>
        <tr>
            <th><?=$model->getAttributeLabel('price')?></th>
            <td><?=$model->price?></td>
            <th><?=$model->getAttributeLabel('old_price')?></th>
            <td><?=$model->old_price?></td>
        </tr>
        <tr>
            <th><?=$model->getAttributeLabel('unit_price')?></th>
            <td><?=$model->unit_price?></td>
            <th><?=$model->getAttributeLabel('treaty')?></th>
            <td><?=$model->getTreaty()[$model->treaty]?></td>
        </tr>
        <tr>
            <th><?=$model->getAttributeLabel('text')?></th>
            <td colspan="3"><?=$model->text?></td>
        </tr>
        </table>
    </div>
</div>

<?php Pjax::end(); ?>
