<nav aria-label="breadcrumb" class="breadcrumb-top">
    <ol class="breadcrumb container">
        <li class="breadcrumb-item"><a href="#">Главная </a><img src="/images/right-arrow-green.png" alt=""></li>
        <li class="breadcrumb-item active" aria-current="page">Личный кабинет</li>
    </ol>
</nav>
     

<section class="personal-area">
      <div class="container">
        <?= $this->render('main-block-user', [
	        'nowLanguage' => $nowLanguage,
	        'identity' => $identity,
	    ]) ?>
        <div class="personal-tab">
          <ul class="nav nav-tabs">
            <li><a href="#firsttab" data-toggle="tab" class="active">Мои объявления</a></li>
            <li><a href="#secondtab" data-toggle="tab">Избранное</a></li>
            <li><a href="#thirdtab" data-toggle="tab">Платные услуги</a></li>
            <li><a href="#fourthtab" data-toggle="tab">История операций</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane in active" id="firsttab">
              <div class="tab-my-ads">
                <div class="row">
                  <div class="col-xl-3 col-lg-4 col-6">
                    <div class="item-product">
                      <span class="star-item">
                        <img src="/images/star-free.png" alt="">
                        <img src="/images/star-full.png" alt="">
                      </span>
                      <div class="dropdown-person">
                        <button type="button" class="" data-toggle="dropdown">
                          <!--?xml version="1.0" encoding="UTF-8"?-->
                          <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="256" cy="256" r="64"></circle>
                                <circle cx="256" cy="448" r="64"></circle>
                                <circle cx="256" cy="64" r="64"></circle>
                          </svg>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Редактировать объявление</a>
                          <a class="dropdown-item" href="#">Продвинуть</a>
                          <a class="dropdown-item" href="#">Деактивировать/активировать</a>
                          <a class="dropdown-item" href="#">Удалить объявление</a>
                          <a class="dropdown-item" href="#">Добавить/удалить объявление в/из”мой каталог”</a>
                        </div>
                      </div>
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
                      <div class="dropdown-person">
                        <button type="button" class="" data-toggle="dropdown">
                          <!--?xml version="1.0" encoding="UTF-8"?-->
                          <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="256" cy="256" r="64"></circle>
                                <circle cx="256" cy="448" r="64"></circle>
                                <circle cx="256" cy="64" r="64"></circle>
                          </svg>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Редактировать объявление</a>
                          <a class="dropdown-item" href="#">Продвинуть</a>
                          <a class="dropdown-item" href="#">Деактивировать/активировать</a>
                          <a class="dropdown-item" href="#">Удалить объявление</a>
                          <a class="dropdown-item" href="#">Добавить/удалить объявление в/из”мой каталог”</a>
                        </div>
                      </div>
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
                      <div class="dropdown-person">
                        <button type="button" class="" data-toggle="dropdown">
                          <!--?xml version="1.0" encoding="UTF-8"?-->
                          <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="256" cy="256" r="64"></circle>
                                <circle cx="256" cy="448" r="64"></circle>
                                <circle cx="256" cy="64" r="64"></circle>
                          </svg>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Редактировать объявление</a>
                          <a class="dropdown-item" href="#">Продвинуть</a>
                          <a class="dropdown-item" href="#">Деактивировать/активировать</a>
                          <a class="dropdown-item" href="#">Удалить объявление</a>
                          <a class="dropdown-item" href="#">Добавить/удалить объявление в/из”мой каталог”</a>
                        </div>
                      </div>
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
                      <div class="dropdown-person">
                        <button type="button" class="" data-toggle="dropdown">
                          <!--?xml version="1.0" encoding="UTF-8"?-->
                          <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="256" cy="256" r="64"></circle>
                                <circle cx="256" cy="448" r="64"></circle>
                                <circle cx="256" cy="64" r="64"></circle>
                          </svg>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Редактировать объявление</a>
                          <a class="dropdown-item" href="#">Продвинуть</a>
                          <a class="dropdown-item" href="#">Деактивировать/активировать</a>
                          <a class="dropdown-item" href="#">Удалить объявление</a>
                          <a class="dropdown-item" href="#">Добавить/удалить объявление в/из”мой каталог”</a>
                        </div>
                      </div>
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
                      <div class="dropdown-person">
                        <button type="button" class="" data-toggle="dropdown">
                          <!--?xml version="1.0" encoding="UTF-8"?-->
                          <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="256" cy="256" r="64"></circle>
                                <circle cx="256" cy="448" r="64"></circle>
                                <circle cx="256" cy="64" r="64"></circle>
                          </svg>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Редактировать объявление</a>
                          <a class="dropdown-item" href="#">Продвинуть</a>
                          <a class="dropdown-item" href="#">Деактивировать/активировать</a>
                          <a class="dropdown-item" href="#">Удалить объявление</a>
                          <a class="dropdown-item" href="#">Добавить/удалить объявление в/из”мой каталог”</a>
                        </div>
                      </div>
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
                      <div class="dropdown-person">
                        <button type="button" class="" data-toggle="dropdown">
                          <!--?xml version="1.0" encoding="UTF-8"?-->
                          <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="256" cy="256" r="64"></circle>
                                <circle cx="256" cy="448" r="64"></circle>
                                <circle cx="256" cy="64" r="64"></circle>
                          </svg>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Редактировать объявление</a>
                          <a class="dropdown-item" href="#">Продвинуть</a>
                          <a class="dropdown-item" href="#">Деактивировать/активировать</a>
                          <a class="dropdown-item" href="#">Удалить объявление</a>
                          <a class="dropdown-item" href="#">Добавить/удалить объявление в/из”мой каталог”</a>
                        </div>
                      </div>
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
                </div>
                <nav aria-label="Page navigation example" class="my-nav-bottom">
                  <ul class="pagination">
                    <li class="page-item">
                      <a class="page-link disabled" href="#" aria-label="Next">
                        <!--?xml version="1.0" encoding="UTF-8"?-->
                        
                        <svg enable-background="new 0 0 444.531 444.531" version="1.1" viewBox="0 0 444.53 444.53" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                          <path d="m213.13 222.41 138.75-138.76c7.05-7.043 10.567-15.657 10.567-25.841 0-10.183-3.518-18.793-10.567-25.835l-21.409-21.416c-7.039-7.04-15.654-10.561-25.834-10.561s-18.791 3.521-25.841 10.561l-186.15 185.86c-7.044 7.043-10.566 15.656-10.566 25.841s3.521 18.791 10.566 25.837l186.15 185.86c7.05 7.043 15.66 10.564 25.841 10.564s18.795-3.521 25.834-10.564l21.409-21.412c7.05-7.039 10.567-15.604 10.567-25.697 0-10.085-3.518-18.746-10.567-25.978l-138.75-138.47z"></path>
                        </svg>
                      </a>
                    </li>
                    <li class="page-item"><a class="page-link active" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                    <li class="page-item"><a class="page-link" href="#">6</a></li>
                    <li class="page-item"><a class="page-link" href="#">7</a></li>
                    <li class="page-item"><a class="page-link" href="#">8</a></li>
                    <li class="page-item"><a class="page-link" href="#">9</a></li>
                    <li class="page-item"><a class="page-link" href="#">10</a></li>
                    <li class="page-item">
                      <a class="page-link" href="#" aria-label="Previous">
                        <!--?xml version="1.0" encoding="UTF-8"?-->
                        
                        <svg enable-background="new 0 0 46.02 46.02" version="1.1" viewBox="0 0 46.02 46.02" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                            <path d="m14.757 46.02c-1.412 0-2.825-0.521-3.929-1.569-2.282-2.17-2.373-5.78-0.204-8.063l12.758-13.418-12.745-13.325c-2.177-2.275-2.097-5.885 0.179-8.063 2.277-2.178 5.886-2.097 8.063 0.179l16.505 17.253c2.104 2.2 2.108 5.665 0.013 7.872l-16.504 17.361c-1.123 1.177-2.626 1.773-4.136 1.773z"></path>
                        </svg>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
            <div class="tab-pane fade" id="secondtab">
              <div class="tab-my-ads">
                <div class="row">
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
                </div>
                <nav aria-label="Page navigation example" class="my-nav-bottom">
                  <ul class="pagination">
                    <li class="page-item">
                      <a class="page-link disabled" href="#" aria-label="Next">
                        <!--?xml version="1.0" encoding="UTF-8"?-->
                        
                        <svg enable-background="new 0 0 444.531 444.531" version="1.1" viewBox="0 0 444.53 444.53" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                          <path d="m213.13 222.41 138.75-138.76c7.05-7.043 10.567-15.657 10.567-25.841 0-10.183-3.518-18.793-10.567-25.835l-21.409-21.416c-7.039-7.04-15.654-10.561-25.834-10.561s-18.791 3.521-25.841 10.561l-186.15 185.86c-7.044 7.043-10.566 15.656-10.566 25.841s3.521 18.791 10.566 25.837l186.15 185.86c7.05 7.043 15.66 10.564 25.841 10.564s18.795-3.521 25.834-10.564l21.409-21.412c7.05-7.039 10.567-15.604 10.567-25.697 0-10.085-3.518-18.746-10.567-25.978l-138.75-138.47z"></path>
                        </svg>
                      </a>
                    </li>
                    <li class="page-item"><a class="page-link active" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                    <li class="page-item"><a class="page-link" href="#">6</a></li>
                    <li class="page-item"><a class="page-link" href="#">7</a></li>
                    <li class="page-item"><a class="page-link" href="#">8</a></li>
                    <li class="page-item"><a class="page-link" href="#">9</a></li>
                    <li class="page-item"><a class="page-link" href="#">10</a></li>
                    <li class="page-item">
                      <a class="page-link" href="#" aria-label="Previous">
                        <!--?xml version="1.0" encoding="UTF-8"?-->
                        
                        <svg enable-background="new 0 0 46.02 46.02" version="1.1" viewBox="0 0 46.02 46.02" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                            <path d="m14.757 46.02c-1.412 0-2.825-0.521-3.929-1.569-2.282-2.17-2.373-5.78-0.204-8.063l12.758-13.418-12.745-13.325c-2.177-2.275-2.097-5.885 0.179-8.063 2.277-2.178 5.886-2.097 8.063 0.179l16.505 17.253c2.104 2.2 2.108 5.665 0.013 7.872l-16.504 17.361c-1.123 1.177-2.626 1.773-4.136 1.773z"></path>
                        </svg>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
            <div class="tab-pane fade" id="thirdtab">
              <div class="puy-tab-person">
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
            </div>
            <div class="tab-pane fade" id="fourthtab">
              <div class="operation-history">
                <div class="history-title">
                  <div>Операция</div>
                  <div>Дата и время</div>
                  <div>№ объявления</div>
                  <div>Сумма</div>
                </div>
                <div class="history-body">
                  <div class="history-body-item">
                    <div>Пополнение счета</div>
                    <div>01.01.2020 <span class="ascii-dot"></span> 20:48</div>
                    <div></div>
                    <div>50 000 сумма</div>
                  </div>
                  <div class="history-body-item">
                    <div class="greens">
                      <div class="prem-vip-discount">7 дней</div>
                      <img src="/images/vip.png" alt="">
                    </div>
                    <div>01.01.2020 <span class="ascii-dot"></span> 20:48</div>
                    <div>№ 596 8647</div>
                    <div>50 000 сумма</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>