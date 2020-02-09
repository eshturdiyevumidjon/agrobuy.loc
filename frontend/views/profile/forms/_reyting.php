<?php

use yii\helpers\Html;

?>
<div class="edit-item">
    <div class="title-edit"><?=Yii::t('app', "Reyting")?></div>
        <div class="edit-item-body">
            <table class="table">
                <thead>
                    <tr>
                        <th><?=Yii::t('app', "Hisoblash sababi")?></th>
                        <th><?=Yii::t('app', "Hisoblash formulasi")?></th>
                        <th><?=Yii::t('app', "Reyting")?></th>
                    </tr>
                </thead>
                <tbody>
                <?php $reyting = 0; foreach ($usersReyting as $userRey) { $reyting += $userRey->ball;?>
                    <tr>
                        <td><?=$userRey->reyting->name?></td>
                        <td><?='+' . $userRey->reyting->value . ' / ' . $userRey->reyting->value . ' ' . $userRey->reyting->getUnit()[$userRey->reyting->unit_id]?></td>
                        <td><?=$userRey->ball?></td>
                    </tr>
                <?php } ?>
                    <tr>
                        <td colspan="2"><b><?=Yii::t('app', "Jami")?>:</b></td>
                        <td><b><?=$reyting?></b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>