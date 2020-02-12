<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <h2><span><?= Yii::t('app',"Foydalanuvchini baholash") ?></span></h2>

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'ball')
            ->radioList([
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
            ],
            ['class' => 'your_class', 'id' => 'your_id'])->label(false); ?>

        <button type="submit" class="btn-template"><?= Yii::t('app',"Saqlash") ?></button>

    <?php ActiveForm::end(); ?>