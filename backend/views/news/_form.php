<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset;
use mihaildev\ckeditor\CKEditor;

$i = 0;
$langs = backend\models\Lang::getLanguages();
CrudAsset::register($this);

?>
<div class="news-form">
    <?php $form = ActiveForm::begin([ 'options' => ['method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'news-create-form']]); ?>
    <div class="row">
        <div class="col-md-3">
            <div class="col-md-12">
                <div id="image">
                    <?=$model->getImage()?>
                </div>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'imageFiles')->fileInput(['class'=>"image_input"]); ?>
            </div>
            <div class="col-md-12"><hr><hr></div>
            <div class="col-md-12">
                <?= $form->field($model, 'video_title')->textInput([]); ?>
            </div>
            <div class="col-md-12"> 
               <?= $form->field($model, 'data_type')->label()->widget(\kartik\select2\Select2::classname(), [
                    'data' => $model->getType(),
                    'hideSearch' => true,
                    'size' =>'sm', 
                    'options' => [
                        'placeholder' => 'Выберите ...',
                        'onchange'=>'
                            var type = $(this).val();
                            $("#one").show();
                            $("#two").show();
                            if(type == 1) 
                            {
                                $("#one").show(); 
                                $("#two").hide();
                            }
                            if(type == 2) 
                            {
                                $("#one").hide(); 
                                $("#two").show();
                            }
                            ' 
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?> 
            </div>
            <div class="col-md-12" id="one" <?= $model->data_type == 1 ? '' : 'style="display: none"' ?> >
                <?= $form->field($model, 'video')->textInput([]); ?>
            </div>
            <div class="col-md-12" id="two" <?= $model->data_type == 2 ? '' : 'style="display: none"' ?> >
                <div id="fone_img">
                    <?=$model->getImageFone()?>
                </div>
                <?= $form->field($model, 'fone_file')->fileInput(['accept' => 'image/*', 'class' => "poster23_image"])->label("Фон бекграунда") ?>
            </div>
        </div>
        <div class="col-md-9">
            <ul class="nav nav-pills" style="margin-top:2px;">
                <?php foreach($langs as $lang): ?>
                    <li class="<?= ($i == 0) ? 'active' : '' ?>">
                        <a data-toggle="tab" href="#<?=$lang->url?>"><?= (isset(explode('-', $lang->name)[1]) ? explode('-', $lang->name)[1] : $lang->name)?></a>
                    </li>
                <?php $i++; endforeach;?>
            </ul>
            <div class="tab-content">
                <?php $i = 0; foreach($langs as $lang): ?>
                    <div id="<?= $lang->url ?>" class="tab-pane fade <?= ($i == 0) ? 'in active' : '' ?>">
                        <p>
                            <?php if($lang->url == 'kr'): ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'title')->textInput()->label(Yii::t('app', 'Title')) ?>
                                    </div>
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'text')->textarea(['rows' => 6, 'maxLength' => '1500'])->label(Yii::t('app', 'Text')) ?>
                                    </div>
                                    <div class="col-md-12">
                                        <?= $form->field($model,  'description')->widget(CKEditor::className(),[
                                            //'value' => $description[$lang->url],
                                            'editorOptions' => [
                                                'filebrowserUploadUrl' => '/admin/news/ckeditor_image_upload',
                                                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                                'inline' => false, //по умолчанию false
                                                'height' => 200,
                                            ],
                                        ])->label("Описание")?>
                                    </div>
                                    <div class="col-md-12"><hr><hr></div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'sort_title')->textInput(['placeholder' => 'Выбираем сорт',]) ?>
                                        <?= $form->field($model, 'sort_items')->textarea(['rows' => 12])->label('Пункты сорта (разделите с ",")') ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'landing_title')->textInput(['placeholder' => 'Заголовок посадки',]) ?>
                                        <?= $form->field($model, 'landing_text')->textarea(['rows' => 5]) ?>
                                        <?= $form->field($model, 'important')->textarea(['rows' => 4]) ?>
                                    </div>
                                    <div class="col-md-12"><hr><hr></div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'growing_title')->textInput(['placeholder' => 'Выращивание',]) ?>
                                        <?= $form->field($model, 'growing_text')->textarea(['rows' => 4]) ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'growing_items')->textarea(['rows' => 8])->label('Пункты выращивании (разделите с ",")') ?>
                                    </div>
                                    
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'translation_title['.$lang->url.']')->textInput(['value' => $titles[$lang->url]])->label(Yii::t('app', 'Title')) ?>
                                    </div>
                                    <div class="col-md-12">
                                        <?= $form->field($model, 'translation_text['.$lang->url.']')->textarea(['rows' => 6, 'maxLength' => '1500', 'value' => $texts[$lang->url]])->label(Yii::t('app', 'Text')) ?>
                                    </div>
                                    <div class="col-md-12">
                                        <?php //$model->{'translation_description['.$lang->url.']'} = 'salom'; ?>
                                        <?= $form->field($model,  'translation_description['.$lang->url.']')->widget(CKEditor::className(),[
                                            'editorOptions' => [
                                                'filebrowserUploadUrl' => '/admin/news/ckeditor_image_upload',
                                                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                                'inline' => false, //по умолчанию false
                                                'height' => 200,
                                            ],
                                        ])->label("Описание")?>
                                    </div>
                                    <div class="col-md-12"><hr><hr></div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'translation_sort_title['.$lang->url.']')->textInput([ 'placeholder' => 'Выбираем сорт', 'value' => $sort_title[$lang->url]])->label('Выбираем сорт') ?>
                                        <?= $form->field($model, 'translation_sort_items['.$lang->url.']')->textarea(['rows' => 12, 'value' => $sort_items[$lang->url]])->label('Пункты сорта (разделите с ",")') ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'translation_landing_title['.$lang->url.']')->textInput([ 'placeholder' => 'Посадка малины', 'value' => $landing_title[$lang->url]])->label('Заголовок посадки') ?>
                                        <?= $form->field($model, 'translation_landing_text['.$lang->url.']')->textarea(['rows' => 5, 'value' => $landing_text[$lang->url]])->label('Текст посадки') ?>
                                        <?= $form->field($model, 'translation_important['.$lang->url.']')->textarea(['rows' => 4, 'value' => $important[$lang->url]])->label('Важно') ?>
                                    </div>
                                    <div class="col-md-12"><hr><hr></div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'translation_growing_title['.$lang->url.']')->textInput([ 'placeholder' => 'Выращивание', 'value' => $growing_title[$lang->url]])->label('Выращивание') ?>
                                        <?= $form->field($model, 'translation_growing_text['.$lang->url.']')->textarea(['rows' => 4, 'value' => $growing_text[$lang->url]])->label('Текст выращивании') ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'translation_growing_items['.$lang->url.']')->textarea(['rows' => 8, 'value' => $growing_items[$lang->url]])->label('Пункты выращивании (разделите с ",")') ?>
                                    </div>
                                </div>
                            <?php endif;?>
                        </p>
                    </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>
    </div>

<?php if(!$model->isNewRecord) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-inverse user-index">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Слайдер</h4>
                </div>
                <div class="panel-body">
                    <div id="ajaxCrudDatatable">
                    <?=GridView::widget([
                        'id'=>'slider',
                        'dataProvider' => $sliderProvider,
                        //'filterModel' => $searchModel,
                        'pjax'=>true,
                        'columns' => require(__DIR__.'/_slider_columns.php'),
                        'panelBeforeTemplate' =>    Html::a('Добавить <i class="fa fa-plus"></i>', ['/news/create-slider?id='.$model->id],
                                ['role' => 'modal-remote', 'title'=> 'Добавить','class'=>'btn btn-success']).'&nbsp;',      
                        'striped' => true,
                        'condensed' => true,
                        'responsive' => true,          
                        'panel' => [
                            'type' => 'primary', 
                            'headingOptions' => ['style' => 'display: none;'],
                            'after'=> '<div class="clearfix"></div>',
                        ]
                    ])?>
                </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="panel panel-inverse user-index">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" title="Во весь экран" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" title="Обновить" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Таблица</h4>
                </div>
                <div class="panel-body">
                    <div id="ajaxCrudDatatable">
                    <?=GridView::widget([
                        'id'=>'sort',
                        'dataProvider' => $sortProvider,
                        //'filterModel' => $searchModel,
                        'pjax'=>true,
                        'columns' => require(__DIR__.'/_sort_columns.php'),
                        'panelBeforeTemplate' =>    Html::a('Добавить <i class="fa fa-plus"></i>', ['/news/create-sort?id=' . $model->id],
                                ['role'=>'modal-remote', 'title'=> 'Добавить','class'=>'btn btn-success']).'&nbsp;',      
                        'striped' => true,
                        'condensed' => true,
                        'responsive' => true,          
                        'panel' => [
                            'type' => 'primary', 
                            'headingOptions' => ['style' => 'display: none;'],
                            'after'=> '<div class="clearfix"></div>',
                        ]
                    ])?>
                </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', [ 'style' => 'width:100%;', 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php 
$this->registerJs(<<<JS
$(document).ready(function(){
    var fileCollection = new Array();
    $(document).on('change', '.image_input', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:100%; max-height:300px;" src="'+e.target.result+'"> ';
                $('#image').html('');
                $('#image').append(template);
            };
        });
    });
});
JS
);?>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "options" => [
        "tabindex" => false,
    ],
    "footer"=>"",
])?>
<?php Modal::end(); ?>
<?php
$this->registerJs(<<<JS

    var fileCollection = new Array();
    $(document).on('change', '.poster23_image', function(e){
        var files = e.target.files;
        $.each(files, function(i, file){
            fileCollection.push(file);
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                var template = '<img style="width:100; height:80px;" src="'+e.target.result+'"> ';
                $('#fone_img').html('').append(template);
            };
        });
    });
JS
);
?>