<?php

    use yii\helpers\Html;
?>
<section class="form-section">
    <div class="container">
        <form class="form-search" action="/site/search" method="get">
            <div class="form-group select2-style">
                <select class="js-select2" name="category">
                    <option value="" selected><?= Yii::t('app',"Kategoriya") ?></option>
                    <?php foreach ($categories as $category) {
                        echo '<option value="' . $category['id'] . '">' . $category['title'] . '</option>';
                    } ?>
                </select>
            </div>
            <div class="form-group d-none d-sm-block">
                <input type="text" class="form-control" name="text" placeholder="<?= Yii::t('app',"So'rovingizni kiriting") ?>">
            </div>
            <div class="form-group select2-style">
                <select class="js-select2" name="district">
                    <option value="" selected><?= Yii::t('app',"Joylashuvi") ?></option>
                    <?php foreach ($districts as $region) { ?>
                        <optgroup label="<?=$region['name']?>">
                            <?php foreach ($region['districts'] as $key => $value) { ?>
                                <option value="<?=$key?>"><?=$value?></option>
                            <?php } ?>
                        </optgroup>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-template"><?= Yii::t('app',"Qidirish") ?></button>
            </div>
        </form>
    </div>
</section>