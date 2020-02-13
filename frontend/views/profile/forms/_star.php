<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <h2><span><?= Yii::t('app',"Foydalanuvchini baholash") ?></span></h2>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'rating-form']]); ?>
        <?php /*$form->field($model, 'ball')
            ->radioList([
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
            ],
            ['class' => 'your_class', 'id' => 'your_id'])->label(false);*/ ?>

        <fieldset class="form-group">
                <legend class="form-legend">Rating:</legend>
                <div class="form-item">
                    <input id="rating-5" name="UsersBall[ball]" type="radio" <?=$model->ball == 5 ? 'checked' : ''?> value="5" />
                        <label for="rating-5" data-value="5">
                            <span class="rating-star">
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star"></i>
                            </span>
                            <span class="ir">5</span>
                        </label>
                        <input id="rating-4" name="UsersBall[ball]" type="radio" <?=$model->ball == 4 ? 'checked' : ''?> value="4" />
                            <label for="rating-4" data-value="4">
                                <span class="rating-star">
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star"></i>
                                </span>
                                <span class="ir">4</span>
                            </label>
                        <input id="rating-3" name="UsersBall[ball]" type="radio" <?=$model->ball == 3 ? 'checked' : ''?> value="3" />
                        <label for="rating-3" data-value="3">
                            <span class="rating-star">
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star"></i>
                            </span>
                            <span class="ir">3</span>
                        </label>
                        <input id="rating-2" name="UsersBall[ball]" type="radio" <?=$model->ball == 2 ? 'checked' : ''?> value="2" />
                        <label for="rating-2" data-value="2">
                            <span class="rating-star">
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star"></i>
                            </span>
                            <span class="ir">2</span>
                        </label>
                        <input id="rating-1" name="UsersBall[ball]" type="radio" <?=$model->ball == 1 ? 'checked' : ''?> value="1" />
                        <label for="rating-1" data-value="1">
                            <span class="rating-star">
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star"></i>
                            </span>
                            <span class="ir">1</span>
                        </label>
      
                        <div class="form-action">
                            <input class="btn-reset" type="reset" value="Reset" />   
                        </div>

                        <div class="form-output">
                            ? / 5
                        </div>
                    </div>
                </fieldset>

        <button type="submit" class="btn-template"><?= Yii::t('app',"Saqlash") ?></button>

    <?php ActiveForm::end(); ?>