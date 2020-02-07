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
use frontend\models\Sessions;

AgroAsset::register($this);
$langs = Lang::getLanguagesForHeader();
$nowLanguage = Yii::$app->language;
$pathInfo = Yii::$app->request->pathInfo;
$urlParams = Yii::$app->getRequest()->getQueryString();
if($pathInfo == 'site/index') $pathInfo = '';
$session = new Sessions();
$about_company = $session->getCompany();
$session->setTranslates();
$siteName = Yii::$app->params['siteName'];

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/backend/web/uploads/about-company/' . $about_company->logo)) {
    $path = $siteName . '/backend/web/img/no-logo.png';
} else {
    $path = $siteName . '/backend/web/uploads/about-company/' . $about_company->logo;
}

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= $nowLanguage ?>">
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

	<?= $this->render('header.php', [
		'path' => $path,
		'langs' => $langs,
		'urlParams' => $urlParams,
		'nowLanguage' => $nowLanguage,
		'pathInfo' => $pathInfo,
	]);?>

	<?= $this->render('content.php',
	    ['content' => $content]
	)?> 

	<?= $this->render('footer.php', [
		'about_company' => $about_company,
		'path' => $path,
		'session' => $session,
	]) ?>
	
	<?= $this->render('popups.php');?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
