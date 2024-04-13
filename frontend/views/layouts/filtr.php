<?php
    use yii\helpers\Html;
?>

<form class="form-search" action="/site/search" method="get" style="display: none;">
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
        <select class="js-select2" name="region">
            <option value="" selected><?= Yii::t('app',"Joylashuvi") ?></option>
            <?php foreach ($regions as $key => $region) { ?>
                <option value="<?=$key?>"><?=$region?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn-template"><?= Yii::t('app',"Qidirish") ?></button>
    </div>
</form>