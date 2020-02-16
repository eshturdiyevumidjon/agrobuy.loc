<?php

    use yii\helpers\Html;
    use yii\widgets\LinkPager;
?>

<section class="news-section">
    <div class="container">
        <div class="swiper-container reclama">
            <div class="swiper-wrapper">
                <?php foreach ($reklama as $value) { ?>
                    <a href="<?=$value->link?>" class="swiper-slide" data-swiper-autoplay="<?=$value->advertising->time * 1000 ?>">
                        <img src="<?=$value->getImage('main_page')?>" alt="<?=$value->title?>">
                    </a>
                <?php } ?>
            </div>
        </div>
        <form class="form-search" style="display: none;">
            <div class="form-group select2-style">
                <select class="js-select2">
                    <option>Категория</option>
                    <option>Select B</option>
                    <option>Select C</option>
                    <option>Select D</option>
                </select>
            </div>
            <div class="form-group d-none d-sm-block">
                <input type="text" class="form-control" placeholder="Введите запрос">
            </div>
            <div class="form-group select2-style">
                <select class="js-select2">
                    <option>Местоположение</option>
                    <option>Select B</option>
                    <option>Select C</option>
                    <option>Select D</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-template">Найти</button>
            </div>
        </form>
    </div>
</section>

<section class="swiper-news my-new-sect">
    <div class="container">
        <div class="row">
            <?php foreach ($dataProvider->getModels() as $model) { $value = $model->getOneModel();?>
            <div class="col-lg-4 col-sm-6">
                <a href="/news/view?id=<?=$value['id']?>">
                    <div class="new-slider-img">
                        <img src="<?=$value['image']?>" alt="<?=$value['title']?>">
                    </div>
                    <h3><?=$value['title']?></h3>
                    <p><?=$value['text']?></p>
                    <div class="news-date">
                        <?=$value['date']?>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
        <nav aria-label="Page navigation example" class="my-nav-bottom">
            <?= LinkPager::widget([
                'pagination' => $dataProvider->pagination,
                //Css option for container
                'options' => ['class' => 'pagination'],
                //First option value
                'firstPageLabel' => '<svg enable-background="new 0 0 444.531 444.531" version="1.1" viewBox="0 0 444.53 444.53" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                          <path d="m213.13 222.41 138.75-138.76c7.05-7.043 10.567-15.657 10.567-25.841 0-10.183-3.518-18.793-10.567-25.835l-21.409-21.416c-7.039-7.04-15.654-10.561-25.834-10.561s-18.791 3.521-25.841 10.561l-186.15 185.86c-7.044 7.043-10.566 15.656-10.566 25.841s3.521 18.791 10.566 25.837l186.15 185.86c7.05 7.043 15.66 10.564 25.841 10.564s18.795-3.521 25.834-10.564l21.409-21.412c7.05-7.039 10.567-15.604 10.567-25.697 0-10.085-3.518-18.746-10.567-25.978l-138.75-138.47z"></path>
                        </svg>',
                //Last option value
                'lastPageLabel' => '<svg enable-background="new 0 0 46.02 46.02" version="1.1" viewBox="0 0 46.02 46.02" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                            <path d="m14.757 46.02c-1.412 0-2.825-0.521-3.929-1.569-2.282-2.17-2.373-5.78-0.204-8.063l12.758-13.418-12.745-13.325c-2.177-2.275-2.097-5.885 0.179-8.063 2.277-2.178 5.886-2.097 8.063 0.179l16.505 17.253c2.104 2.2 2.108 5.665 0.013 7.872l-16.504 17.361c-1.123 1.177-2.626 1.773-4.136 1.773z"></path>
                        </svg>',
                //Previous option value
                'prevPageLabel' => 'prev',
                //Next option value
                'nextPageLabel' => 'next',
                //Current Active option value
                'activePageCssClass' => 'active',
                //Max count of allowed options
                'maxButtonCount' => 15,
                // Css for each options. Links
                'linkOptions' => ['class' => 'page-link'],
                'disabledPageCssClass' => 'disabled_last_next_button',
                // Customzing CSS class for navigating link
                'prevPageCssClass' => 'disabled_a',
                'nextPageCssClass' => 'disabled_a',
                'firstPageCssClass' => 'p-first',
                'lastPageCssClass' => 'p-last',
            ]);
            ?>
        </nav>
    </div>
</section>