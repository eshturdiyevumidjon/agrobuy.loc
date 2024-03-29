<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
$_csrf = \Yii::$app->request->getCsrfToken();

?>
  <div class="block-main-user">
      <?php $form = ActiveForm::begin([
          'id' => 'user-avatar-form', 
          //'action' => '/profile/avatar', 
          'method' => 'post', 
          'options' => [
              'enctype' => 'multipart/form-data', 
              'class' => 'img-main-user'
          ]
      ]) ?>
            <div id="user_logo_file<?=$identity->id?>">
              <img src="<?=$identity->getAvatarForSite()?>" alt="user image" id="image_upload_preview" >
            </div>
            <input type="file" id="ad1" accept="image/*" name="ad1">
            <label for="ad1" id="write">
            <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                <path d="m402 166c-5.52 0-10 4.48-10 10s4.48 10 10 10 10-4.48 10-10-4.48-10-10-10z"></path>
                <path d="m482 126h-109.82l-31.706-63.413c-5.117-10.231-15.399-16.587-26.834-16.587h-115.28c-11.437 0-21.719 6.356-26.834 16.588l-31.706 63.412h-19.82v-10c0-16.542-13.458-30-30-30h-20c-16.542 0-30 13.458-30 30v10h-10c-16.542 0-30 13.458-30 30v280c0 16.542 13.458 30 30 30h452c16.542 0 30-13.458 30-30v-280c0-16.542-13.458-30-30-30zm-292.58-54.468c1.706-3.412 5.133-5.532 8.945-5.532h115.28c3.812 0 7.24 2.12 8.946 5.532l27.234 54.468h-187.64l27.235-54.468zm-129.42 44.468c0-5.514 4.486-10 10-10h20c5.514 0 10 4.486 10 10v10h-40v-10zm-40 109.9h126.45c-13.29 20.761-20.451 45.092-20.451 70.1 0 25.01 7.162 49.243 20.45 70h-126.45v-140.1zm236-39.9c60.133 0 110 48.719 110 110 0 61.212-49.797 110-110 110-60.257 0-110-48.842-110-110 0-61.205 49.79-110 110-110zm236 250c0 5.514-4.486 10-10 10h-452c-5.514 0-10-4.486-10-10v-50h142.23c24.435 25.472 58.349 40 93.774 40 35.431 0 69.348-14.532 93.775-40h142.22v50zm0-70h-126.45c13.29-20.761 20.451-44.991 20.451-70s-7.161-49.239-20.451-70h126.45v140zm0-160h-142.23c-24.434-25.472-58.348-40-93.774-40-35.43 0-69.347 14.532-93.775 40h-142.22v-50c0-5.514 4.486-10 10-10h452c5.514 0 10 4.486 10 10v50z"></path>  
                <path d="m286 86h-60c-5.523 0-10 4.477-10 10s4.477 10 10 10h60c5.522 0 10-4.477 10-10s-4.478-10-10-10z"></path>
                <path d="m256 206c-49.626 0-90 40.374-90 90s40.374 90 90 90 90-40.374 90-90-40.374-90-90-90zm0 160c-38.598 0-70-31.402-70-70s31.402-70 70-70 70 31.402 70 70-31.402 70-70 70z"></path>
                <path d="m256 246c-27.57 0-50 22.43-50 50 0 5.523 4.477 10 10 10s10-4.477 10-10c0-16.542 13.458-30 30-30 5.522 0 10-4.477 10-10s-4.478-10-10-10z"></path>
                <path d="m462 166h-20c-5.522 0-10 4.477-10 10s4.478 10 10 10h20c5.522 0 10-4.477 10-10s-4.478-10-10-10z"></path>
            </svg>
            <?= Yii::t('app',"Profil rasmini o'zgartirish") ?></label>
            <?= Html::submitButton(Yii::t('app',"Saqlash"), ['class' => 'btn btn-template', 'style' => 'display:none;', 'id' => 'user_avatar']) ?>
        <?php ActiveForm::end(); ?>
          <div class="about-main-user">
            <div class="about-main-user-top">
              <h2><?=$identity->fio?></h2>
            </div>
            <div class="about-main-user-bottom mob-abs-right">
              <div>
                <p><?= Yii::t('app',"Login") ?> : <span><?=$identity->login?></span></p>
                <p><?= Yii::t('app',"Kompaniya nomi") ?> : <span><?=$identity->company_name?></span></p>
                <p><?= Yii::t('app',"ID") ?> : <span><?=$identity->id?></span></p>
              </div>
              <div class="person-socials">
                <span class="<?=$identity->check_phone ? 'first' : 'second'?>-person-socials">
                  <a href="tel:<?=$identity->phone?>">
                    <svg enable-background="new 0 0 512.076 512.076" version="1.1" viewBox="0 0 512.08 512.08" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                    <g transform="translate(-1 -1)">
                        <path d="m499.64 396.04-103.65-69.12c-13.153-8.701-30.784-5.838-40.508 6.579l-30.191 38.818c-3.88 5.116-10.933 6.6-16.546 3.482l-5.743-3.166c-19.038-10.377-42.726-23.296-90.453-71.04s-60.672-71.45-71.049-90.453l-3.149-5.743c-3.161-5.612-1.705-12.695 3.413-16.606l38.792-30.182c12.412-9.725 15.279-27.351 6.588-40.508l-69.12-103.65c-8.907-13.398-26.777-17.42-40.566-9.131l-43.341 26.035c-13.618 8.006-23.609 20.972-27.878 36.181-15.607 56.866-3.866 155.01 140.71 299.6 115 115 200.62 145.92 259.46 145.92 13.543 0.058 27.033-1.704 40.107-5.239 15.212-4.264 28.18-14.256 36.181-27.878l26.061-43.315c8.301-13.792 4.281-31.673-9.123-40.585zm-5.581 31.829-26.001 43.341c-5.745 9.832-15.072 17.061-26.027 20.173-52.497 14.413-144.21 2.475-283.01-136.32s-150.73-230.5-136.32-283.01c3.116-10.968 10.354-20.307 20.198-26.061l43.341-26.001c5.983-3.6 13.739-1.855 17.604 3.959l37.547 56.371 31.514 47.266c3.774 5.707 2.534 13.356-2.85 17.579l-38.801 30.182c-11.808 9.029-15.18 25.366-7.91 38.332l3.081 5.598c10.906 20.002 24.465 44.885 73.967 94.379 49.502 49.493 74.377 63.053 94.37 73.958l5.606 3.089c12.965 7.269 29.303 3.898 38.332-7.91l30.182-38.801c4.224-5.381 11.87-6.62 17.579-2.85l103.64 69.12c5.818 3.862 7.563 11.622 3.958 17.604z"></path>
                        <path d="m291.16 86.39c80.081 0.089 144.98 64.986 145.07 145.07 0 4.713 3.82 8.533 8.533 8.533s8.533-3.82 8.533-8.533c-0.099-89.503-72.63-162.04-162.13-162.13-4.713 0-8.533 3.82-8.533 8.533s3.82 8.533 8.533 8.533z"></path>
                        <path d="m291.16 137.59c51.816 0.061 93.806 42.051 93.867 93.867 0 4.713 3.821 8.533 8.533 8.533 4.713 0 8.533-3.82 8.533-8.533-0.071-61.238-49.696-110.86-110.93-110.93-4.713 0-8.533 3.82-8.533 8.533s3.82 8.533 8.533 8.533z"></path>
                        <path d="m291.16 188.79c23.552 0.028 42.638 19.114 42.667 42.667 0 4.713 3.821 8.533 8.533 8.533s8.533-3.82 8.533-8.533c-0.038-32.974-26.759-59.696-59.733-59.733-4.713 0-8.533 3.82-8.533 8.533s3.82 8.533 8.533 8.533z"></path>
                  </g>
                  </svg></a>
                </span>
                <span class="<?=$identity->check_mail ? 'first' : 'second'?>-person-socials">
                  <a href="mailto:<?=$identity->email?>">
                    <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                    <path d="M467,61H45C20.218,61,0,81.196,0,106v300c0,24.72,20.128,45,45,45h422c24.72,0,45-20.128,45-45V106    C512,81.28,491.872,61,467,61z M460.786,91L256.954,294.833L51.359,91H460.786z M30,399.788V112.069l144.479,143.24L30,399.788z     M51.213,421l144.57-144.57l50.657,50.222c5.864,5.814,15.327,5.795,21.167-0.046L317,277.213L460.787,421H51.213z M482,399.787    L338.213,256L482,112.212V399.787z"></path>
                    </svg>
                  </a>
                </span>
                <span class="<?=$identity->check_passport ? 'first' : 'second'?>-person-socials">PASS</span>
                <span class="<?=$identity->check_car ? 'first' : 'second'?>-person-socials">
                  <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                        <g>
                          <g>
                            <path d="M119.467,337.067c-28.237,0-51.2,22.963-51.2,51.2c0,28.237,22.963,51.2,51.2,51.2s51.2-22.963,51.2-51.2
                              C170.667,360.03,147.703,337.067,119.467,337.067z M119.467,422.4c-18.825,0-34.133-15.309-34.133-34.133
                              c0-18.825,15.309-34.133,34.133-34.133s34.133,15.309,34.133,34.133C153.6,407.091,138.291,422.4,119.467,422.4z"></path>
                          </g>                        </g>                       <g>
                          <g>
                            <path d="M409.6,337.067c-28.237,0-51.2,22.963-51.2,51.2c0,28.237,22.963,51.2,51.2,51.2c28.237,0,51.2-22.963,51.2-51.2
                              C460.8,360.03,437.837,337.067,409.6,337.067z M409.6,422.4c-18.825,0-34.133-15.309-34.133-34.133
                              c0-18.825,15.309-34.133,34.133-34.133c18.825,0,34.133,15.309,34.133,34.133C443.733,407.091,428.425,422.4,409.6,422.4z"></path>
                          </g>
                        </g>                       <g>                          <g>                            <path d="M510.643,289.784l-76.8-119.467c-1.57-2.441-4.275-3.917-7.177-3.917H332.8c-4.719,0-8.533,3.823-8.533,8.533v213.333
                              c0,4.719,3.814,8.533,8.533,8.533h34.133v-17.067h-25.6V183.467h80.674l72.926,113.442v82.825h-42.667V396.8h51.2
                              c4.719,0,8.533-3.814,8.533-8.533V294.4C512,292.77,511.531,291.157,510.643,289.784z"></path>
                          </g>                        </g>
                        <g>                          <g>                            <path d="M375.467,277.333V217.6h68.267v-17.067h-76.8c-4.719,0-8.533,3.823-8.533,8.533v76.8c0,4.719,3.814,8.533,8.533,8.533h128
                              v-17.067H375.467z"></path>
                          </g>
                        </g>                        <g>
                          <g>                            <path d="M332.8,106.667H8.533C3.823,106.667,0,110.49,0,115.2v273.067c0,4.719,3.823,8.533,8.533,8.533H76.8v-17.067H17.067v-256
                              h307.2v256H162.133V396.8H332.8c4.719,0,8.533-3.814,8.533-8.533V115.2C341.333,110.49,337.519,106.667,332.8,106.667z"></path>
                          </g>
                        </g>
                        <g>                          <g>
                            <rect x="8.533" y="345.6" width="51.2" height="17.067"></rect>
                          </g>
                        </g>
                        <g>                          <g>
                            <rect x="179.2" y="345.6" width="145.067" height="17.067"></rect>
                          </g>
                        </g>
                        <g>
                          <g>
                            <rect x="469.333" y="345.6" width="34.133" height="17.067"></rect>
                          </g>
                        </g>
                        <g>
                          <g>
                            <rect x="34.133" y="140.8" width="298.667" height="17.067"></rect>
                          </g>
                        </g>
                        <g>                          <g>
                            <rect x="110.933" y="379.733" width="17.067" height="17.067"></rect>
                          </g>
                        </g>
                        <g>
                          <g>
                            <rect x="401.067" y="379.733" width="17.067" height="17.067"></rect>
                          </g>
                        </g>                        <g>
                          <g>
                            <rect x="34.133" y="72.533" width="119.467" height="17.067"></rect>
                          </g>
                        </g>
                        <g>
                          <g>
                            <rect y="72.533" width="17.067" height="17.067"></rect>  </g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                  </svg>
                </span>
                <span class="<?=$identity->instagram ? 'first' : 'second'?>-person-socials">
                  <a href="<?=$identity->instagram?>" target="_blank">
                    <svg height="682pt" viewBox="-23 -21 682 682.66669" width="682pt" xmlns="http://www.w3.org/2000/svg"><path d="m544.386719 93.007812c-59.875-59.945312-139.503907-92.9726558-224.335938-93.007812-174.804687 0-317.070312 142.261719-317.140625 317.113281-.023437 55.894531 14.578125 110.457031 42.332032 158.550781l-44.992188 164.335938 168.121094-44.101562c46.324218 25.269531 98.476562 38.585937 151.550781 38.601562h.132813c174.785156 0 317.066406-142.273438 317.132812-317.132812.035156-84.742188-32.921875-164.417969-92.800781-224.359376zm-224.335938 487.933594h-.109375c-47.296875-.019531-93.683594-12.730468-134.160156-36.742187l-9.621094-5.714844-99.765625 26.171875 26.628907-97.269531-6.269532-9.972657c-26.386718-41.96875-40.320312-90.476562-40.296875-140.28125.054688-145.332031 118.304688-263.570312 263.699219-263.570312 70.40625.023438 136.589844 27.476562 186.355469 77.300781s77.15625 116.050781 77.132812 186.484375c-.0625 145.34375-118.304687 263.59375-263.59375 263.59375zm144.585938-197.417968c-7.921875-3.96875-46.882813-23.132813-54.148438-25.78125-7.257812-2.644532-12.546875-3.960938-17.824219 3.96875-5.285156 7.929687-20.46875 25.78125-25.09375 31.066406-4.625 5.289062-9.242187 5.953125-17.167968 1.984375-7.925782-3.964844-33.457032-12.335938-63.726563-39.332031-23.554687-21.011719-39.457031-46.960938-44.082031-54.890626-4.617188-7.9375-.039062-11.8125 3.476562-16.171874 8.578126-10.652344 17.167969-21.820313 19.808594-27.105469 2.644532-5.289063 1.320313-9.917969-.664062-13.882813-1.976563-3.964844-17.824219-42.96875-24.425782-58.839844-6.4375-15.445312-12.964843-13.359374-17.832031-13.601562-4.617187-.230469-9.902343-.277344-15.1875-.277344-5.28125 0-13.867187 1.980469-21.132812 9.917969-7.261719 7.933594-27.730469 27.101563-27.730469 66.105469s28.394531 76.683594 32.355469 81.972656c3.960937 5.289062 55.878906 85.328125 135.367187 119.648438 18.90625 8.171874 33.664063 13.042968 45.175782 16.695312 18.984374 6.03125 36.253906 5.179688 49.910156 3.140625 15.226562-2.277344 46.878906-19.171875 53.488281-37.679687 6.601563-18.511719 6.601563-34.375 4.617187-37.683594-1.976562-3.304688-7.261718-5.285156-15.183593-9.253906zm0 0" fill-rule="evenodd"/></svg>
                </a>
                </span>
                <span class="<?=$identity->web_site ? 'first' : 'second'?>-person-socials">
                  <a href="<?=$identity->web_site?>" target="_blank">
                    <svg enable-background="new 0 0 58 58" version="1.1" viewBox="0 0 58 58" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                    <path d="m50.688 48.222c4.544-5.121 7.312-11.853 7.312-19.222 0-7.667-2.996-14.643-7.872-19.834v-1e-3c-4e-3 -6e-3 -0.01-8e-3 -0.013-0.013-5.079-5.399-12.195-8.855-20.11-9.126l-1e-3 -1e-3 -0.565-0.015c-0.146-5e-3 -0.292-0.01-0.439-0.01s-0.293 5e-3 -0.439 0.01l-0.563 0.015-1e-3 1e-3c-7.915 0.271-15.031 3.727-20.11 9.126-4e-3 5e-3 -0.01 7e-3 -0.013 0.013 0 0 0 1e-3 -1e-3 2e-3 -4.877 5.19-7.873 12.166-7.873 19.833 0 7.369 2.768 14.101 7.312 19.222 6e-3 9e-3 6e-3 0.019 0.013 0.028 0.018 0.025 0.044 0.037 0.063 0.06 5.106 5.708 12.432 9.385 20.608 9.665l1e-3 1e-3 0.563 0.015c0.147 4e-3 0.293 9e-3 0.44 9e-3s0.293-5e-3 0.439-0.01l0.563-0.015 1e-3 -1e-3c8.185-0.281 15.519-3.965 20.625-9.685 0.013-0.017 0.034-0.022 0.046-0.04 8e-3 -8e-3 8e-3 -0.018 0.014-0.027zm-48.663-18.222h12.003c0.113 4.239 0.941 8.358 2.415 12.217-2.844 1.029-5.563 2.409-8.111 4.131-3.747-4.457-6.079-10.138-6.307-16.348zm6.853-18.977c2.488 1.618 5.137 2.914 7.9 3.882-1.692 4.107-2.628 8.535-2.75 13.095h-12.003c0.239-6.507 2.787-12.432 6.853-16.977zm47.097 16.977h-12.003c-0.122-4.56-1.058-8.988-2.75-13.095 2.763-0.968 5.412-2.264 7.9-3.882 4.066 4.545 6.614 10.47 6.853 16.977zm-27.975-13.037c-2.891-0.082-5.729-0.513-8.471-1.283 2.027-4.158 4.889-7.911 8.471-11.036v12.319zm0 2v11.037h-11.972c0.123-4.348 1.035-8.565 2.666-12.475 3.006 0.871 6.127 1.353 9.306 1.438zm2 0c3.179-0.085 6.3-0.566 9.307-1.438 1.631 3.91 2.543 8.127 2.666 12.475h-11.973v-11.037zm0-2v-12.319c3.582 3.125 6.444 6.878 8.471 11.036-2.742 0.77-5.58 1.201-8.471 1.283zm10.409-1.891c-1.921-4.025-4.587-7.692-7.888-10.835 5.856 0.766 11.125 3.414 15.183 7.318-2.304 1.462-4.748 2.638-7.295 3.517zm-22.818 0c-2.547-0.879-4.991-2.055-7.294-3.517 4.057-3.904 9.327-6.552 15.183-7.318-3.302 3.143-5.968 6.81-7.889 10.835zm-1.563 16.928h11.972v10.038c-3.307 0.088-6.547 0.604-9.661 1.541-1.407-3.655-2.198-7.56-2.311-11.579zm11.972 12.038v13.318c-3.834-3.345-6.84-7.409-8.884-11.917 2.867-0.845 5.845-1.315 8.884-1.401zm2 13.318v-13.318c3.039 0.085 6.017 0.556 8.884 1.4-2.044 4.509-5.05 8.573-8.884 11.918zm0-15.318v-10.038h11.972c-0.113 4.019-0.904 7.924-2.312 11.58-3.113-0.938-6.353-1.454-9.66-1.542zm13.972-10.038h12.003c-0.228 6.21-2.559 11.891-6.307 16.348-2.548-1.722-5.267-3.102-8.111-4.131 1.475-3.859 2.302-7.978 2.415-12.217zm-34.281 17.846c2.366-1.572 4.885-2.836 7.517-3.781 1.945 4.36 4.737 8.333 8.271 11.698-6.151-0.805-11.656-3.685-15.788-7.917zm22.83 7.917c3.534-3.364 6.326-7.337 8.271-11.698 2.632 0.945 5.15 2.209 7.517 3.781-4.132 4.232-9.637 7.112-15.788 7.917z"></path>
                  </svg>
                </a>
                </span>
                <span class="<?=$identity->facebook ? 'first' : 'second'?>-person-socials">
                  <a href="<?=$identity->facebook?>" target="_blank">
                  <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                      <path d="M288,176v-64c0-17.664,14.336-32,32-32h32V0h-64c-53.024,0-96,42.976-96,96v80h-64v80h64v256h96V256h64l32-80H288z"></path>
                  </svg>
                  </a>
                </span>
                <span class="<?=$identity->telegram != null ? 'first' : 'second'?>-person-socials">
                  <a href="<?=$identity->telegram?>" target="_blank">
                  <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m9.417 15.181-.397 5.584c.568 0 .814-.244 1.109-.537l2.663-2.545 5.518 4.041c1.012.564 1.725.267 1.998-.931l3.622-16.972.001-.001c.321-1.496-.541-2.081-1.527-1.714l-21.29 8.151c-1.453.564-1.431 1.374-.247 1.741l5.443 1.693 12.643-7.911c.595-.394 1.136-.176.691.218z"></path></svg>
                </a>
                </span>                
              </div>
            </div>
          </div>
          <div class="about-main-user-right">
            <a href="/profile/edit" class="link-template-img">
              <span>
                <svg height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m256 133.609375c-67.484375 0-122.390625 54.90625-122.390625 122.390625s54.90625 122.390625 122.390625 122.390625 122.390625-54.90625 122.390625-122.390625-54.90625-122.390625-122.390625-122.390625zm0 214.183594c-50.613281 0-91.792969-41.179688-91.792969-91.792969s41.179688-91.792969 91.792969-91.792969 91.792969 41.179688 91.792969 91.792969-41.179688 91.792969-91.792969 91.792969zm0 0"></path><path d="m499.953125 197.703125-39.351563-8.554687c-3.421874-10.476563-7.660156-20.695313-12.664062-30.539063l21.785156-33.886719c3.890625-6.054687 3.035156-14.003906-2.050781-19.089844l-61.304687-61.304687c-5.085938-5.085937-13.035157-5.941406-19.089844-2.050781l-33.886719 21.785156c-9.84375-5.003906-20.0625-9.242188-30.539063-12.664062l-8.554687-39.351563c-1.527344-7.03125-7.753906-12.046875-14.949219-12.046875h-86.695312c-7.195313 0-13.421875 5.015625-14.949219 12.046875l-8.554687 39.351563c-10.476563 3.421874-20.695313 7.660156-30.539063 12.664062l-33.886719-21.785156c-6.054687-3.890625-14.003906-3.035156-19.089844 2.050781l-61.304687 61.304687c-5.085937 5.085938-5.941406 13.035157-2.050781 19.089844l21.785156 33.886719c-5.003906 9.84375-9.242188 20.0625-12.664062 30.539063l-39.351563 8.554687c-7.03125 1.53125-12.046875 7.753906-12.046875 14.949219v86.695312c0 7.195313 5.015625 13.417969 12.046875 14.949219l39.351563 8.554687c3.421874 10.476563 7.660156 20.695313 12.664062 30.539063l-21.785156 33.886719c-3.890625 6.054687-3.035156 14.003906 2.050781 19.089844l61.304687 61.304687c5.085938 5.085937 13.035157 5.941406 19.089844 2.050781l33.886719-21.785156c9.84375 5.003906 20.0625 9.242188 30.539063 12.664062l8.554687 39.351563c1.527344 7.03125 7.753906 12.046875 14.949219 12.046875h86.695312c7.195313 0 13.421875-5.015625 14.949219-12.046875l8.554687-39.351563c10.476563-3.421874 20.695313-7.660156 30.539063-12.664062l33.886719 21.785156c6.054687 3.890625 14.003906 3.039063 19.089844-2.050781l61.304687-61.304687c5.085937-5.085938 5.941406-13.035157 2.050781-19.089844l-21.785156-33.886719c5.003906-9.84375 9.242188-20.0625 12.664062-30.539063l39.351563-8.554687c7.03125-1.53125 12.046875-7.753906 12.046875-14.949219v-86.695312c0-7.195313-5.015625-13.417969-12.046875-14.949219zm-18.550781 89.3125-36.082032 7.84375c-5.542968 1.207031-9.964843 5.378906-11.488281 10.839844-3.964843 14.222656-9.667969 27.976562-16.949219 40.878906-2.789062 4.941406-2.617187 11.019531.453126 15.792969l19.980468 31.078125-43.863281 43.867187-31.082031-19.980468c-4.773438-3.070313-10.851563-3.242188-15.789063-.453126-12.90625 7.28125-26.660156 12.984376-40.882812 16.949219-5.460938 1.523438-9.632813 5.945313-10.839844 11.488281l-7.84375 36.082032h-62.03125l-7.84375-36.082032c-1.207031-5.542968-5.378906-9.964843-10.839844-11.488281-14.222656-3.964843-27.976562-9.667969-40.878906-16.949219-4.941406-2.789062-11.019531-2.613281-15.792969.453126l-31.078125 19.980468-43.863281-43.867187 19.976562-31.078125c3.070313-4.773438 3.246094-10.851563.457032-15.792969-7.28125-12.902344-12.984375-26.65625-16.953125-40.878906-1.523438-5.460938-5.941407-9.632813-11.484375-10.839844l-36.085938-7.84375v-62.03125l36.082032-7.84375c5.542968-1.207031 9.964843-5.378906 11.488281-10.839844 3.964843-14.222656 9.667969-27.976562 16.949219-40.878906 2.789062-4.941406 2.617187-11.019531-.453126-15.792969l-19.980468-31.078125 43.863281-43.867187 31.082031 19.980468c4.773438 3.070313 10.851563 3.242188 15.789063.453126 12.90625-7.28125 26.660156-12.984376 40.882812-16.949219 5.460938-1.523438 9.632813-5.945313 10.839844-11.488281l7.84375-36.082032h62.03125l7.84375 36.082032c1.207031 5.542968 5.378906 9.964843 10.839844 11.488281 14.222656 3.964843 27.976562 9.667969 40.878906 16.949219 4.941406 2.789062 11.019531 2.613281 15.792969-.453126l31.078125-19.980468 43.863281 43.867187-19.976562 31.078125c-3.070313 4.773438-3.246094 10.851563-.457032 15.792969 7.285156 12.902344 12.984375 26.65625 16.953125 40.878906 1.523438 5.460938 5.941407 9.632813 11.484375 10.839844l36.085938 7.84375zm0 0"></path></svg>
              </span><?= Yii::t('app',"Profilni tahrirlash") ?>
            </a>
            <div class="my-catalog-block">
              <a href="/profile/catalog?login=<?=$identity->login?>" class="btn-template link-btn"><?= Yii::t('app',"Mening katalogim") ?></a>
              <a href="/chat" class="btn-template link-btn"><?= Yii::t('app',"Mening chatim") ?>
                <div class="chat_message_count"><?=$identity->getChatMessageCount()?></div>
              </a>
            </div>
            <div class="ratings">
              <b><?= Yii::t('app',"Reyting") ?>:</b>
              <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?=$identity->getReyting()?></div>
              </div>
            </div>
            <div class="ratings border-bottom-stars">
              <b><?= Yii::t('app',"Ishonch") ?>:</b>
              <div class="star-block">
                <b><?=$identity->getStarCount()?>/5</b>
                <div class="star-rating">
                  <span style="width:<?=$identity->getStarCount() / 5 * 100?>%"></span>
                </div>
              </div>
            </div>
            <div class="add-summ">
              <span><?=$identity->balance?> UZS</span>
              <a href="/profile/replenish">
                <svg height="448pt" viewBox="0 0 448 448" width="448pt" xmlns="http://www.w3.org/2000/svg"><path d="m272 184c-4.417969 0-8-3.582031-8-8v-176h-80v176c0 4.417969-3.582031 8-8 8h-176v80h176c4.417969 0 8 3.582031 8 8v176h80v-176c0-4.417969 3.582031-8 8-8h176v-80zm0 0"></path></svg>
              </a>
            </div>
          </div>
        </div>

<?php 
$this->registerJs(<<<JS
    $(document).ready(function(){
        $(function(){        
            $(document).on('drop dragover', function (e) { e.preventDefault(); });
            $('input[name^=\'ad1\']').on('change', fileUpload); 
        });

        function fileUpload(event){
            files = event.target.files;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if(!file.type.match('image.*')) {              
                    //check file type
                    $("#write").html("Пожалуйста, выберите файл изображения.");
                    $('#user_avatar').hide(); 
                }
                else {
                    var fileCollection = new Array();
                    fileCollection.push(file);
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function(e) {
                        var template = '<img id="image_upload_preview" src="'+e.target.result+'">';
                        $('#user_logo_file$identity->id').html('');
                        $('#user_logo_file$identity->id').append(template);
                    }
                }
            }
        }

        $('#ad1').on('change', function() {  
            $('#user_avatar').show(); 
        });
  });
JS
);
?>