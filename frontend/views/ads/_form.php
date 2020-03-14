<?php

  use yii\helpers\Html;
  use yii\bootstrap\ActiveForm;
  use common\models\Ads;

  $images =  $post['uploaded_files'];
  $dir = '/admin/uploads/ads/';
  $uploadDir = '/admin/uploads/ads_trash/';
  $this->title = Yii::t('app', $model->isNewRecord ? "E'lon yaratish" : "Tahrirlash" );

?>
<section class="creating-ads">
    <div class="container">
        <h2 class="title"><?=Yii::t('app', $model->isNewRecord ? "E'lon yaratish" : "Tahrirlash" )?></h2>  
        <?php $form = ActiveForm::begin(['options' => ['method' => 'post', 'enctype' => 'multipart/form-data' ]]); ?>
            <div class="row">
              <div class="col-lg-8 col-sm-8 col-12">
                  <?= $form->field($model, 'type')
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
                <div class="imagesList">
                  <?php if ($model->images): ?>
                    <?php foreach (explode(",",$model->images) as $value): ?>
                      <div class="image_preview_class"><a class="img-ads" title="<?=$value?>">x</a><span class="preview"><img src="<?=$dir.$value?>"></span></div>
                    <?php endforeach ?>
                  <?php endif ?>
                  <?php if ($images): ?>
                    <?php foreach (explode(",",$images) as $key => $value): ?>
                      <div class="image_preview_class"><a class="img-ads" title="<?=$value?>">x</a><span class="preview"><img src="<?=$uploadDir.$value?>"></span></div>
                    <?php endforeach ?>
                  <?php endif ?>
                </div>
                <input type="file" name="imagesProba" accept="images/*" multiple="true" style="display: none" id="inputFile">
                <input type="hidden" name="uploaded_files" id="uploaded_files" value="<?=$images?>">
                <input type="hidden" name="old_uploaded_files" id="old_uploaded_files" value="<?=$model->images?>">
                <div class="attach">
                  <?=Yii::t('app', "Foto biriktirish")?>&nbsp;&nbsp;&nbsp;
                  <label for="inputFile">
                    <span class="multiple-photos">
                            <div class="fileinput-button dz-clickable"></div>
                        </span>
                  </label>
                </div>
            <hr>
            <div class="row">
              <div class="col-xl-9">
                  <?= $form->field($model, 'category_id', ['options' => ['class' => 'form-group create-select-style']])->dropDownList($model->getCategoryListForSite(),['class' => 'js-select2', 'placeholder' => Yii::t('app', "Tanlang") , 'onchange' => '$.post( "/' . $nowLanguage . '/ads/subcategory?id="+$(this).val(), function( data ){ $( "select#subcategory" ).html( data); });' ])->label(Yii::t('app', "Kategoriyani tanlang")) ?>

                  <?= $form->field($model, 'subcategory_id', ['options' => ['class' => 'form-group create-select-style']])->dropDownList($model->getSubcategoryListForSite($model->category_id),['class' => 'js-select2', 'placeholder' => Yii::t('app', "Tanlang"), 'id' => 'subcategory' ])->label(Yii::t('app', "Subkategoriyani tanlang")) ?>

                  <?= $form->field($model, 'region_id', ['options' => ['class' => 'form-group create-select-style']])->dropDownList($model->getRegionsList(),['class' => 'js-select2', 'placeholder' => Yii::t('app', "Tanlang") , 'onchange' => '$.post( "/' . $nowLanguage . '/ads/districts?id="+$(this).val(), function( data ){ $( "select#district" ).html(data); });' ])->label(Yii::t('app', "Shahar,viloyat qo'shish")) ?>

                  <?= $form->field($model, 'district_id', ['options' => ['class' => 'form-group create-select-style']])->dropDownList($model->getDistrictsList($model->region_id),['class' => 'js-select2', 'placeholder' => Yii::t('app', "Tanlang"), 'id' => 'district' ])->label(Yii::t('app', "Tumanni tanlang")) ?>

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
$id = $model->id;
$this->registerJs(<<<JS

  $("#inputFile").on('change',function(e){
      namess = [];
      var files = e.target.files;
      var data = new FormData(); 
      $.each(files, function(i,file){
          var reader = new FileReader();
          var d = new Date();
          var new_name = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate() + '_' +d.getHours() + '-' + d.getMinutes() + '-' + d.getSeconds();  
          var filename = $( '#inputFile' )[0].files[i].name;
          name = filename.split('.').shift();
          var ext = filename.split('.').pop();
          new_name = name + '(' + new_name + ")." + ext;
          reader.readAsDataURL(file);
          data.append('file[]', $( '#inputFile' )[0].files[i]) ; 
          data.append('names[]', new_name) ; 
          namess.push(new_name);
          template = '<div class="image_preview_class" data-id="'+ new_name +'"><a class="img-ads" title="'+new_name+'">x</a><span class="preview"><img src="/admin/uploads/zz.gif"></span></div>';
          $(".imagesList").append(template);
      });
      $.ajax({
        url: '/$nowLanguage/ads/save-img',
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        success: function(success){
          new_names = "";
          for(var i=0; i < namess.length;i++){
            if(i != namess.length-1){
              new_names += namess[i] + ",";
            }else{
              new_names += namess[i];
            }

            template = '<a class="img-ads" title="'+namess[i] +'">x</a><span class="preview"><img src="$uploadDir' + namess[i]+'"></span>';
            $('[data-id="' + namess[i] + '"]').html(template);
          }
          old_files = $("#uploaded_files").val();
          if(old_files)
            new_files = old_files + "," + new_names;
          else
            new_files = new_names;
            $("#uploaded_files").val(new_files);
        },
        cache: false,
        xhr: function() {  // custom xhr
            myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                return myXhr;
            }
        }
      });

    });
    $(document).on('click', ".img-ads", function(e){
       element = $(this).attr('title');
       files = ($("#uploaded_files").val()).split(",");
       old_files = ($("#old_uploaded_files").val()).split(",");
       var index = files.indexOf(element);
       if (index !== -1) {
        files.splice(index, 1);
        $("#uploaded_files").val(files.join(","));
       }

       index = old_files.indexOf(element);
       if (index !== -1) {
        old_files.splice(index, 1);
        $("#old_uploaded_files").val(old_files.join(","));
       }
      

        $.post('/$nowLanguage/ads/delete-image?value='+element+'&id=$id',function(success){});
        e.preventDefault();
        e.target.parentElement.remove();
    });
JS
)
?>

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
                var template = '<div class="image_preview_class"><span class="preview"><img src="'+e.target.result+'"></span></div>';
                //$('#imagesList').html('');
                $('.imagesList').append(template);
            };
        });
    });
});
JS
);
?>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!-- <script type="text/javascript">
$(document).ready(function(){
    $('.img-ads').on('click',function() {
        var id = encodeURIComponent($(this).attr('data-id'));
        var path = encodeURIComponent($(this).attr('data-path'));
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function(){
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200){}
        }
        xmlhttp.open('GET', '/ads/remove-img?id=' + id + '&path=' + path, true);
        xmlhttp.send();
        document.getElementById(path + "_" + id).remove();
    });
  });
</script> -->


