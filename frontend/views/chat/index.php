<?php 

use yii\widgets\Pjax;

?>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script>  
    $(document).keypress(function (e) {
        if (e.which == 13) {
            submitChat();
            e.preventDefault();
        }
    });

    function showMessage(messageHTML) {
        $('#chat-box-<?=$nowChatId?>').append(messageHTML);        
    }

    var websocket = new WebSocket("ws://cron.agrobuy.uz:9393/demo/php-socket.php"); 
    $(document).ready(function(){
        $("div.pastga").scrollTop(99999999999);
        websocket.onopen = function(event) { 
            //showMessage("<div class='chat-connection-ack'>Connection is established!</div>");   
            $("div.pastga").scrollTop(99999999999);
        }
        websocket.onmessage = function(event) {
            var Data = JSON.parse(event.data);
            var chatId = $('#chat-id').val();
            if(chatId == Data.chat_id) {
                var str = Data.message;
                var user_id = $('#chat-user_id').val();
                if(user_id == Data.user_id) {
                    var msg = '<div class="user-letter person-right">' + str + '</div>';
                    $('#chat-message<?=$identity->id?>').val('');
                }
                else var msg = '<div class="user-letter person-left">' + str + '</div>';
                showMessage("<div class='" + Data.message_type + "'>" + msg + "</div>");
                $("div.pastga").scrollTop(99999999999);
            }
        };
      
        websocket.onerror = function(event){
            showMessage("<div class='error'>Ошибка с сторони сервера</div>");
            $("div.pastga").scrollTop(99999999999);
        };
        websocket.onclose = function(event){
            showMessage("<div class='chat-connection-ack'>Чат закрыто</div>");
            $("div.pastga").scrollTop(99999999999);
        }; 
      
        $('#frmChat').on("submit",function(event) {
            submitChat();
            event.preventDefault();
        });
    });

    function submitChat() {
        if($('#chat-message<?=$identity->id?>').val() == '' || $('#chat-message<?=$identity->id?>').val() == '' ) {
          //alert("Пожалуйста введите текст");
        }
        else {
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.open('GET', '/chat/set?chat_id=' + $('#chat-id').val() + '&msg=' + $('#chat-message<?=$identity->id?>').val() + '&user_id=' + $('#chat-user_id').val(), true);
          xmlhttp.send();
          var messageJSON = {
              chat_id: $('#chat-id').val(),
              chat_class: $('#chat-class').val(),
              chat_user_id: $('#chat-user_id').val(),
              chat_user_avatar: $('#chat-user_avatar').val(),
              chat_message: $('#chat-message<?=$identity->id?>').val()
          };
          websocket.send(JSON.stringify(messageJSON));
          $.pjax.reload({container: "#chat-main-pjax", timeout: false});
          $.pjax.reload({container: "#profile-chat-pjax", timeout: false});
          $.pjax.reload({container: "#mobile-chat-pjax", timeout: false});
        }
    }
</script>

<section class="chat">
    <div class="container">
        <div class="chat-main visible-chat">
            <?php Pjax::begin(['id' => 'chat-main-pjax']); ?>
            <div class="chat-main-left">
                <?php foreach ($chatList as $value) { ?>
                  <div class="item-chat">
                      <a href="/chat?chat=<?=$value['chat_id']?>" class="<?= $chat == $value['chat_id'] ? 'active' : $value['chat_id'] ?>">
                          <div class="img-chat-user">
                              <img src="<?=$value['image']?>" alt="User Avatar">
                          </div>
                          <div class="text-chat-user">
                              <h3>
                                  <?=$value['login']?>
                                  <?php if($value['count'] > 0) { ?>
                                    <div class="chat_message_count">
                                        <?=$value['count']?>
                                    </div>
                                  <?php } ?>
                              </h3>
                              <p>
                                  <?=$value['last_message']?>
                                  <div class="last_message_date"><?=$value['date_cr']?></div>
                              </p>
                              <!-- <span>Продажа малинки</span> -->
                          </div>
                      </a>
                      <div class="btn-group">
                          <button type="button" class="" data-toggle="dropdown">
                              <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><circle cx="256" cy="256" r="64"/><circle cx="256" cy="448" r="64"/><circle cx="256" cy="64" r="64"/>
                              </svg>
                          </button>
                          <div class="dropdown-menu">
                              <a class="dropdown-item delete_chats" href="#" data-touch="false" value="/<?=$nowLanguage?>/chat/delete-form?id=<?=$value['chat_id']?>" data-fancybox data-src="#delete-chats-popup" ><?= Yii::t('app',"O'chirish") ?></a>
                              <!-- <a class="dropdown-item" href="#">Заблокировать</a> -->
                              <a href="#" data-touch="false" data-fancybox data-src="#send-complaint" value="/<?=$nowLanguage?>/profile/complaint?user_id=<?=$value['id']?>" class="dropdown-item complaint_class"><?= Yii::t('app',"Shikoyat qilish") ?></a>
                          </div>
                      </div>
                  </div>
                <?php } ?>
            </div>
            <?php Pjax::end(); ?>
            <div class="d-lg-none mob-back-chat">
                <a href="#">
                    <svg enable-background="new 0 0 492 492" version="1.1" viewBox="0 0 492 492" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m198.61 246.1 184.06-184.06c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12c-5.06-5.072-11.824-7.864-19.032-7.864s-13.964 2.792-19.028 7.864l-219.15 219.14c-5.084 5.08-7.868 11.868-7.848 19.084-0.02 7.248 2.76 14.028 7.848 19.112l218.94 218.93c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06l-183.85-183.85z"/>
                    </svg>
                    <?= Yii::t('app',"Orqaga") ?>
                </a>
                <?php if($onlineChatUser != null) { $guestUserId = $onlineChatUser->id ?>
                  <div>
                      <img src="<?=$onlineChatUser->user->getAvatarForSite()?>" alt="User Avatar">
                      <span><?=$onlineChatUser->user->login?></span>
                  </div>
                <?php } ?>
            </div>
            <form name="frmChat" id="frmChat" class="chat-main-right">
                <div class="messages pastga" id="chat-box-<?=$nowChatId?>" id="scroll">
                    <?php foreach ($messages as $message) { ?>
                        <?= $message['showValue'] ?>
                        <div class="user-letter <?= $message['class'] ?>">
                            <a href="<?= $message['link'] ?>" class="img-chat-user">
                                <img src="<?= $message['userAvatar'] ?>" alt="User Avatar">
                            </a>
                            <div class="text-chat-body">
                                <p><?=$message['message']?> <span><?=$value['date_cr']?></span></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="inputs-chat">
                    <input type="file" id="input-file">
                    <label for="input-file">
                        <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m446.66 37.298c-49.731-49.731-130.64-49.731-180.37 0l-189.91 189.91c-5.861 5.861-5.861 15.356 0 21.217s15.356 5.861 21.217 0l189.91-189.91c36.865-36.836 101.07-36.836 137.94 0 38.023 38.023 38.023 99.901 0 137.92l-265.18 268.17c-22.682 22.682-62.2 22.682-84.881 0-23.4-23.4-23.4-61.467 0-84.867l254.58-257.58c8.498-8.498 23.326-8.498 31.825 0 8.776 8.776 8.776 23.063 0 31.84l-243.95 246.95c-5.06 5.06-5.06 16.156 0 21.217 5.861 5.861 15.356 5.861 21.217 0l243.95-246.95c20.485-20.485 20.485-53.789 0-74.273-19.839-19.839-54.449-19.81-74.258 0l-254.58 257.58c-34.826 34.826-34.826 92.474 0 127.3 17.012 17.012 39.62 26.175 63.664 26.175s46.654-9.163 63.651-26.174l265.18-268.17c49.731-49.731 49.731-130.63 1e-3 -180.36z"/>
                        </svg>
                    </label>
                    <textarea rows="1" placeholder="<?= Yii::t('app',"Xabar yozish...") ?>" name="chat-message" id="chat-message<?=$identity->id?>" class="chat-input chat-message"></textarea>
                    <input type="hidden" name="chat-id" id="chat-id" value="<?=$nowChatId?>" />
                    <input type="hidden" name="chat-class" id="chat-class" value="person-right" />
                    <input type="hidden" name="chat-user_id" id="chat-user_id" value="<?=$identity->id?>" />
                    <input type="hidden" name="chat-guest_user_id" id="chat-guest_user_id" value="<?=$guestUserId?>" />
                    <input type="hidden" name="chat-user_avatar" id="chat-user_avatar" value="<?=$identity->getAvatarForSite()?>" />
                    <button type="submit" id="btnSend" name="send-chat-message">
                        <svg enable-background="new 0 0 448.011 448.011" version="1.1" viewBox="0 0 448.01 448.01" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m438.73 209.46-416-192c-6.624-3.008-14.528-1.216-19.136 4.48-4.64 5.696-4.8 13.792-0.384 19.648l136.8 182.4-136.8 182.4c-4.416 5.856-4.256 13.984 0.352 19.648 3.104 3.872 7.744 5.952 12.448 5.952 2.272 0 4.544-0.48 6.688-1.472l416-192c5.696-2.624 9.312-8.288 9.312-14.528s-3.616-11.904-9.28-14.528z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>        
    </div>
</section>