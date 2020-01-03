<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\PreferenceBooks;

?>
<?php Pjax::begin(['enablePushState' => false, 'id' => 'history-payment-pjax']); ?>
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
                    <th>№</th>
                    <th>Тип</th>
                    <th>Описания</th>
                    <th>Дата и время</th>
                    <th>Сумма</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; foreach ($histories as $history) { $i++; ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $history->getTypeDescription()?></td>
                    <td><?= $history->getDescription()?></td>
                    <td><?= PreferenceBooks::getDateTime($history->date_cr)?></td>
                    <td><?= $history->summa?></td>
                </tr>
                <?php } ?>
            </tbody>         
        </table>
    </div>
</div>
<?php Pjax::end(); ?>
