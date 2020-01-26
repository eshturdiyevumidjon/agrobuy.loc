<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
   	Username:<br />
	<input id="username" type="text"><button id="btnSetUsername">Set username</button>

	<div id="chat" style="width:400px; height: 250px; overflow: scroll;"></div>

	Message:<br />
	<input id="message" type="text"><button id="btnSend">Send</button>
	<div id="response" style="color:#D00"></div>
</div>
