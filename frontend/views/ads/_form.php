<?php

  use yii\helpers\Html;
  use yii\bootstrap\ActiveForm;
  use common\models\Ads;

?>
<section class="creating-ads">
    <div class="container">
        <h2 class="title"><?=Yii::t('app', $model->isNewRecord ? "E'lon yaratish" : "Tahrirlash" )?></h2>  
        <?php $form = ActiveForm::begin(['options' => ['method' => 'post', 'enctype' => 'multipart/form-data' ]]); ?>
            <div class="row">
              <div class="col-lg-8 col-sm-8 col-12">
                  <?= $form->field($model, 'type'/*, ['options' => ['class' => 'radio-style']]*/)
                  ->radioList(['2' => Yii::t('app', "Sotish"), '1' => Yii::t('app', "Sotib olish")],
                    ['separator' => '', ],
                  ['class' => '', 'id' => 'your_id'])->label(false); ?>
              </div>


              <div class="col-lg-4 col-sm-4 col-12">
                  <div class="form-group radio-style">
                    <input type="checkbox" name="add_catalog" value="1" <?=$catalog != null ? 'checked=""' : ''?> id="radi3">
                    <label for="radi3"><?=Yii::t('app', "Katalogga qo'shish")?></label>
                  </div>
              </div>
            </div>
            <hr>
            <div class="" id="imagesList">
                <?=$model->getImages()?>
            </div>
            <div class="row">
              <div class="col-xl-9" style="display: none;">
                <div class="attach">
                    <label for="rad"><?=Yii::t('app', "Foto biriktirish")?></label>
                    <span class="multiple-photos">
                        <?=Yii::t('app', "Bir nechta rasmlarni yuklashingiz mumkin")?>
                    </span>
                    <?= $form->field($model, 'imageFiles[]')->fileInput(['class'=>"image_input", 'multiple' => true, 'accept' => 'image/*' ])->label(false); ?>
                    <button type="submit" id="ads_file" class="btn-template"><?=Yii::t('app', "Fayl qo'shish")?></button>
                </div>
              </div>

              <div class="col-xl-9">
                  <div class="attach">
                    <label for="rad"><?=Yii::t('app', "Foto biriktirish")?></label>
                    <span class="multiple-photos">
                        <?=Yii::t('app', "Bir nechta rasmlarni yuklashingiz mumkin")?> <div class="fileinput-button dz-clickable"></div>
                    </span>
                    <a href="#" id="ads_file_a_teg"><?=Yii::t('app', "Fayl qo'shish")?></a>
                  </div> 
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-xl-9">
                  <?= $form->field($model, 'category_id', ['options' => ['class' => 'form-group create-select-style']])->dropDownList($model->getCategoryListForSite(),['class' => 'js-select2', 'placeholder' => Yii::t('app', "Tanlang") , 'onchange' => '$.post( "/' . $nowLanguage . '/ads/subcategory?id="+$(this).val(), function( data ){ $( "select#subcategory" ).html( data); });' ])->label(Yii::t('app', "Kategoriyani tanlang")) ?>

                  <?= $form->field($model, 'subcategory_id', ['options' => ['class' => 'form-group create-select-style']])->dropDownList($model->getSubcategoryListForSite($model->category_id),['class' => 'js-select2', 'placeholder' => Yii::t('app', "Tanlang"), 'id' => 'subcategory' ])->label(Yii::t('app', "Subkategoriyani tanlang")) ?>

                  <?= $form->field($model, 'region_id', ['options' => ['class' => 'form-group create-select-style']])->dropDownList($model->getRegionsList(),['class' => 'js-select2', 'placeholder' => Yii::t('app', "Tanlang") ])->label(Yii::t('app', "Shahar,viloyat qo'shish")) ?>

                    <?= $form->field($model, 'title', ['options' => ['class' => 'form-group create-input-style']])->textInput(['class' => 'form-control', 'maxlength' => 70])->label(Yii::t('app', "E'lon sarlavhasi")) ?>

                  <?= $form->field($model, 'text', ['options' => ['class' => 'form-group create-input-style']])->textArea(['class' => 'form-control', 'id'=>"text", 'maxlength' => 9000])->label(Yii::t('app', "E'lon haqida batafsil ma'lumot berish")) ?>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-xl-9">
                  <div class="row">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'price', ['options' => ['class' => 'form-group create-bottom-style']])->textInput(['class' => '', 'type' => 'number'])->label(Yii::t('app', "Narxni ko'rsating")) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'unit_price', ['options' => ['class' => 'form-group create-bottom-style inpt-min']])->textInput(['class' => '',])->label(Yii::t('app', "Цена за")) ?>
                    </div>
                    <div class="col-sm-4">
                      <?= $form->field($model, 'currency_id', ['options' => ['class' => 'form-group create-select-style inpt-min']])->dropDownList($model->getCurrencyList(),['class' => 'js-select2', 'placeholder' => Yii::t('app', "Tanlang") ])->label(Yii::t('app', "Valyuta")) ?>
                    </div>
                  </div>
              </div>
              <div class="col-lg-12">
                  <div class="form-group radio-style treat">
                    <input type="checkbox" name="Ads[treaty]" <?=$model->treaty == 1 ? 'checked' : ''?> value="1" id="treaty">
                    <label for="treaty"><?=Yii::t('app', "Kelishilgan")?></label>
                  </div>
              </div>
            </div>
            <hr>
            <div class="text-center">
              <button type="submit" class="btn-template"><?=Yii::t('app', $model->isNewRecord ? "E'lonni qo'shish" : "Saqlash")?></button>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</section>

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
                var template = '<div class="image_preview_class"><span class="preview"><a href="#">x</a><img src="'+e.target.result+'"></span></div>';
                //$('#imagesList').html('');
                $('#imagesList').append(template);
            };
        });
    });
});
JS
);
?>