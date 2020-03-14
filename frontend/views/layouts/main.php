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
use common\models\Category;
use common\models\Users;

AgroAsset::register($this);
$langs = Lang::getLanguagesForHeader();
$nowLanguage = Yii::$app->language;
$pathInfo = Yii::$app->request->pathInfo;
$urlParams = Yii::$app->getRequest()->getQueryString();
if($pathInfo == 'site/index') $pathInfo = '';
$session = new Sessions();
$about_company = $session->getCompany();
$session->setTranslates();
$session->setLastSeen();
$regions = $session->getRegionsList();
$categories = Category::getAllCategoryList();
$siteName = Yii::$app->params['siteName'];
if($about_company->view_banners == 1) $class = '';
else $class = 'not_slider';

if(Yii::$app->user->identity->id) {
	$user = Users::findOne(Yii::$app->user->identity->id);
	$user->last_seen = date('Y-m-d H:i:s');
	$user->save();
}

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
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
      	<meta name="viewport" content="width=device-width, initial-scale=1.0">
      	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php $this->registerCsrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script data-ad-client="ca-pub-7107601103975606" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-W9KGDQN');</script>
	<!-- End Google Tag Manager -->
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W9KGDQN"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<script src="//code-ya.jivosite.com/widget/ez7SqWGHKs" async></script>
</head>
<body class="<?=$class?>">
<?php $this->beginBody() ?>

	<?= $this->render('header.php', [
		'path' => $path,
		'langs' => $langs,
		'urlParams' => $urlParams,
		'nowLanguage' => $nowLanguage,
		'pathInfo' => $pathInfo,
	]);?>
	<div class="content_class">
	<?= $pathInfo != '' && $pathInfo != 'site/search' && $pathInfo != 'profile/catalog' ? $this->render('filtr.php',[
		'regions' => $regions,
		'categories' => $categories,
		'session' => $session,
	]) : '' ?>

	<?= $this->render('content.php',
	    ['content' => $content]
	)?> 
	</div>

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
