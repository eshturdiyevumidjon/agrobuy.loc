<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

$i = 0;
$langs=backend\models\Lang::getLanguages();

?>
<div class="settings-form">
    <?php $form = ActiveForm::begin([ 'options' => ['method' => 'post', 'enctype' => 'multipart/form-data','id'=>'settings-create-form']]); ?>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills" style="margin-top:2px;">
                <?php foreach($langs as $lang):?>
                <li class="<?=($i==0)?'active':''?>">
                    <a data-toggle="tab" href="#<?=$lang->url?>"><?=(isset(explode('-',$lang->name)[1])?explode('-',$lang->name)[1]:$lang->name)?></a>
                </li>
                <?php $i++; endforeach;?>
            </ul>
         <div class="tab-content">
            <?php $i=0; foreach($langs as $lang):?>
                <div id="<?=$lang->url?>" class="tab-pane fade <?=($i==0)?'in active':''?>">
                    <?php if($lang->url != 'kr'): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'translation_name['.$lang->url.']')->textInput(['value'=>$names[$lang->url]])->label(Yii::t('app','Title')) ?>
                            </div>                     
                            <div class="col-md-12">
                                <?= $form->field($model, 'translation_value['.$lang->url.']')->widget(CKEditor::className(),[
                                        'options'=>[
                                        'value'=> $values[$lang->url],
                                     ],
                                    'editorOptions' => [
                                        'filebrowserUploadUrl' => '/admin/settings/ckeditor_image_upload',
                                        'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную     возможность не обязательно использовать
                                        'inline' => false, //по умолчанию false
                                    ],
                                ])->label(Yii::t('app','Text'/*,null,$lang->url*/));?> 
                            </div>                   
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'name')->textInput()->label(Yii::t('app','Title',null)) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'priority')->textInput(['type' => 'number']) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'view_in_footerser_id')->dropDownList($model->getView(), [ 'prompt' => 'Выберите ...',]) ?>
                            </div>
                            <div class="col-md-12">
                                <?= $form->field($model, 'value')->widget(CKEditor::className(),[
                                    'editorOptions' => [
                                        'filebrowserUploadUrl' => '/admin/settings/ckeditor_image_upload',
                                        'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                        'inline' => false, //по умолчанию false
                                    ],
                                ]);?>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            <?php $i++; endforeach;?>
            </div>
        </div>
    </div>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?=Html::a('Назад', ['/settings'],['data-pjax'=>'0','title'=> 'Назад', 'class' => ' btn-warning btn btn-primary'])?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
</div>
