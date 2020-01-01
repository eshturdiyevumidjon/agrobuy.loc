<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<?php Pjax::begin(['enablePushState' => false, 'id' => 'promotion-pjax']); ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('Назад', ['/users'],['data-pjax'=>'0','title'=> 'Назад', 'class' => ' btn-warning btn btn-xs'])?>
        </div>
        <h4 class="panel-title"><b>Список</b></h4>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Продвижение</th>
                    <th>Срок окончание</th>
                    <th>Дата создание</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($promotions as $promotion) { ?>
                <tr>
                    <td><?=$promotion->promotion->name?></td>
                    <td><?=$promotion->user->getDate($promotion->access_date)?></td>
                    <td><?=$promotion->user->getDate($promotion->date_cr)?></td>
                </tr>
                <?php } ?>
            </tbody>         
        </table>
    </div>
</div>
<?php Pjax::end(); ?>
