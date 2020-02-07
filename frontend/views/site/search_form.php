<?php 
/*echo "<pre>";
print_r($get['text']);
echo "</pre>";
die;*/

?>

<form class="form-search" action="/site/search" method="get">
    <div class="form-group select2-style">
        <select class="js-select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="category">
            <option value="" disabled selected><?= Yii::t('app',"Kategoriya") ?></option>
            <?php foreach ($categories as $category) {
                $selected = '';
                if($cat == $category['id']) $selected = 'selected';
                echo '<option ' . $selected . ' value="' . $category['id'] . '" >' . $category['title'] . '</option>';
            }?>
        </select>
        <span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" style="width: 283.337px;">
            <span class="selection">
                <span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-dyp9-container">
                    <span class="select2-selection__rendered" id="select2-dyp9-container" title="<?= Yii::t('app','Kategoriya') ?>"><?= Yii::t('app',"Kategoriya") ?></span>
                    <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
                </span>
            </span>
            <span class="dropdown-wrapper" aria-hidden="true"></span>
        </span>
    </div>
    <div class="form-group d-none d-sm-block">
        <input type="text" value="<?= isset($get['text']) ? $get['text'] : '' ?>" class="form-control" name="text" placeholder="<?= Yii::t('app',"So'rovingizni kiriting") ?>">
    </div>
    <div class="form-group select2-style">
        <select class="js-select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true" name="region">
            <option value="" disabled selected><?= Yii::t('app',"Joylashuvi") ?></option>
            <?php foreach ($regions as $region) { ?>
                <option value="<?=$region->id?>" <?=$reg == $region->id ? 'selected' : ''?> ><?=$region->name?></option>
            <?php } ?>
        </select>
        <span class="select2 select2-container select2-container--default" dir="ltr" style="width: 283.337px;">
            <span class="selection">
                <span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-yzin-container">
                    <span class="select2-selection__rendered" id="select2-yzin-container" title="<?= Yii::t('app','Joylashuvi') ?>"><?= Yii::t('app',"Joylashuvi") ?></span>
                    <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
                </span>
            </span>
            <span class="dropdown-wrapper" aria-hidden="true"></span>
        </span>
    </div>
    <div class="form-group">
        <button type="submit" class="btn-template"><?= Yii::t('app',"Qidirish") ?></button>
    </div>
</form>