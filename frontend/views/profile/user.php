<?php
    
use yii\widgets\LinkPager;
if(!Yii::$app->user->isGuest) $avt = true; 
else $avt = false;
?>

<section class="personal-area persen-second">
    <div class="container">
        <div class="block-main-user">
            <a class="img-main-user">
                <img src="<?=$identity->getAvatarForSite()?>" alt="">
            </a>
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
                                <svg enable-background="new 0 0 512.076 512.076" version="1.1" viewBox="0 0 512.08 512.08" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><g transform="translate(-1 -1)"><path d="m499.64 396.04-103.65-69.12c-13.153-8.701-30.784-5.838-40.508 6.579l-30.191 38.818c-3.88 5.116-10.933 6.6-16.546 3.482l-5.743-3.166c-19.038-10.377-42.726-23.296-90.453-71.04s-60.672-71.45-71.049-90.453l-3.149-5.743c-3.161-5.612-1.705-12.695 3.413-16.606l38.792-30.182c12.412-9.725 15.279-27.351 6.588-40.508l-69.12-103.65c-8.907-13.398-26.777-17.42-40.566-9.131l-43.341 26.035c-13.618 8.006-23.609 20.972-27.878 36.181-15.607 56.866-3.866 155.01 140.71 299.6 115 115 200.62 145.92 259.46 145.92 13.543 0.058 27.033-1.704 40.107-5.239 15.212-4.264 28.18-14.256 36.181-27.878l26.061-43.315c8.301-13.792 4.281-31.673-9.123-40.585zm-5.581 31.829-26.001 43.341c-5.745 9.832-15.072 17.061-26.027 20.173-52.497 14.413-144.21 2.475-283.01-136.32s-150.73-230.5-136.32-283.01c3.116-10.968 10.354-20.307 20.198-26.061l43.341-26.001c5.983-3.6 13.739-1.855 17.604 3.959l37.547 56.371 31.514 47.266c3.774 5.707 2.534 13.356-2.85 17.579l-38.801 30.182c-11.808 9.029-15.18 25.366-7.91 38.332l3.081 5.598c10.906 20.002 24.465 44.885 73.967 94.379 49.502 49.493 74.377 63.053 94.37 73.958l5.606 3.089c12.965 7.269 29.303 3.898 38.332-7.91l30.182-38.801c4.224-5.381 11.87-6.62 17.579-2.85l103.64 69.12c5.818 3.862 7.563 11.622 3.958 17.604z"/><path d="m291.16 86.39c80.081 0.089 144.98 64.986 145.07 145.07 0 4.713 3.82 8.533 8.533 8.533s8.533-3.82 8.533-8.533c-0.099-89.503-72.63-162.04-162.13-162.13-4.713 0-8.533 3.82-8.533 8.533s3.82 8.533 8.533 8.533z"/><path d="m291.16 137.59c51.816 0.061 93.806 42.051 93.867 93.867 0 4.713 3.821 8.533 8.533 8.533 4.713 0 8.533-3.82 8.533-8.533-0.071-61.238-49.696-110.86-110.93-110.93-4.713 0-8.533 3.82-8.533 8.533s3.82 8.533 8.533 8.533z"/><path d="m291.16 188.79c23.552 0.028 42.638 19.114 42.667 42.667 0 4.713 3.821 8.533 8.533 8.533s8.533-3.82 8.533-8.533c-0.038-32.974-26.759-59.696-59.733-59.733-4.713 0-8.533 3.82-8.533 8.533s3.82 8.533 8.533 8.533z"/></g>
                                </svg>
                            </a>
                        </span>
                        <span class="<?=$identity->check_mail ? 'first' : 'second'?>-person-socials">
                            <a href="mailto:<?=$identity->email?>">
                                <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M467,61H45C20.218,61,0,81.196,0,106v300c0,24.72,20.128,45,45,45h422c24.72,0,45-20.128,45-45V106    C512,81.28,491.872,61,467,61z M460.786,91L256.954,294.833L51.359,91H460.786z M30,399.788V112.069l144.479,143.24L30,399.788z     M51.213,421l144.57-144.57l50.657,50.222c5.864,5.814,15.327,5.795,21.167-0.046L317,277.213L460.787,421H51.213z M482,399.787    L338.213,256L482,112.212V399.787z"/>
                                </svg>
                            </a>
                        </span>
                        <span class="<?=$identity->check_passport ? 'first' : 'second'?>-person-socials">PASS</span>
                        <span class="<?=$identity->check_car ? 'first' : 'second'?>-person-socials">
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><path d="M119.467,337.067c-28.237,0-51.2,22.963-51.2,51.2c0,28.237,22.963,51.2,51.2,51.2s51.2-22.963,51.2-51.2
                              C170.667,360.03,147.703,337.067,119.467,337.067z M119.467,422.4c-18.825,0-34.133-15.309-34.133-34.133
                              c0-18.825,15.309-34.133,34.133-34.133s34.133,15.309,34.133,34.133C153.6,407.091,138.291,422.4,119.467,422.4z"/></g></g><g><g><path d="M409.6,337.067c-28.237,0-51.2,22.963-51.2,51.2c0,28.237,22.963,51.2,51.2,51.2c28.237,0,51.2-22.963,51.2-51.2
                              C460.8,360.03,437.837,337.067,409.6,337.067z M409.6,422.4c-18.825,0-34.133-15.309-34.133-34.133
                              c0-18.825,15.309-34.133,34.133-34.133c18.825,0,34.133,15.309,34.133,34.133C443.733,407.091,428.425,422.4,409.6,422.4z"/></g></g><g><g><path d="M510.643,289.784l-76.8-119.467c-1.57-2.441-4.275-3.917-7.177-3.917H332.8c-4.719,0-8.533,3.823-8.533,8.533v213.333
                              c0,4.719,3.814,8.533,8.533,8.533h34.133v-17.067h-25.6V183.467h80.674l72.926,113.442v82.825h-42.667V396.8h51.2
                              c4.719,0,8.533-3.814,8.533-8.533V294.4C512,292.77,511.531,291.157,510.643,289.784z"/>
                          </g>                        </g>
                        <g>                          <g>                            <path d="M375.467,277.333V217.6h68.267v-17.067h-76.8c-4.719,0-8.533,3.823-8.533,8.533v76.8c0,4.719,3.814,8.533,8.533,8.533h128
                              v-17.067H375.467z"/>
                          </g>
                        </g>                        <g>
                          <g>                            <path d="M332.8,106.667H8.533C3.823,106.667,0,110.49,0,115.2v273.067c0,4.719,3.823,8.533,8.533,8.533H76.8v-17.067H17.067v-256
                              h307.2v256H162.133V396.8H332.8c4.719,0,8.533-3.814,8.533-8.533V115.2C341.333,110.49,337.519,106.667,332.8,106.667z"/>
                          </g>
                        </g>
                        <g>                          <g>
                            <rect x="8.533" y="345.6" width="51.2" height="17.067"/>
                          </g>
                        </g>
                        <g>                          <g>
                            <rect x="179.2" y="345.6" width="145.067" height="17.067"/>
                          </g>
                        </g>
                        <g>
                          <g>
                            <rect x="469.333" y="345.6" width="34.133" height="17.067"/>
                          </g>
                        </g>
                        <g>
                          <g>
                            <rect x="34.133" y="140.8" width="298.667" height="17.067"/>
                          </g>
                        </g>
                        <g>                          <g>
                            <rect x="110.933" y="379.733" width="17.067" height="17.067"/>
                          </g>
                        </g>
                        <g>
                          <g>
                            <rect x="401.067" y="379.733" width="17.067" height="17.067"/>
                          </g>
                        </g>                        <g>
                          <g>
                            <rect x="34.133" y="72.533" width="119.467" height="17.067"/>
                          </g>
                        </g>
                        <g>
                          <g>
                            <rect y="72.533" width="17.067" height="17.067"/>  </g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                                </svg>
                            </span>
                            <span class="<?=$identity->instagram ? 'first' : 'second'?>-person-socials">
                                <a href="<?=$identity->instagram?>" target="_blank">
                                <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M352,0H160C71.648,0,0,71.648,0,160v192c0,88.352,71.648,160,160,160h192c88.352,0,160-71.648,160-160V160    C512,71.648,440.352,0,352,0z M464,352c0,61.76-50.24,112-112,112H160c-61.76,0-112-50.24-112-112V160C48,98.24,98.24,48,160,48    h192c61.76,0,112,50.24,112,112V352z"/><path d="m256 128c-70.688 0-128 57.312-128 128s57.312 128 128 128 128-57.312 128-128-57.312-128-128-128zm0 208c-44.096 0-80-35.904-80-80 0-44.128 35.904-80 80-80s80 35.872 80 80c0 44.096-35.904 80-80 80z"/><circle cx="393.6" cy="118.4" r="17.056"/>
                                </svg>
                                </a>
                            </span>
                            <span class="<?=$identity->web_site ? 'first' : 'second'?>-person-socials">
                                <a href="<?=$identity->web_site?>" target="_blank">
                                <svg enable-background="new 0 0 58 58" version="1.1" viewBox="0 0 58 58" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m50.688 48.222c4.544-5.121 7.312-11.853 7.312-19.222 0-7.667-2.996-14.643-7.872-19.834v-1e-3c-4e-3 -6e-3 -0.01-8e-3 -0.013-0.013-5.079-5.399-12.195-8.855-20.11-9.126l-1e-3 -1e-3 -0.565-0.015c-0.146-5e-3 -0.292-0.01-0.439-0.01s-0.293 5e-3 -0.439 0.01l-0.563 0.015-1e-3 1e-3c-7.915 0.271-15.031 3.727-20.11 9.126-4e-3 5e-3 -0.01 7e-3 -0.013 0.013 0 0 0 1e-3 -1e-3 2e-3 -4.877 5.19-7.873 12.166-7.873 19.833 0 7.369 2.768 14.101 7.312 19.222 6e-3 9e-3 6e-3 0.019 0.013 0.028 0.018 0.025 0.044 0.037 0.063 0.06 5.106 5.708 12.432 9.385 20.608 9.665l1e-3 1e-3 0.563 0.015c0.147 4e-3 0.293 9e-3 0.44 9e-3s0.293-5e-3 0.439-0.01l0.563-0.015 1e-3 -1e-3c8.185-0.281 15.519-3.965 20.625-9.685 0.013-0.017 0.034-0.022 0.046-0.04 8e-3 -8e-3 8e-3 -0.018 0.014-0.027zm-48.663-18.222h12.003c0.113 4.239 0.941 8.358 2.415 12.217-2.844 1.029-5.563 2.409-8.111 4.131-3.747-4.457-6.079-10.138-6.307-16.348zm6.853-18.977c2.488 1.618 5.137 2.914 7.9 3.882-1.692 4.107-2.628 8.535-2.75 13.095h-12.003c0.239-6.507 2.787-12.432 6.853-16.977zm47.097 16.977h-12.003c-0.122-4.56-1.058-8.988-2.75-13.095 2.763-0.968 5.412-2.264 7.9-3.882 4.066 4.545 6.614 10.47 6.853 16.977zm-27.975-13.037c-2.891-0.082-5.729-0.513-8.471-1.283 2.027-4.158 4.889-7.911 8.471-11.036v12.319zm0 2v11.037h-11.972c0.123-4.348 1.035-8.565 2.666-12.475 3.006 0.871 6.127 1.353 9.306 1.438zm2 0c3.179-0.085 6.3-0.566 9.307-1.438 1.631 3.91 2.543 8.127 2.666 12.475h-11.973v-11.037zm0-2v-12.319c3.582 3.125 6.444 6.878 8.471 11.036-2.742 0.77-5.58 1.201-8.471 1.283zm10.409-1.891c-1.921-4.025-4.587-7.692-7.888-10.835 5.856 0.766 11.125 3.414 15.183 7.318-2.304 1.462-4.748 2.638-7.295 3.517zm-22.818 0c-2.547-0.879-4.991-2.055-7.294-3.517 4.057-3.904 9.327-6.552 15.183-7.318-3.302 3.143-5.968 6.81-7.889 10.835zm-1.563 16.928h11.972v10.038c-3.307 0.088-6.547 0.604-9.661 1.541-1.407-3.655-2.198-7.56-2.311-11.579zm11.972 12.038v13.318c-3.834-3.345-6.84-7.409-8.884-11.917 2.867-0.845 5.845-1.315 8.884-1.401zm2 13.318v-13.318c3.039 0.085 6.017 0.556 8.884 1.4-2.044 4.509-5.05 8.573-8.884 11.918zm0-15.318v-10.038h11.972c-0.113 4.019-0.904 7.924-2.312 11.58-3.113-0.938-6.353-1.454-9.66-1.542zm13.972-10.038h12.003c-0.228 6.21-2.559 11.891-6.307 16.348-2.548-1.722-5.267-3.102-8.111-4.131 1.475-3.859 2.302-7.978 2.415-12.217zm-34.281 17.846c2.366-1.572 4.885-2.836 7.517-3.781 1.945 4.36 4.737 8.333 8.271 11.698-6.151-0.805-11.656-3.685-15.788-7.917zm22.83 7.917c3.534-3.364 6.326-7.337 8.271-11.698 2.632 0.945 5.15 2.209 7.517 3.781-4.132 4.232-9.637 7.112-15.788 7.917z"/>
                                </svg>
                                </a>
                            </span>
                            <span class="<?=$identity->facebook ? 'first' : 'second'?>-person-socials">
                                <a href="<?=$identity->facebook?>" target="_blank">
                                    <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M288,176v-64c0-17.664,14.336-32,32-32h32V0h-64c-53.024,0-96,42.976-96,96v80h-64v80h64v256h96V256h64l32-80H288z"/>
                                    </svg>
                                </a>
                            </span>
                            <span class="<?=$identity->telegram != null ? 'first' : 'second'?>-person-socials">
                                <a href="<?=$identity->telegram?>" target="_blank">
                                    <svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m9.417 15.181-.397 5.584c.568 0 .814-.244 1.109-.537l2.663-2.545 5.518 4.041c1.012.564 1.725.267 1.998-.931l3.622-16.972.001-.001c.321-1.496-.541-2.081-1.527-1.714l-21.29 8.151c-1.453.564-1.431 1.374-.247 1.741l5.443 1.693 12.643-7.911c.595-.394 1.136-.176.691.218z"/></svg>
                                </a>
                            </span>                
                        </div>
                    </div>
                </div>
                <div class="about-main-user-right">
                    <div class="mboard">
                    <?php if(Yii::$app->user->identity != null) { ?>
                        <a href="/chat?user_id=<?=$identity->id?>" class="writed">
                    <?php } else { ?>
                        <a href="#" data-touch="false" data-fancybox data-src="#avtorization" value="/<?=$nowLanguage?>/site/login" class="writed avtorization_class">
                    <?php } ?>
                        <?= Yii::t('app',"Yozish") ?>
                        </a>
                    <?php if(Yii::$app->user->identity != null) { ?>
                        <a href="#" data-touch="false" data-fancybox data-src="#star-popup" value="/<?=$nowLanguage?>/profile/star?id=<?=$identity->id?>" class="link-template-img star_class">
                    <?php } else { ?>
                        <a href="#" data-touch="false" data-fancybox data-src="#avtorization" value="/<?=$nowLanguage?>/site/login" class="link-template-img avtorization_class">
                    <?php } ?>
                            <span>
                                <svg id="color" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m23.363 8.584-7.378-1.127-3.307-7.044c-.247-.526-1.11-.526-1.357 0l-3.306 7.044-7.378 1.127c-.606.093-.848.83-.423 1.265l5.36 5.494-1.267 7.767c-.101.617.558 1.08 1.103.777l6.59-3.642 6.59 3.643c.54.3 1.205-.154 1.103-.777l-1.267-7.767 5.36-5.494c.425-.436.182-1.173-.423-1.266z" fill="#ffc107"/></svg>
                            </span>
                            <?= Yii::t('app',"Foydalanuvchini baholash") ?>
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
                    <div class="m-soad">
                        <a href="/profile/catalog?user_id=<?=$identity->id?>" class="btn-template link-btn"><?= Yii::t('app',"Katalog") ?></a>
                    </div>
                </div>
            </div>
            <div class="personal-tab">
                <div class="emmet-title"><?= Yii::t('app',"Foydalanuvching e'lonlari") ?></div>
                <div class="tab-my-ads">
                    <div class="row">
                        <?php foreach ($myAdsdataProvider->getModels() as $ads) { 
                            if($avt) {
                                $fav = $ads->getStar($favorites);
                                if($fav) {
                                    $star = '<img src="/images/star-full.png" alt="" id="remove-'.$ads->id.'" class="remove_star" lang="'.$nowLanguage.'">
                                        <img src="/images/star-free.png" alt="" id="set-'.$ads->id.'" class="set_star" lang="'.$nowLanguage.'">';
                                }
                                else {
                                    $star = '<img src="/images/star-free.png" alt="" id="set-'.$ads->id.'" class="set_star" lang="'.$nowLanguage.'">
                                        <img src="/images/star-full.png" alt="" id="remove-'.$ads->id.'" class="remove_star" lang="'.$nowLanguage.'">';
                                }
                            }
                            else {
                                $star = '<a data-fancybox data-src="#avtorization" value="/' . $nowLanguage . '/site/login" class="avtorization_class"><img src="/images/star-free.png" alt=""><img src="/images/star-free.png" alt=""></a>';
                            }
                        ?>
                        <div class="col-xl-3 col-lg-4 col-6">
                            <div class="item-product">
                                <span class="star-item">
                                    <?= $star ?>
                                </span>
                                <a href="/ads/view?id=<?=$ads->id?>">
                                    <div class="item-product-img">
                                        <img src="<?=$ads->getImage('main_page')?>" alt="">
                                    </div>
                                    <h3><?=$ads->title?></h3>
                                    <p><?= Yii::t('app',"Kategoriya") ?>: <span> <?=$ads->category->title?> </span></p>
                                    <div class="discount">
                                        <?php if($ads->old_price != null) { ?>
                                            <s><?=$ads->old_price?> <?=$ads->currency->name?></s>
                                            <b><?=$ads->price?> <?=$ads->currency->name?></b>
                                        <?php } else {?>
                                            <b><?=$ads->price?> <?=$ads->currency->name?></b>
                                        <?php } ?>
                                    </div>
                                    <div class="address-item-product">
                                        <?=$ads->getAddress()?>
                                    </div>
                                    <div class="block-id-product">
                                        <span><?= $ads->getDate($ads->date_cr)?></span>
                                        <span>№: <?=$ads->id?></span>
                                    </div>
                                </a>              
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <nav aria-label="Page navigation example" class="my-nav-bottom">
                    <?= LinkPager::widget([
                        'pagination' => $myAdsdataProvider->pagination,
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
        </div>
    </section>