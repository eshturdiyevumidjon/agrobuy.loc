<?php 
    use yii\helpers\Html;
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="../plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="../plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../css/animate.min.css" rel="stylesheet" />
    <link href="../css/style.min.css" rel="stylesheet" />
    <link href="../css/style-responsive.min.css" rel="stylesheet" />
    <link href="../css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->
    
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="../plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top">
<!-- begin #page-loader -->
<div id="page-loader" class="fade in"><span class="spinner"></span></div>
<!-- end #page-loader -->

    <div class="login-cover">
        <div class="login-cover-image"><img src="../img/login-bg/bg-6.jpg" data-id="login-cover-image" alt="" /></div>
        <div class="login-cover-bg"></div>
    </div>
<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin login -->
    <?=$content?>
    <!-- end login -->
<!-- <ul class="login-bg-list clearfix">
            <li class="active"><a href="#" data-click="change-bg"><img src="../img/login-bg/bg-6.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="../img/login-bg/bg-2.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="../img/login-bg/bg-3.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="../img/login-bg/bg-4.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="../img/login-bg/bg-5.jpg" alt="" /></a></li>
            <li><a href="#" data-click="change-bg"><img src="../img/login-bg/bg-1.jpg" alt="" /></a></li>
            
        </ul> -->
</div>
<!-- end page container -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="../plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="../plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="../plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
        <script src="../crossbrowserjs/html5shiv.js"></script>
        <script src="../crossbrowserjs/respond.min.js"></script>
        <script src="../crossbrowserjs/excanvas.min.js"></script>
    <![endif]-->
    <script src="../plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../plugins/jquery-cookie/jquery.cookie.js"></script>
    <!-- ================== END BASE JS ================== -->
    
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="../js/login-v2.demo.min.js"></script>
    <script src="../js/apps.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
            LoginV2.init();
        });
    </script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53034621-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
