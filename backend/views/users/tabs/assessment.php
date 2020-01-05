<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\PreferenceBooks;

$ball = 0;
foreach ($assessment as $assess) {
    $ball += $assess->ball;
}
if(count($assessment) > 0) $average = $ball / count($assessment);
else $average = 0;
?>
<?php Pjax::begin(['enablePushState' => false, 'id' => 'assessment-pjax']); ?>
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?=Html::a('Назад', ['/users'],['data-pjax'=>'0','title'=> 'Назад', 'class' => ' btn-warning btn btn-xs'])?>
        </div>
        <h4 class="panel-title"><b>Список</b></h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <h2>Оценка пользователья : <span style="color: red; font-weight: bold;"><?= $average ?> балл</span></h2>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Пользователь</th>
                    <th>Балл</th>
                    <th>Дата и время</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; foreach ($assessment as $assess) { $i++; ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $assess->userFrom->fio?></td>
                    <td><?= $assess->ball?></td>
                    <td><?= PreferenceBooks::getDateTime($assess->date_cr)?></td>
                </tr>
                <?php } ?>
            </tbody>         
        </table>
    </div>
</div>
<?php Pjax::end(); ?>
