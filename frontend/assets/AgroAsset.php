<?php 
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Agrubuy web platformasi uchun 
 * Coder: Umidjon Zoxidov
 */
class AgroAsset extends AssetBundle
{
	
	public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
	      // 'css/site.css',
	      'font/stylesheet.css',
	      'css/dropzone.min.css',
	      'css/select2.min.css',
	      'css/jquery.fancybox.min.css',
	      'css/bootstrap.min.css',
	      'css/jquery-ui.min.css',
	      'css/swiper.min.css',
	      'css/style.css',
	      'css/media.css',
    ];
    public $js = [
        'js/chat.js',
        //'js/jquery.min.js',
	    'js/swiper.min.js',
	    'js/popper.min.js',
	    'js/bootstrap.min.js',
	    // 'js/jquery.maskedinput.js',
	    'js/dropzone.min.js',
	    'js/select2.full.js',
	    'js/jquery.fancybox.min.js',
	    // 'js/all.min.js',
	    'js/main.js',
	    'js/extension.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
 ?>