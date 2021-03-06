<?php

use yii\helpers\Html;
use yii\helpers\Url;

$pathInfo = Yii::$app->request->pathInfo;
$siteName = Yii::$app->params['siteName'];
$urlParams = Yii::$app->getRequest()->getQueryString();

$title = $model->title; // заголовок
$summary = $model->category->title; // анонс поста
$url = Url::to([ '/' .$pathInfo . '?' . $urlParams]); // ссылка на пост
$image_url = $model->user->getAvatarForSite(); // URL изображения

?>
<script type="text/javascript">
	function outFunc() {
	  var tooltip = document.getElementById("myTooltip");
	  tooltip.innerHTML = "Copy to clipboard";
	}
</script>
<div class="ads-right obe">
    <h4><?=$model->price . ' ' . $model->currency->name?></h4>
    <div class="d-flex align-items-center justify-content-between my-ton">
    	<?php if($nowLanguage == 'uz') { ?>
    		<span><?=$model->unit_price?> </span>
	     	<b><?= Yii::t('app',"ga") ?></b>
     	<?php } else { ?>
	     	<span><?= Yii::t('app',"ga") ?> :</span>
	     	<b><?=$model->unit_price?></b>
     	<?php } ?>
    </div>
    <div class="ads-user">
     	<div class="ads-user-avatar">
       		<div class="img-avatar">
       			<a href="<?=$path?>">
        			<img src="<?=$model->user->getAvatarForSite()?>" alt="User Avatar">
       			</a>
       		</div>
       		<div class="top-link-reuters">
        		<p><a href="<?=$path?>"><?=$model->user->login?></a></p>
				<div class="dropdown share_button">
				    <button class="link-template-img" type="button" id="dropdownMenuButtonnn" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
				      	<span>
					        <svg width="453pt" height="453pt" viewBox="0 -28 454 453" xmlns="http://www.w3.org/2000/svg"><path d="m345.38 3.4102c-2.8633-2.8477-7.1602-3.6953-10.891-2.1445s-6.1641 5.1953-6.1641 9.2344v53.359c-54.012 2.1484-81.059 24.539-85.191 28.262-27.25 22.363-45.855 53.527-52.613 88.121-3.3789 16.715-3.9844 33.871-1.7852 50.781l0.007812 0.058593c0.019531 0.14844 0.042969 0.30078 0.066407 0.44922l2.125 12.215c0.71484 4.1133 3.9141 7.3516 8.0195 8.1172 4.1094 0.76562 8.2578-1.1055 10.406-4.6875l6.3672-10.613c19.562-32.527 43.941-54.09 72.469-64.086 12.867-4.5508 26.5-6.5469 40.129-5.8828v55.266c0 4.0469 2.4414 7.6992 6.1836 9.2422 3.7461 1.5469 8.0508 0.67969 10.906-2.1914l105.68-106.21c3.8945-3.9141 3.8789-10.246-0.035157-14.141zm2.9492 194.21v-40.027c0-4.9062-3.5625-9.0898-8.4102-9.8711-8.5547-1.3789-31.371-3.5703-58.336 5.8789-28.766 10.078-53.652 29.91-74.148 59.051-0.058594-9.5742 0.84766-19.133 2.707-28.527 6.0781-30.73 21.516-56.543 45.879-76.711 0.21484-0.17578 0.41797-0.35938 0.61719-0.55469 0.69922-0.64844 26.098-23.578 81.609-23.164h0.074218c5.5234 0 10.004-4.4805 10.008-10.004v-39.137l81.535 81.125z"></path><path d="m417.35 294.95c-5.5195 0-10 4.4766-10 10v42.262c-0.015624 16.562-13.438 29.98-30 30h-327.35c-16.562-0.019532-29.98-13.438-30-30v-238.24c0.019531-16.562 13.438-29.98 30-30h69.16c5.5234 0 10-4.4766 10-10 0-5.5234-4.4766-10-10-10h-69.16c-27.602 0.03125-49.969 22.398-50 50v238.24c0.03125 27.602 22.398 49.969 50 50h327.35c27.602-0.03125 49.969-22.398 50-50v-42.262c0-5.5234-4.4766-10-10-10z"></path></svg>
					    </span>
					    <?=Yii::t('app', "Baham ko'rish")?>
				    </button>
				    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonnn">
				      	<a href="https://telegram.me/share/url?url=<?php echo $siteName . urlencode( $url ); ?>&text=<?php echo $summary . ' : ' . $title ?>" onclick="window.open(this.href, this.title, 'toolbar=0, status=0, width=548, height=325'); return false" title="Поделиться ссылкой на Телеграм" target="_parent" class="dropdown-item">
				          	<svg id="Bold" enable-background="new 0 0 24 24" height="512" viewBox="0 0 24 24" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m9.417 15.181-.397 5.584c.568 0 .814-.244 1.109-.537l2.663-2.545 5.518 4.041c1.012.564 1.725.267 1.998-.931l3.622-16.972.001-.001c.321-1.496-.541-2.081-1.527-1.714l-21.29 8.151c-1.453.564-1.431 1.374-.247 1.741l5.443 1.693 12.643-7.911c.595-.394 1.136-.176.691.218z"></path></svg>
				          Telegram
				      	</a>
				      <!-- <a class="dropdown-item" href="#">
				          <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
				                    <path d="M352,0H160C71.648,0,0,71.648,0,160v192c0,88.352,71.648,160,160,160h192c88.352,0,160-71.648,160-160V160    C512,71.648,440.352,0,352,0z M464,352c0,61.76-50.24,112-112,112H160c-61.76,0-112-50.24-112-112V160C48,98.24,98.24,48,160,48    h192c61.76,0,112,50.24,112,112V352z"></path>
				                    <path d="m256 128c-70.688 0-128 57.312-128 128s57.312 128 128 128 128-57.312 128-128-57.312-128-128-128zm0 208c-44.096 0-80-35.904-80-80 0-44.128 35.904-80 80-80s80 35.872 80 80c0 44.096-35.904 80-80 80z"></path>
				                    <circle cx="393.6" cy="118.4" r="17.056"></circle>
				                </svg>
				          Instagram
				      </a> -->
					        <a href="http://www.facebook.com/sharer.php?s=100&p[url]=<?php echo urlencode( $url ); ?>&p[title]=<?php echo $title ?>&p[summary]=<?php echo $summary ?>" onclick="window.open(this.href, this.title, 'toolbar=0, status=0, width=548, height=325'); return false" title="Поделиться ссылкой на Фейсбук" target="_parent" class="dropdown-item">
					          <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
					                    <path d="M288,176v-64c0-17.664,14.336-32,32-32h32V0h-64c-53.024,0-96,42.976-96,96v80h-64v80h64v256h96V256h64l32-80H288z"></path>
					                </svg>
					          Facebook
					       </a>
					       <a href="/" onclick=" return false;" class="dropdown-item">
					       	<div id="bosss">
				       			<svg class="svg-icon" viewBox="0 0 20 20" id="copy_current_address">
								<path fill="gray" d="M18.378,1.062H3.855c-0.309,0-0.559,0.25-0.559,0.559c0,0.309,0.25,0.559,0.559,0.559h13.964v13.964
									c0,0.309,0.25,0.559,0.559,0.559c0.31,0,0.56-0.25,0.56-0.559V1.621C18.938,1.312,18.688,1.062,18.378,1.062z M16.144,3.296H1.621
									c-0.309,0-0.559,0.25-0.559,0.559v14.523c0,0.31,0.25,0.56,0.559,0.56h14.523c0.309,0,0.559-0.25,0.559-0.56V3.855
									C16.702,3.546,16.452,3.296,16.144,3.296z M15.586,17.262c0,0.31-0.25,0.558-0.56,0.558H2.738c-0.309,0-0.559-0.248-0.559-0.558
									V4.972c0-0.309,0.25-0.559,0.559-0.559h12.289c0.31,0,0.56,0.25,0.56,0.559V17.262z"></path>
							</svg>
					        Копировать ссылку
					       	</div>
					       
					       </a>
				    </div>
				  </div>
				</div>
            </div>
        <?php if($model->user_id != $identity->id) {?>
	        <div class="bottom-block-reuters">
	        	<?php if($identity != null) { ?>
	            	<a href="#" data-touch="false" data-fancybox data-src="#chats-popup" value="/<?=$nowLanguage?>/chat/message?user_id=<?=$model->user_id?>" class="link-template-img chats_class">
	            <?php } else { ?>
	            	<a href="#" data-touch="false" data-fancybox data-src="#avtorization" value="/<?=$nowLanguage?>/site/login" class="link-template-img avtorization_class">
	            <?php } ?>
	                <span>
	                    <svg enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="M467,61H45C20.218,61,0,81.196,0,106v300c0,24.72,20.128,45,45,45h422c24.72,0,45-20.128,45-45V106    C512,81.28,491.872,61,467,61z M460.786,91L256.954,294.833L51.359,91H460.786z M30,399.788V112.069l144.479,143.24L30,399.788z     M51.213,421l144.57-144.57l50.657,50.222c5.864,5.814,15.327,5.795,21.167-0.046L317,277.213L460.787,421H51.213z M482,399.787    L338.213,256L482,112.212V399.787z"></path></svg>
	                </span>
	                <?=Yii::t('app', "Muallifga yozish")?>
	            </a>
	            <a href="tel:<?=$model->user->phone?>" class="link-template-img">
	                <span>
	                    <svg enable-background="new 0 0 512.076 512.076" version="1.1" viewBox="0 0 512.08 512.08" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><g transform="translate(-1 -1)"><path d="m499.64 396.04-103.65-69.12c-13.153-8.701-30.784-5.838-40.508 6.579l-30.191 38.818c-3.88 5.116-10.933 6.6-16.546 3.482l-5.743-3.166c-19.038-10.377-42.726-23.296-90.453-71.04s-60.672-71.45-71.049-90.453l-3.149-5.743c-3.161-5.612-1.705-12.695 3.413-16.606l38.792-30.182c12.412-9.725 15.279-27.351 6.588-40.508l-69.12-103.65c-8.907-13.398-26.777-17.42-40.566-9.131l-43.341 26.035c-13.618 8.006-23.609 20.972-27.878 36.181-15.607 56.866-3.866 155.01 140.71 299.6 115 115 200.62 145.92 259.46 145.92 13.543 0.058 27.033-1.704 40.107-5.239 15.212-4.264 28.18-14.256 36.181-27.878l26.061-43.315c8.301-13.792 4.281-31.673-9.123-40.585zm-5.581 31.829-26.001 43.341c-5.745 9.832-15.072 17.061-26.027 20.173-52.497 14.413-144.21 2.475-283.01-136.32s-150.73-230.5-136.32-283.01c3.116-10.968 10.354-20.307 20.198-26.061l43.341-26.001c5.983-3.6 13.739-1.855 17.604 3.959l37.547 56.371 31.514 47.266c3.774 5.707 2.534 13.356-2.85 17.579l-38.801 30.182c-11.808 9.029-15.18 25.366-7.91 38.332l3.081 5.598c10.906 20.002 24.465 44.885 73.967 94.379 49.502 49.493 74.377 63.053 94.37 73.958l5.606 3.089c12.965 7.269 29.303 3.898 38.332-7.91l30.182-38.801c4.224-5.381 11.87-6.62 17.579-2.85l103.64 69.12c5.818 3.862 7.563 11.622 3.958 17.604z"></path><path d="m291.16 86.39c80.081 0.089 144.98 64.986 145.07 145.07 0 4.713 3.82 8.533 8.533 8.533s8.533-3.82 8.533-8.533c-0.099-89.503-72.63-162.04-162.13-162.13-4.713 0-8.533 3.82-8.533 8.533s3.82 8.533 8.533 8.533z"></path><path d="m291.16 137.59c51.816 0.061 93.806 42.051 93.867 93.867 0 4.713 3.821 8.533 8.533 8.533 4.713 0 8.533-3.82 8.533-8.533-0.071-61.238-49.696-110.86-110.93-110.93-4.713 0-8.533 3.82-8.533 8.533s3.82 8.533 8.533 8.533z"></path><path d="m291.16 188.79c23.552 0.028 42.638 19.114 42.667 42.667 0 4.713 3.821 8.533 8.533 8.533s8.533-3.82 8.533-8.533c-0.038-32.974-26.759-59.696-59.733-59.733-4.713 0-8.533 3.82-8.533 8.533s3.82 8.533 8.533 8.533z"></path></g></svg>
	                </span>
	                <?=$model->user->phone?>
	            </a>
	            <?php if($identity != null) { ?>
	            	<a href="#" data-touch="false" data-fancybox data-src="#send-complaint" value="/<?=$nowLanguage?>/profile/complaint?id=<?=$model->id?>" class="link-template-img complaint_class">
	            <?php } else { ?>
	            	<a href="#" data-touch="false" data-fancybox data-src="#avtorization" value="/<?=$nowLanguage?>/site/login" class="link-template-img avtorization_class">
	            <?php } ?>
	                <span>
	                    <svg enable-background="new 0 0 469.333 469.333" version="1.1" viewBox="0 0 469.33 469.33" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m206.88 43.544c-3.875-1.698-8.448-0.896-11.542 2.042l-109.85 103.75h-74.823c-5.896 0-10.667 4.771-10.667 10.666v149.33c0 5.896 4.771 10.667 10.667 10.667h74.823l109.85 103.75c2.021 1.917 4.656 2.917 7.323 2.917 1.427 0 2.865-0.281 4.219-0.875 3.917-1.677 6.448-5.531 6.448-9.792v-362.67c-1e-3 -4.261-2.532-8.115-6.449-9.792zm-14.885 347.71-94.948-89.667c-1.979-1.875-4.604-2.917-7.323-2.917h-68.396v-128h68.396c2.719 0 5.344-1.042 7.323-2.917l94.948-89.665v313.17z"></path><path d="m372.06 44.7c-4.813-3.469-11.469-2.385-14.896 2.375-3.458 4.771-2.396 11.438 2.375 14.896 55.396 40.125 88.458 104.69 88.458 172.7s-33.063 132.57-88.458 172.7c-4.771 3.458-5.833 10.125-2.375 14.896 2.083 2.875 5.344 4.406 8.646 4.406 2.167 0 4.354-0.656 6.25-2.031 60.906-44.125 97.271-115.15 97.271-189.97-1e-3 -74.823-36.365-145.84-97.271-189.97z"></path><path d="m314.01 108.3c-4.948-3.125-11.563-1.635-14.708 3.354-3.135 4.979-1.635 11.563 3.354 14.708 37.573 23.646 60.01 64.135 60.01 108.3s-22.438 84.656-60.01 108.3c-4.99 3.146-6.49 9.729-3.354 14.708 2.031 3.229 5.5 4.99 9.042 4.99 1.938 0 3.906-0.531 5.667-1.635 43.822-27.583 69.989-74.812 69.989-126.36s-26.167-98.781-69.99-126.36z"></path><path d="m272.75 183.45c-4.729-3.531-11.406-2.531-14.927 2.177-3.521 4.729-2.542 11.417 2.177 14.927 11.021 8.208 17.333 20.635 17.333 34.115 0 13.479-6.313 25.906-17.333 34.115-4.719 3.51-5.698 10.198-2.177 14.927 2.094 2.813 5.302 4.292 8.563 4.292 2.208 0 4.448-0.688 6.365-2.115 16.469-12.26 25.917-30.937 25.917-51.219s-9.449-38.958-25.918-51.219z"></path></svg>
	                </span>
	                <?=Yii::t('app', "Shikoyat qilish")?>
	            </a>
	        </div>
	    <?php } ?>
        </div>
    </div>
</div>

<?php
$this->registerJs(<<<JS
	$(document).on('click', '#bosss', function(e){ 
		  const el = document.createElement('input');  // Create a <textarea> element
		  el.value = window.location.href;                                 // Set its value to the string that you want copied
		  el.setAttribute('readonly', '');                // Make it readonly to be tamper-proof
		  el.style.position = 'absolute';                 
		  el.style.left = '-9999px';                      // Move outside the screen to make it invisible
		  document.body.appendChild(el);                  // Append the <textarea> element to the HTML document
		  const selected =            
		    document.getSelection().rangeCount > 0        // Check if there is any content selected previously
		      ? document.getSelection().getRangeAt(0)     // Store selection if found
		      : false;                                    // Mark as false to know no selection existed before
		  el.select();                                    // Select the <textarea> content
		  document.execCommand('copy');                   // Copy - only works as a result of a user action (e.g. click events)
		  document.body.removeChild(el);                  // Remove the <textarea> element
		  if (selected) {                                 // If a selection existed before copying
		    document.getSelection().removeAllRanges();    // Unselect everything on the HTML document
		    document.getSelection().addRange(selected);   // Restore the original selection
		  }
	});
JS
);
?>
