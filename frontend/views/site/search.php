<?php

use yii\helpers\Html;
$params = Yii::$app->getRequest()->getQueryString();
/*echo "g=". Yii::$app->getRequest()->getQueryString();die;
Yii::$app->getRequest()->getUrl()*/
/*echo "f=".$params;die;*/
?>
<section class="subcategory">
    <div class="container">
        <div class="reclama">
	        <img src="<?=$reklamaBig->getImage('main_page')?>" alt="<?=$reklamaBig->title?>">
        </div>
        <h2 class="title"><?=$session->getCategoryName($categories, $cat, $sub)?></h2>
        <?= $this->render('search_form', [
	        'regions' => $regions,
          'get' => $get,
          'reg' => $reg,
          'cat' => $cat,
	        'nowLanguage' => $nowLanguage,
	        'categories' => $categories,
	    ]) ?>
        <div class="category-body">
          	<div class="category-body-left">
            	<a href="#" class="statistika-link btn-template link-btn">Статистика</a>
            	<div class="category-body-left-in">
              		<div class="category-title"><?= Yii::t('app',"Kategoriya") ?></div>
              		<ul class="categ">
              			<?php foreach ($categories as $category) { 
              				if(isset($get['category']) && $get['category'] == $category['id']) { 
              					$actived = 'actived';
              					$display = 'block';
              				}
              				else { 
              					$actived = '';
              					$display = 'none';
              				}
              			?>
				            <li class="<?=$actived?>">
				                <a href="/site/search?category=<?=$category['id']?>" class="toggle-category"><?=$category['title']?></a>
				                <div class="cat-open"></div>
				                <ul class="inner-ul-category" style="display: <?=$display?>;">
				                   	<?php foreach ($category['subCategory'] as $sub) { ?>
				                   		<li><a href="/site/search?category=<?=$category['id']?>&sub=<?=$sub['id']?>" class=""><?=$sub['name']?></a></li>
				                   	<?php } ?>
				                 </ul>
				            </li>
              			<?php } ?>                
              		</ul>
            	</div>
	            <div class="reclama fixed-baner">
	              	<img src="<?=$reklamaSmall->getImage('main_page')?>" alt="<?=$reklamaSmall->title?>">
	            </div>
          	</div>
          	<div class="category-body-right">
          		<?php if( count($getModels) > 0) { ?>
            	<div class="category-title sorted">
              		<div>
                		<a href="<?='/site/search?' . $params . '&type=2' ?>" class="<?=$session->getAdsType() == 2 ? 'active' : ''?>"><?= Yii::t('app',"Sotib olaman") ?></a>
                		<a href="<?='/site/search?' . $params . '&type=1' ?>" class="<?=$session->getAdsType() == 1 ? 'active' : ''?>"><?= Yii::t('app',"Sotaman") ?></a>
              		</div>
	              	<div>
	                	<span><?= Yii::t('app',"Saralash") ?>:</span>
	                	<a href="<?='/site/search?' . $params . '&sortingAds=price' ?>" class="<?=$session->setSortingAds() == 'price' ? 'active' : ''?>"><?= Yii::t('app',"Narxi bo'yicha") ?></a>
	                	<a href="<?='/site/search?' . $params . '&sortingAds=date' ?>" class="<?=$session->setSortingAds() == 'date' ? 'active' : ''?>"><?= Yii::t('app',"Sanasi bo'yicha") ?></a>
	              	</div>
            	</div>
	            <?= $this->render('_search_ads', [
    			        'nowLanguage' => $nowLanguage,
    		            'dataProvider' => $dataProvider,
    		            'favorites' => $favorites,
    			    ]) ?>
	        	<?php } else { ?>
	        		<div class="not-product">
                  <div class="category-title sorted">
                    <div>
                      <a href="<?='/site/search?' . $params . '&type=1' ?>" class="<?=$session->getAdsType() == 1 ? 'active' : ''?>"><?= Yii::t('app',"Sotib olaman") ?></a>
                      <a href="<?='/site/search?' . $params . '&type=2' ?>" class="<?=$session->getAdsType() == 2 ? 'active' : ''?>"><?= Yii::t('app',"Sotaman") ?></a>
                    </div>
                    <div>
                      <span><?= Yii::t('app',"Saralash") ?>:</span>
                      <a href="<?='/site/search?' . $params . '&sortingAds=price' ?>" class="<?=$session->setSortingAds() == 'price' ? 'active' : ''?>"><?= Yii::t('app',"Narxi bo'yicha") ?></a>
                      <a href="<?='/site/search?' . $params . '&sortingAds=date' ?>" class="<?=$session->setSortingAds() == 'date' ? 'active' : ''?>"><?= Yii::t('app',"Sanasi bo'yicha") ?></a>
                    </div>
                  </div>
		              	<svg height="512pt" viewBox="0 0 512 512" width="512pt" xmlns="http://www.w3.org/2000/svg"><path d="m323.542969 330.414062c78.273437 0 141.957031-63.679687 141.957031-141.957031 0-78.273437-63.683594-141.957031-141.957031-141.957031-78.273438 0-141.957031 63.683594-141.957031 141.957031 0 78.277344 63.683593 141.957031 141.957031 141.957031zm0-263.914062c67.246093 0 121.957031 54.710938 121.957031 121.957031 0 67.246094-54.710938 121.957031-121.957031 121.957031-67.246094 0-121.957031-54.707031-121.957031-121.957031 0-67.246093 54.710937-121.957031 121.957031-121.957031zm0 0"></path><path d="m322.058594 379.882812c104.734375 0 189.941406-85.207031 189.941406-189.941406s-85.207031-189.941406-189.941406-189.941406-189.941406 85.207031-189.941406 189.941406c0 39.75 12.28125 76.675782 33.238281 107.210938l-31.070313 31.070312-4.230468-4.230468c-3.90625-3.90625-10.238282-3.90625-14.144532 0l-100.976562 100.976562c-9.628906 9.628906-14.933594 22.433594-14.933594 36.050781 0 13.617188 5.304688 26.417969 14.933594 36.046875s22.429687 14.933594 36.046875 14.933594c13.617187 0 26.421875-5.304688 36.050781-14.933594l100.980469-100.976562c1.875-1.875 2.925781-4.417969 2.925781-7.070313 0-2.652343-1.050781-5.199219-2.925781-7.074219l-4.234375-4.230468 31.070312-31.070313c30.535156 20.957031 67.464844 33.238281 107.210938 33.238281zm0-359.882812c93.707031 0 169.941406 76.234375 169.941406 169.941406 0 93.707032-76.234375 169.941406-169.941406 169.941406-93.703125 0-169.941406-76.234374-169.941406-169.941406 0-93.707031 76.238281-169.941406 169.941406-169.941406zm-249.167969 462.925781c-5.855469 5.851563-13.632813 9.074219-21.910156 9.074219-8.277344 0-16.054688-3.222656-21.90625-9.074219-12.082031-12.078125-12.082031-31.734375 0-43.816406l93.90625-93.90625 4.230469 4.226563c0 .003906.003906.003906.003906.007812l39.582031 39.582031zm96.746094-119.355469-21.207031-21.207031 29.203124-29.203125c6.503907 7.609375 13.597657 14.703125 21.207032 21.207032zm0 0"></path><path d="m289.308594 162.171875c5.523437 0 10-4.476563 10-10 0-6.882813 2.945312-13.464844 8.074218-18.058594 5.203126-4.660156 11.933594-6.796875 18.960938-6.019531 11.101562 1.226562 20.050781 10.175781 21.277344 21.277344 1.078125 9.789062-3.738282 19.199218-12.277344 23.972656-13.445312 7.519531-21.800781 21.425781-21.800781 36.289062v14.269532c0 5.523437 4.476562 10 10 10 5.519531 0 10-4.476563 10-10v-14.269532c0-7.628906 4.429687-14.84375 11.5625-18.832031 15.570312-8.707031 24.359375-25.832031 22.394531-43.625-2.246094-20.332031-18.632812-36.714843-38.960938-38.960937-12.5625-1.386719-25.144531 2.621094-34.5 11-9.359374 8.382812-14.730468 20.394531-14.730468 32.957031 0 5.523437 4.476562 10 10 10zm0 0"></path><path d="m323.539062 252.890625c-2.628906 0-5.207031 1.070313-7.066406 2.929687-1.859375 1.859376-2.933594 4.441407-2.933594 7.070313 0 2.640625 1.070313 5.210937 2.933594 7.070313 1.859375 1.867187 4.4375 2.929687 7.066406 2.929687 2.632813 0 5.210938-1.0625 7.070313-2.929687 1.859375-1.859376 2.929687-4.441407 2.929687-7.070313s-1.066406-5.210937-2.929687-7.070313c-1.859375-1.859374-4.4375-2.929687-7.070313-2.929687zm0 0"></path></svg>
		              	<p><?= Yii::t('app',"Afsuski sizning so'rovingiz bo'yicha hech narsa topilmadi") ?></p>
		            </div>
	        	<?php } ?>
          </div>
        </div>
      </div>
    </section>