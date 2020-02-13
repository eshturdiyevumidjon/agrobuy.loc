<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <!-- <form class="edit-item"> -->
    <?php $form = ActiveForm::begin(['id' => '_personal', /*'action' => 'personal',*/ 'options' => ['method' => 'post', 'class' => 'edit-item', ]]); ?>
        <div class="title-edit"><?=Yii::t('app', "Shaxsiy ma'lumot")?></div>
        <div class="edit-item-body">
            <div class="row">
                <div class="col-lg-6 inpt-min">
                    <!-- <div class="form-group"> -->
                        <!-- <label for=""><?php //Yii::t('app', "F.I.O.")?></label> -->
                        <!-- <input type="text" name="" class="form-control"> -->
                    <!-- </div> -->
                    <!-- <div class="form-group">
                        <label for=""><?php //Yii::t('app', "Tug'ilgan kun")?></label>
                        <input type="text" class="form-control datetimepicker hasDatepicker" id="datet" placeholder="01.01.2019">
                    </div>
                    <div class="form-group">
                        <label for=""><?php //Yii::t('app', "Telefon nomer")?></label>
                        <input type="tel" placeholder="+998 67 987 56 87" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for=""><?php //Yii::t('app', "E-mail")?></label>
                        <input type="email" class="form-control">
                    </div> -->
                    <?= $form->field($model, 'fio')->textInput(['class' => 'form-control'])->label(Yii::t('app', "F.I.O.")) ?>
                    <?= $form->field($model, 'birthday')->textInput(['class' => 'form-control datetimepicker hasDatepicker', 'id'=>"datet"])->label(Yii::t('app', "Tug'ilgan kun")) ?>
                    <?= $form->field($model, 'phone')->textInput(['class' => 'form-control', 'placeholder'=>"+998 99 999 99 99"])->label(Yii::t('app', "Telefon nomer")) ?>
                    <?= $form->field($model, 'email')->textInput(['class' => 'form-control'])->label(Yii::t('app', "E-mail")) ?>
                </div>
                <div class="col-lg-6 input-social">
                    <?= $form->field($model, 'instagram')->textInput(['class' => 'form-control'])->label('<svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <path d="M352,0H160C71.648,0,0,71.648,0,160v192c0,88.352,71.648,160,160,160h192c88.352,0,160-71.648,160-160V160    C512,71.648,440.352,0,352,0z M464,352c0,61.76-50.24,112-112,112H160c-61.76,0-112-50.24-112-112V160C48,98.24,98.24,48,160,48    h192c61.76,0,112,50.24,112,112V352z"></path>
                                <path d="m256 128c-70.688 0-128 57.312-128 128s57.312 128 128 128 128-57.312 128-128-57.312-128-128-128zm0 208c-44.096 0-80-35.904-80-80 0-44.128 35.904-80 80-80s80 35.872 80 80c0 44.096-35.904 80-80 80z"></path>
                                <circle cx="393.6" cy="118.4" r="17.056"></circle>
                            </svg>') ?>
                    <?= $form->field($model, 'web_site')->textInput(['class' => 'form-control'])->label('<svg enable-background="new 0 0 58 58" version="1.1" viewBox="0 0 58 58" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <path d="m50.688 48.222c4.544-5.121 7.312-11.853 7.312-19.222 0-7.667-2.996-14.643-7.872-19.834v-1e-3c-4e-3 -6e-3 -0.01-8e-3 -0.013-0.013-5.079-5.399-12.195-8.855-20.11-9.126l-1e-3 -1e-3 -0.565-0.015c-0.146-5e-3 -0.292-0.01-0.439-0.01s-0.293 5e-3 -0.439 0.01l-0.563 0.015-1e-3 1e-3c-7.915 0.271-15.031 3.727-20.11 9.126-4e-3 5e-3 -0.01 7e-3 -0.013 0.013 0 0 0 1e-3 -1e-3 2e-3 -4.877 5.19-7.873 12.166-7.873 19.833 0 7.369 2.768 14.101 7.312 19.222 6e-3 9e-3 6e-3 0.019 0.013 0.028 0.018 0.025 0.044 0.037 0.063 0.06 5.106 5.708 12.432 9.385 20.608 9.665l1e-3 1e-3 0.563 0.015c0.147 4e-3 0.293 9e-3 0.44 9e-3s0.293-5e-3 0.439-0.01l0.563-0.015 1e-3 -1e-3c8.185-0.281 15.519-3.965 20.625-9.685 0.013-0.017 0.034-0.022 0.046-0.04 8e-3 -8e-3 8e-3 -0.018 0.014-0.027zm-48.663-18.222h12.003c0.113 4.239 0.941 8.358 2.415 12.217-2.844 1.029-5.563 2.409-8.111 4.131-3.747-4.457-6.079-10.138-6.307-16.348zm6.853-18.977c2.488 1.618 5.137 2.914 7.9 3.882-1.692 4.107-2.628 8.535-2.75 13.095h-12.003c0.239-6.507 2.787-12.432 6.853-16.977zm47.097 16.977h-12.003c-0.122-4.56-1.058-8.988-2.75-13.095 2.763-0.968 5.412-2.264 7.9-3.882 4.066 4.545 6.614 10.47 6.853 16.977zm-27.975-13.037c-2.891-0.082-5.729-0.513-8.471-1.283 2.027-4.158 4.889-7.911 8.471-11.036v12.319zm0 2v11.037h-11.972c0.123-4.348 1.035-8.565 2.666-12.475 3.006 0.871 6.127 1.353 9.306 1.438zm2 0c3.179-0.085 6.3-0.566 9.307-1.438 1.631 3.91 2.543 8.127 2.666 12.475h-11.973v-11.037zm0-2v-12.319c3.582 3.125 6.444 6.878 8.471 11.036-2.742 0.77-5.58 1.201-8.471 1.283zm10.409-1.891c-1.921-4.025-4.587-7.692-7.888-10.835 5.856 0.766 11.125 3.414 15.183 7.318-2.304 1.462-4.748 2.638-7.295 3.517zm-22.818 0c-2.547-0.879-4.991-2.055-7.294-3.517 4.057-3.904 9.327-6.552 15.183-7.318-3.302 3.143-5.968 6.81-7.889 10.835zm-1.563 16.928h11.972v10.038c-3.307 0.088-6.547 0.604-9.661 1.541-1.407-3.655-2.198-7.56-2.311-11.579zm11.972 12.038v13.318c-3.834-3.345-6.84-7.409-8.884-11.917 2.867-0.845 5.845-1.315 8.884-1.401zm2 13.318v-13.318c3.039 0.085 6.017 0.556 8.884 1.4-2.044 4.509-5.05 8.573-8.884 11.918zm0-15.318v-10.038h11.972c-0.113 4.019-0.904 7.924-2.312 11.58-3.113-0.938-6.353-1.454-9.66-1.542zm13.972-10.038h12.003c-0.228 6.21-2.559 11.891-6.307 16.348-2.548-1.722-5.267-3.102-8.111-4.131 1.475-3.859 2.302-7.978 2.415-12.217zm-34.281 17.846c2.366-1.572 4.885-2.836 7.517-3.781 1.945 4.36 4.737 8.333 8.271 11.698-6.151-0.805-11.656-3.685-15.788-7.917zm22.83 7.917c3.534-3.364 6.326-7.337 8.271-11.698 2.632 0.945 5.15 2.209 7.517 3.781-4.132 4.232-9.637 7.112-15.788 7.917z"></path>
                            </svg>') ?>
                    <?= $form->field($model, 'facebook')->textInput(['class' => 'form-control'])->label('<svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <path d="M288,176v-64c0-17.664,14.336-32,32-32h32V0h-64c-53.024,0-96,42.976-96,96v80h-64v80h64v256h96V256h64l32-80H288z"></path>
                            </svg>') ?>
                    <?= $form->field($model, 'telegram')->textInput(['class' => 'form-control'])->label('<svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m9.417 15.181-.397 5.584c.568 0 .814-.244 1.109-.537l2.663-2.545 5.518 4.041c1.012.564 1.725.267 1.998-.931l3.622-16.972.001-.001c.321-1.496-.541-2.081-1.527-1.714l-21.29 8.151c-1.453.564-1.431 1.374-.247 1.741l5.443 1.693 12.643-7.911c.595-.394 1.136-.176.691.218z"></path></svg>') ?>
                </div>
                <div class="col-lg-12 col-sm-12 col-12 text-right">
                    <!-- <button type="submit" class="btn-template"><?= Yii::t('app',"Saqlash") ?></button> -->
                    <?= Html::submitButton(Yii::t('app',"Saqlash"), ['class' => 'btn-template']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>