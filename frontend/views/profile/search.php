<?php

?>

        <form class="form-search">
          <div class="form-group select2-style">
            <select class="js-select2">
              <option><?= Yii::t('app',"Kategoriya") ?></option>
              <?php foreach ($categories as $category) {
                echo "<option>" . $category['title'] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group d-none d-sm-block">
            <input type="text" class="form-control" placeholder="<?= Yii::t('app',"So'rovingizni kiriting") ?>">
          </div>
          <div class="form-group select2-style">
            <select class="js-select2">
              <option><?= Yii::t('app',"Joylashuvi") ?></option>
              <?php foreach ($regions as $region) { ?>
                <option><?=$region->name?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn-template"><?= Yii::t('app',"Qidirish") ?></button>
          </div>
        </form>