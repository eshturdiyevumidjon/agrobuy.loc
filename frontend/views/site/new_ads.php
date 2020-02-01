        <h2 class="title">
          <?php 
              $text = explode(' ', Yii::t('app',"Yangi e'lonlar"));
              $res = '';
              foreach ($text as $key => $value) {
                if($key === 0) $res = '<span>' . $value . '</span>';
                else $res .= ' ' . $value;
              }
              echo $res;
            ?>
        </h2>
        <div class="row has-item-product">
          <div class="col-xl-3 col-lg-4 col-6">
            <div class="item-product">
              <span class="star-item">
                <img src="/images/star-free.png" alt="">
                <img src="/images/star-full.png" alt="">
              </span>
              <a href="#">
                <div class="item-product-img">
                  <img src="/images/mushroom.jpg" alt="">
                </div>
                <h3>Шампиньоны</h3>
                <p>Категория: <span>овощи</span></p>
                <div class="discount">
                  <s>129 000 руб.</s>
                  <b>100 000 руб.</b>
                </div>
                <div class="address-item-product">
                  Пенза, Пензенская область, Россия
                </div>
                <div class="block-id-product">
                  <span>01.01.2019</span>
                  <span>№:  0865438</span>
                </div>
              </a>              
            </div>
          </div>
          <div class="col-xl-3 col-lg-4 col-6">
            <div class="item-product">
              <span class="star-item">
                <img src="/images/star-free.png" alt="">
                <img src="/images/star-full.png" alt="">
              </span>
              <a href="#">
                <div class="item-product-img">
                  <img src="/images/razz.jpg" alt="">
                </div>
                <h3>Малина</h3>
                <p>Категория: <span>фрукты</span></p>
                <div class="discount">
                  <s>129 000 руб.</s>
                  <b>100 000 руб.</b>
                </div>
                <div class="address-item-product">
                  Пенза, Пензенская область, Россия
                </div>
                <div class="block-id-product">
                  <span>01.01.2019</span>
                  <span>№:  0865438</span>
                </div>
              </a>              
            </div>
          </div>
          <div class="col-xl-3 col-lg-4 col-6">
            <div class="item-product">
              <span class="star-item">
                <img src="/images/star-free.png" alt="">
                <img src="/images/star-full.png" alt="">
              </span>
              <a href="#">
                <div class="item-product-img">
                  <img src="/images/wheat.jpg" alt="">
                </div>
                <h3>Пшеница</h3>
                <p>Категория: <span>зерно</span></p>
                <div class="discount">
                  <s>129 000 руб.</s>
                  <b>100 000 руб.</b>
                </div>
                <div class="address-item-product">
                  Пенза, Пензенская область, Россия
                </div>
                <div class="block-id-product">
                  <span>01.01.2019</span>
                  <span>№:  0865438</span>
                </div>
              </a>              
            </div>
          </div>
          <div class="col-xl-3 col-lg-4 col-6">
            <div class="item-product">
              <span class="star-item">
                <img src="/images/star-free.png" alt="">
                <img src="/images/star-full.png" alt="">
              </span>
              <a href="#">
                <div class="item-product-img">
                  <img src="/images/fishs.jpg" alt="">
                </div>
                <h3>Скумбрия</h3>
                <p>Категория: <span>мясо и рыба</span></p>
                <div class="discount">
                  <s>129 000 руб.</s>
                  <b>100 000 руб.</b>
                </div>
                <div class="address-item-product">
                  Пенза, Пензенская область, Россия
                </div>
                <div class="block-id-product">
                  <span>01.01.2019</span>
                  <span>№:  0865438</span>
                </div>
              </a>              
            </div>
          </div>
        </div>