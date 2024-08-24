<?php
if (!defined('_INCODE')) die('Access Deined...');

//Kiểm tra đăng nhập
if (!isLogin()){
    redirect('module=auth&action=login');
}else{
    $userId = isLogin()['userId'];
    $userDetail = getUserInfo($userId);
}

saveActivity(); //Lưu lại hoạt động cuối cùng của user

autoRemoveTokenLogin();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> Quản trị Gym</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"/>

    <link rel="stylesheet" href="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/css/style.css?ver=<?php echo rand(); ?>">

    <script type="text/javascript" src="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/ckeditor/ckeditor.js"></script>

    <script type="text/javascript" src="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/ckfinder/ckfinder.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
