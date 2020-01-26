<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Chats;

/* @var $this yii\web\View */
/* @var $model backend\models\Chats */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chats-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="panel panel-inverse" data-sortable-id="index-4">
            <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="checkbox" name=""  value="" id="select_all"> 
                            <label for="select_all" style="font-size:18px; color: white;">Все</label>
                        </div>
                       <!--  <div class="col-md-7">
                            <input type="" class="form-control pull-right" name="" placeholder="Поиск" id="search_users_input"/>
                        </div> -->
                    </div>
            </div>
            <div class="content-frame-right" style="height: 300px;overflow-y: auto;">
            
                <div class="list-group list-group-contacts border-bottom push-down-10">
                    <?php foreach (Chats::getUsersList() as  $value) {?>
                        <a href="#" class="list-group-item" >                                 
                            <img src="<?=$value['image']?>"  alt="Dmitry Ivaniuk" style="width: 38px; height: 38px; object-fit: cover; margin-right: 5px;">
                            <span class="contacts-title"><?=$value['fio']?></span>
                            <input type="checkbox" name="chat-users"  class="pull-right" value="<?= $value['id']?>">
                        </a> 
                    <?php } ?>                               
                </div>
            </div>
            <?= $form->field($model, 'message')->textarea(['rows' => 3]) ?>
        </div>
    <?php ActiveForm::end(); ?>
    
</div>
<?php
$this->registerJs(<<<JS

$(document).ready(function(){
  
    $("#search_users_button").on('click',function(){
        $("#search_users_input").toggle(300);
    });

    $("#search_users_input").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".list-group .list-group-item").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $("#select_all").on('change',function(){
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    })

});
JS
);
?>

