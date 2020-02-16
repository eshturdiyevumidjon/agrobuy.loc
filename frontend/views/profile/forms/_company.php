<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <?php $form = ActiveForm::begin(['id' => '_company', 'options' => ['method' => 'post', 'class' => 'edit-item', 'autocomplete'=>"off"]]); ?>
        <div class="title-edit"><?=Yii::t('app', "Kompaniyani qo'shish uchun ariza")?></div>
        <div class="edit-item-body">
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'company_name', ['options' => ['class' => 'form-group inpt-min']])->textInput(['class' => 'form-control'])->label(Yii::t('app', "Kompaniya nomi")) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-xl-6">
                    <div class="attach inpt-min ">
                        <label for="rad">Прикрепить <br> фото</label>
                        <span class="multiple-photos">
                            Можно загрузить несколько фото <button class="fileinput-button dz-clickable"></button>
                        </span>
                    </div> 
                </div>
                <div class="col-lg-4 col-xl-6 attach fda-rew">
                    <a href="#">Прикрепить файл</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-xl-9">
                    <div class="main-list-of-required">
                        <p><span><?=Yii::t('app', "Kerakli fayllar ro'yxati")?></span> <img src="/images/right-arrow-green.png" alt=""></p>
                        <ul style="display: none;">
                            <li>ИНН</li>
                            <li>Свидетельство о регистрации Юр лица</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3 col-sm-12 col-12 text-right">
                    <?= Html::submitButton(Yii::t('app',"So'rov yuborish"), ['class' => 'btn-template']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>