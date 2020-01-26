 <?php 
use common\models\Chats;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset; 

$user_id = Yii::$app->user->identity->id;
CrudAsset::register($this);
?>
 <script type="text/javascript">

    function submitChat() {
        if(form1.uname.value == '' || form1.msg.value == '' ) alert("Пожалуйста введите текст");
        else{
            form1.uname.readyState = true;
            form1.uname.style.border = 'none';
            var uname = encodeURIComponent(form1.uname.value);
            var msg = encodeURIComponent(form1.msg.value);
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function(){
                if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                    document.getElementById('chatLogs').innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open('GET', '/admin/chats/send-message?uname=' + uname + '&msg=' + msg, true);
            xmlhttp.send();
            document.getElementById('msg').value = null; 
            $.pjax.reload({container:'#crud-datatable-pjax', async: false});

            $("div#List").scrollTop(999999999999999999);
            
        }
    }

     $(document).keypress(function (e) {
        if (e.which == 13) {
            submitChat();
            e.preventDefault();
        }
    });

    $('#form1').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            submitChat();
            e.preventDefault();
            return false;
        }
    });

</script>   
<!--  -->     
<?php Pjax::begin(['enablePushState' => false, 'id' => 'crud-datatable-pjax']) ?>  
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-inverse" data-sortable-id="index-4">
            <div class="panel-heading">
                <h4 class="panel-title">Пользователи <span class="pull-right label label-success">Количество : <?= count(Chats::getUsersListChat())?></span>
                  
                </h4>
            </div>
            <div class="content-frame-right" style="height: 505px;overflow-y: auto;">
                <div class="list-group list-group-contacts border-bottom push-down-10">
                    <?php foreach (Chats::getUsersListChat() as  $value) {
                        $style = "";
                        if($value['id'] == $active) $style = "#419FD9";
                    ?>
                        <a href="#" onclick="window.location.href='/admin/chats/index?chat_id=<?= $value['chat_id']?>'" class="list-group-item btnSetUsername"  style="background-color: <?=$style?>;">                                 
                            <div class="list-group-status status-online"></div>
                            <img src="<?=$value['image']?>" class="pull-left" style="width: 48px; height: 48px; object-fit: cover; margin-right: 5px;">
                            <span class="contacts-title">
                              <?=$value['fio']?>
                            </span> 
                            <?php if($value['count'] != 0):?>
                              <span class="btn btn-danger btn-icon btn-circle btn-xs">
                                <?= $value['count']?>
                              </span>
                            <?php endif; ?>
                            <p>
                              <?php if($value['last_message']): ?>
                                <?=mb_substr($value['last_message'],0,30)."..";?>
                              <?php else: ?>
                                <b>Новый</b>
                              <?php endif;?>
                            </p>
                        </a> 
                    <?php } ?>                               
                </div>
            </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="panel panel-inverse" data-sortable-id="index-2">
          <div class="panel-heading">
            <h4 class="panel-title">Чат 
               <a href="/admin/chats/send-multiple" role="modal-remote" class="btn btn-primary btn-xs m-r-5 pull-right">Создать новый чат</a>
            </h4>
          </div>
          <div class="panel-body bg-silver" id="pastga">
            <div class="slimScrollDiv">
                <div data-scrollbar="true" data-height="225px" data-init="true" id="List" style="overflow-y: auto; width: auto; height: 420px;">
                    <ul class="chats">
                    
                        <?php if($chat_live != null){ ?>
                        <?php foreach ($chat_live as $value) {  $msg = str_replace("\n", "<br>", $value->message); 
                            $clas = '';
                            if($value->user_id == $user_id ) $clas = 'right'; else $clas = 'left';
                        ?>
                          <li class="<?=$clas?>">
                              <span class="date-time"><?=date('d.m.Y H:i', strtotime($value->date_cr));?></span>
                              <a href="javascript:;" class="name"><?= $value->user->fio?></a>
                              <a href="javascript:;" class="image"><img alt="" src="<?=$value->user->getAvatar()?>" style="width: 48px; height: 48px; object-fit: cover;"></a>
                              <div class="message">

                                  <?= $msg?>
                              </div>
                          </li>
                        <?php } } else { ?>
                                <div style="font-weight: bold; font-size: 20px; text-align: center; height: 450px; display: -webkit-flex; display: -moz-flex; display: -ms-flex; display: -o-flex; display: flex; -ms-align-items: center; align-items: center; justify-content: center;">
                                    Выберите, кому хотели бы написать...
                                </div>
                        <?php } ?>
                    </ul>
                </div>
              </div>
              <div class="panel-footer">
                  <form data-id="message-form" name="form1" autocomplete="off" method ='post' enctype='multipart/form-data'>
                     <input type="hidden" name="uname" id="uname" value="<?=$chat_id?>">
                      <div class="input-group">
                          <textarea type="text" class="form-control input-sm"  name="msg" id="msg"  placeholder="Enter your message here." rows="1"> </textarea>
                          <span class="input-group-btn">
                              <a href="#" class="btn btn-primary btn-sm" onclick="submitChat()"  type="button"><i class="fa fa-send"></i></a>
                          </span>
                      </div>
                  </form>
              </div>
          </div>
        </div>
      </div>
    </div>
<?php Pjax::end() ?>
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

$('#msg').keydown(function (e) {

  if ((e.keyCode == 10 || e.keyCode == 13) && e.ctrlKey) {
    var text = $(this).val();
    val = text + "\\n";
    text = text +"\\n";
    $(this).val(text);
  }
});

$(document).ready(function(){
     $("div#List").scrollTop(9999999999999999);
});


$(document).ready(function(){
  
  $("#seacrh_users_button").on('click',function(){
     $("#seacrh_users").toggle();
  })

  $('#inputFile_submit').change(function(){ 
     var data = new FormData() ; 
     data.append('file', $( '#inputFile_submit' )[0].files[0]) ; 
     data.append('uname', $( '#uname' ).val()) ; 
     $.ajax({
     url: '/live-chat/send-file',
     type: 'POST',
     data: data,
     processData: false,
     contentType: false,
      success: function(data){ 
        
      }
     });
    return false;
  });
});
JS
);
?>

