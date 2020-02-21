<?php

?>

	<form class="form-search" action="/profile/catalog" method="get">
        <?php if($user_id != null) { ?><input type="hidden" name="user_id" value="<?=$user_id?>"> <?php } ?>
        <div class="form-group select2-style">
            <select class="js-select2" name="category">
              	<option value="" selected><?= Yii::t('app',"Kategoriya") ?></option>
              	<?php foreach ($categories as $category) {
              		$selected = '';
                	if($cat == $category['id']) $selected = 'selected';
                	echo '<option ' . $selected . ' value="' . $category['id'] . '" >' . $category['title'] . '</option>';
              	} ?>
            </select>
        </div>
        <div class="form-group d-none d-sm-block">
            <input type="text" value="<?= isset($get['text']) ? $get['text'] : '' ?>" class="form-control" name="text" placeholder="<?= Yii::t('app',"So'rovingizni kiriting") ?>">
        </div>
        <div class="form-group select2-style">
            <select class="js-select2" name="region">
              	<option value="" selected><?= Yii::t('app',"Joylashuvi") ?></option>
	            <?php foreach ($regions as $region) { ?>
	                <option value="<?=$region->id?>" <?=$reg == $region->id ? 'selected' : ''?> ><?=$region->name?></option>
	            <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn-template"><?= Yii::t('app',"Qidirish") ?></button>
        </div>
    </form>