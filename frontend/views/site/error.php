<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<nav aria-label="breadcrumb" class="breadcrumb-top">
  	<ol class="breadcrumb container">
    	<li class="breadcrumb-item"><a href="#">Главная </a><img src="/images/right-arrow-green.png" alt=""></li>
    	<li class="breadcrumb-item active" aria-current="page"><?=$message?></li>
  	</ol>
</nav>

<section class="not-found">
  	<div class="container">
    	<h3><?=$name?></h3>
    	<p><?=$message?></p>
    	<h1><?=$exception->statusCode?></h1>
  	</div>
</section>

<!-- <section class="not-found">
  <div class="container">
    <h3>Эта страница недоступна</h3>
    <p>Возможно вы воспользовались недействительной ссылкой или страница была удалена</p>
    <h1>404</h1>
  </div>
</section> -->