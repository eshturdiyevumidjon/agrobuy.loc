<?php

use yii\helpers\Html;
?>  
    <div id="purchase-service" style="display: none;" class="popup-style">
      <h2>Вы <span>действительно хотите </span> <br>приобрести <span>данную услугу</span>?</h2>
      <form>
        <div class="btn-service">
          <button type="submit" class="btn-template">Да</button>
          <button class="btn-bc">Нет</button>
        </div>
      </form>
    </div>  

    <div id="send-complaint" style="display: none;" class="popup-style">
        <div id="complaintContent"></div>
    </div> 

    <div id="registration-2" style="display: none;" class="popup-style">
      <img src="/images/logo.png" alt="" class="logo-popup-top">
      <h2><span>Регистрация</span></h2>
      <p class="text-center">На указанный Вами номер телефона было <br>выслано сообщение с кодом</p>
      <form>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Введите код из смс">
        </div>
        <div class="form-group checked-agree">
          <input type="checkbox" id="check-form">
          <label for="check-form">Вы согласны с <a href="#"  class="link-popup"> Пользовательским соглашением?</a></label>
        </div>
        <div class="form-group captcha-block">
          <input type="text" class="form-control" placeholder="Введите сюда">
          <div id="captcha"></div>
        </div>
        <button type="submit" class="btn-template">Зарегистрироваться</button>
      </form>
    </div>
    
    <div id="recovery-password-2" style="display: none;" class="popup-style">
      <img src="/images/logo.png" alt="" class="logo-popup-top">
      <h2>Востановление <br><span>пароля</span></h2>
      <p>На указанный Вами номер телефона было <br>выслано сообщение с кодом</p>
      <form>
        <div class="form-group">
          <input type="number" class="form-control" placeholder="Введите код">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Новый пароль">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Повторите пароль">
        </div>
        <button type="submit" class="btn-template">Востановить пароль</button>
      </form>
    </div>

    <div id="avtorization" style="display: none;" class="popup-style">
      <div id="avtorizationContent"></div>
    </div>

    <div id="recovery-password" style="display: none;" class="popup-style">
      <img src="/images/logo.png" alt="" class="logo-popup-top">
      <h2>Востановление <br><span>пароля</span></h2>
      <form>
        <div class="form-group">
          <input type="tel" class="form-control" placeholder="+ 998 __ ___ __ __">
        </div>
        <button type="submit" class="btn-template">Востановить пароль</button>
      </form>
    </div>

    <div id="logout-popup" style="display: none;" class="popup-style">
      <h2><?=Yii::t('app', 'Saytdan chiqish')?></h2>
      <p><?=Yii::t('app', 'Siz haqiqatdan ham saytdan chiqmoqchimisiz?')?></p>
      <?php 
          echo Html::beginForm(['/site/logout'], 'post'); ?>
          <div class="btn-service">
            <button type="submit" class="btn-template"><?=Yii::t('app', "Ha")?></button>
          </div>
          <?php echo Html::endForm();
      ?>
    </div>

    <div id="delete-ads-popup" style="display: none;" class="popup-style">
        <div id="deleteAdsContent"></div>
    </div>

    <div id="star-popup" style="display: none;" class="popup-style">
        <div id="starContent"></div>
    </div>

    <div id="ad-promotion" style="display: none;" class="popup-style">
        <div id="premiumContent"></div>
    </div>

    <div id="chats-popup" style="display: none;" class="popup-style">
      <div id="chatsContent"></div>
    </div>

    <div id="delete-chats-popup" style="display: none;" class="popup-style">
        <div id="deleteChatsContent"></div>
    </div>
