<?php

$i = 0;

?>
<section class="select-category">
    <div class="container">
        <h2 class="title">
            <!-- Выберите <span>категорию</span>  -->
            <?php 
                $text = explode(' ', Yii::t('app',"Kategoriyani tanlang"));
                $res = '';
                foreach ($text as $key => $value) {
                    if(($key + 1) === count($text)) $res .= '<span>' . $value . '</span>';
                    else $res .= $value . ' ';
                }
                echo $res;
            ?>
        </h2>
        <div class="category-main">
            <?php foreach ($categories as $category) { $i++; ?>
                <div class="category-main-item">
                    <img src="<?=$category['image']?>" alt="<?=$category['title']?>">
                    <p><?=$category['title']?></p>
                </div>
                <div class="select-category-popup ik<?=$i?>">
                    <?php foreach ($category['subCategory'] as $sub) {?>
                        <a href="#" class="dropdown-item"><?=$sub['name']?></a>
                    <?php } ?>
                </div>
            <?php } ?>          
        </div>
    </div>
</section>