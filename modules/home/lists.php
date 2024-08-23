<?php
if (!defined('_INCODE')) die('Access Deined...');
?>
<html>
<head>
    <title>Hệ thống quản trị</title>
    <meta charset="utf-8"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/font-awesome.min.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE; ?>/css/style.css?ver=<?php echo rand(); ?>"/>
</head>
<body>
<div class="container" style="display: flex; align-items: center; flex-direction: column; height: 100vh; justify-content: center">
    <h1 class="text-center">HỆ THỐNG QUẢN TRỊ</h1>
    <p class="text-center"><a href="?module=admin&action=auth/login" class="btn btn-success btn-lg">Vào hệ thống quản trị</a></p>
    <p class="text-center"><a href="?module=users" class="btn btn-success btn-lg">Vào hệ thống khách hàng</a></p>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="<?php echo _WEB_HOST_TEMPLATE; ?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo _WEB_HOST_TEMPLATE; ?>/js/custom.js"></script>
</body>
</html>

