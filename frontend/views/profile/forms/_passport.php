<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <?php $form = ActiveForm::begin(['id' => '_passport', 'options' => ['method' => 'post', 'class' => 'edit-item', ]]); ?>
            <div class="title-edit"><?=Yii::t('app', "Pasport ma'lumotlari")?></div>
            <div class="edit-item-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6">
                                <?= $form->field($model, 'passport_serial_number', ['options' => ['class' => 'form-group inpt-min']])->widget(\yii\widgets\MaskedInput::className(), [
                                    'mask' => 'AA',
                                    'class' => 'form-control',
                                ])->label(Yii::t('app', "Pasport seriyasi")) ?>
                            </div>
                            <div class="col-lg-6">
                                <?= $form->field($model, 'passport_number')->widget(\yii\widgets\MaskedInput::className(), [
                                    'mask' => '9999999',
                                    'class' => 'form-control',
                                ])->label(Yii::t('app', "Pasport nomeri")) ?>
                            </div>
                        </div>
                        <?= $form->field($model, 'passport_date', ['options' => ['class' => 'form-group inpt-min']])->textInput(['class' => 'form-control datetimepicker hasDatepicker', 'id'=>"dp1580923370520"])->label(Yii::t('app', "Berilgan vaqti")) ?>
                        <?= $form->field($model, 'passport_issue', ['options' => ['class' => 'form-group inpt-min']])->textInput(['class' => 'form-control',])->label(Yii::t('app', "Kim tomonidan berilgan")) ?>             
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-lg-12">
                        <div class="attach inpt-min ">
                            <label for="rad">Прикрепить <br> фото</label>
                            <span class="multiple-photos">
                                Можно загрузить несколько фото <button class="fileinput-button dz-clickable"></button>
                            </span>
                        </div> 
                    </div>
                    <div class="col-xl-3 col-lg-6 attach fda-rew">
                        <a href="#">Прикрепить файл</a>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-12 col-12 text-right">
                        <?= Html::submitButton(Yii::t('app',"Saqlash"), ['class' => 'btn-template']) ?>
                    </div>
                    <div class="col-12">
                        <div class="dropzone-body">
                            <!-- HTML heavily inspired by https://blueimp.github.io/jQuery-File-Upload/ -->
                            <div id="actions" class="row" style="display: none;">
                                <div class="col-lg-7">
                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn btn-success fileinput-button dz-clickable">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Add files...</span>
                                    </span>
                                    <button type="submit" class="btn btn-primary start">
                                        <i class="glyphicon glyphicon-upload"></i>
                                        <span>Start upload</span>
                                    </button>
                                    <button type="reset" class="btn btn-warning cancel">
                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                        <span>Cancel upload</span>
                                    </button>
                                </div>

                                <div class="col-lg-5">
                                    <!-- The global file processing state -->
                                    <span class="fileupload-process">
                                        <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="files" id="previews">
                          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php ActiveForm::end(); ?>