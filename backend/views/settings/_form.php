<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\Settings */
/* @var $form yii\widgets\ActiveForm */

$i=0;
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
                <p>
                  <br>
                    <?php if($lang->url=='ru'): ?>
                         <div class="row">
                     <?= $form->field($model, 'name')->textInput()->label(Yii::t('app','Title',null/*,$lang->url*/)) ?>
                     <?= $form->field($model, 'value')->widget(CKEditor::className(),[
                        'editorOptions' => [
                            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                            'inline' => false, //по умолчанию false
                        ],
                    ]);?>
                    </div>
                    <?php else: ?>
                        <div class="row">
                     <?= $form->field($model, 'translation_name['.$lang->url.']')->textInput(['value'=>$names[$lang->url]])->label(Yii::t('app','Title'/*,null,$lang->url*/)) ?>
                     <?= $form->field($model, 'translation_value['.$lang->url.']')->widget(CKEditor::className(),[
                        'options'=>[
                          'value'=> $values[$lang->url],
                        ],
                        'editorOptions' => [
                            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                            'inline' => false, //по умолчанию false
                        ],
                    ])->label(Yii::t('app','Text'/*,null,$lang->url*/));?>
                    
                    </div>
                    <?php endif;?>    
                    
                </p>
             </div>
            <?php $i++; endforeach;?>
          </div>
        <?= $form->field($model, 'priority')->textInput() ?>
        <?= $form->field($model, 'view_in_footerser_id')->textInput() ?>
      </div>
    </div>
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
</div>
