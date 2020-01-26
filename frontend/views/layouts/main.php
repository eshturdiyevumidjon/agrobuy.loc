<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AgroAsset;
use common\widgets\Alert;
use backend\models\Lang;


AgroAsset::register($this);
$langs=\backend\models\Lang::getLanguages();
$language = Yii::$app->language;
$pathInfo = Yii::$app->request->pathInfo;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?=$this->render('header.php');?>
<?= $this->render(
    'content.php',
    ['content' => $content]
) ?>    
<?=$this->render('footer.php');?>
<?=$this->render('popups.php');?>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
