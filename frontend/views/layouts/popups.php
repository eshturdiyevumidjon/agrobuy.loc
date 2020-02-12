<?php

use yii\helpers\Html;

?>
<div class="pp">

      <span data-fancybox data-src="#recovery-password" >Popup1</span>

      <span data-fancybox data-src="#recovery-password-2">Popup2</span>

      <span data-fancybox data-src="#registration-2" >Popup3</span>

      <span data-fancybox data-src="#purchase-service" >Popup4</span>

      <span data-fancybox data-src="#ad-promotion" >Popup5</span>

      <span data-fancybox data-src="#send-complaint" >Popup6</span>

      <span data-fancybox data-src="#registration" >Popup7</span>

      <span data-fancybox data-src="#avtorization" >Popup8</span>

    </div>
    
    <div id="ad-promotion" style="display: none;" class="popup-style">
      <h2>Продвижение <span>объявления</span>?</h2>
      <div class="dropdown">
        <div class="ad-promo-button">
            <div class="ad-1">
              <img src="/images/desert.jpg" alt="">
            </div>
            <div class="ad-2">
              Продается поле 45 Га...
            </div>
            <div class="ad-2">
              837 39 20
            </div>
            <span id="dropdownMenuButton">
              <img src="/images/right-arrow-green.png" alt="">
            </span>
        </div>
        <div class="drops">
          <div class="title-drops">
            <div class="ad-promo-button">
              <div>
                №
              </div>
              <div class="ad-2 min-bord">
                Миниатюра фото объявления
              </div>
              <div class="ad-2" style="font-weight: 500; text-align: center;">
                Заголовок объявления
              </div>
              <div class="ad-2" style="font-weight: 500; text-align: center;">
                Номер объявления
              </div>
            </div>
          </div>
          <a href="#">
            <div class="ad-promo-button">
              <div>
                1
              </div>
              <div class="ad-1">
                <img src="/images/desert.jpg" alt="">
              </div>
              <div class="ad-2">
                Продается поле 45 Га...
              </div>
              <div class="ad-2">
                837 39 20
              </div>
            </div>
          </a>
          <a href="#">
            <div class="ad-promo-button">
              <div>
                2
              </div>
              <div class="ad-1">
                <img src="/images/desert.jpg" alt="">
              </div>
              <div class="ad-2">
                Продается поле 45 Га...
              </div>
              <div class="ad-2">
                837 39 20
              </div>
            </div>
          </a>
        </div>
      </div>

      <div class="prem-vip">
        <div class="prem-vip-item">
          <div class="prem-vip-discount">- 50%</div>
          <div class="prem-vip-img">
              <img src="/images/vip.png" alt="">
          </div>
          <a class="prem-vip-date">7 дней</a>
          <p>Приобретите сейчас VIP пакет и получите скидку в 50% с возможностью оставлять неограниченное количество объявленийй в течении 7 дней</p>
          <span class="prem-vip-price">5 000 сумма</span>
        </div>
        <div class="prem-vip-item">
          <div class="prem-vip-img">
              <img src="/images/premium.png" alt="">
          </div>
          <a class="prem-vip-date">Премиум</a>
          <p>Приобретите сейчас VIP пакет и получите скидку в 50% с возможностью оставлять неограниченное количество объявленийй в течении 7 дней</p>
          <span class="prem-vip-price">5 000 сумма</span>
        </div>
      </div>
    </div> 
  
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
    <!-- <div id="send-complaint" style="display: none;" class="popup-style">
      <h2>Отправьте <span>жалобу</span></h2>
      <form>
        <div class="form-group">
          <textarea name="" class="form-control" cols="30" rows="10" placeholder="Подробно опишите причину жалобы..."></textarea>
        </div>
        <div class="text-right w-100">
          <button type="submit" class="btn-template">Отправить жалобу</button>
        </div>
      </form>
    </div> -->    

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

    <div id="registration" style="display: none;" class="popup-style">
      <div id="registrationContent"></div>
    </div>
    <!-- <div id="registration" style="display: none;" class="popup-style">
      <img src="/images/logo.png" alt="" class="logo-popup-top">
      <h2><span>Регистрация</span></h2>
      <form>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Придумайте логин">
        </div>
        <div class="form-group">
          <input type="tel" class="form-control" placeholder="+ 998 __ ___ __ __">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Придумайте пароль">
        </div>
        <button type="submit" class="btn-template">Отправить код</button>
        <p class="text-center">или</p>
        <p>Уже есть аккаунт? <a href="#" class="link-popup">Войти</a></p>
      </form>
    </div> -->
    
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


<?php 
$this->registerJs(<<<JS
  $(function () {
    // add
    $('.avtorization_class').on('click', function () {
        $('#avtorization').find('#avtorizationContent').load($(this).attr('value'));
    });

    $('.registration_class').on('click', function () {
        $('#registration').find('#registrationContent').load($(this).attr('value'));
    });

    $('.delete_ads').on('click', function () {
        $('#delete-ads-popup').find('#deleteAdsContent').load($(this).attr('value'));
    });

    $('.complaint_class').on('click', function () {
        $('#send-complaint').find('#complaintContent').load($(this).attr('value'));
    });

    $('.star_class').on('click', function () {
        $('#star-popup').find('#starContent').load($(this).attr('value'));
    });
    
  });


JS
)
?>