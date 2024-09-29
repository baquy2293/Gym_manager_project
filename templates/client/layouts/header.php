<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous" />
    <!-- link fontawesome -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet" />
    <!-- font google -->
    <link rel="stylesheet" href="./Home/owl.theme.default.min.css" />
    <!-- carousel -->
    <title><?php echo !empty($data['pageTitle']) ? $data['pageTitle'] : 'TRINH BA QUY'; ?></title>
    <style>
    :root {
        --bg-color: #1ea2bf;
        --text-color: #157332;
        --textPrice-color: #d21e1eff;
    }
    </style>
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE ; ?>/assets/css/style_<?php echo $data['style'] ?>.css?ver=<?php echo rand(); ?>" />
    <link rel="stylesheet" href="<?php echo _WEB_HOST_CLIENT_TEMPLATE ?>/assets/css/style_home_animate.css" />
</head>

<body>
    <div class="containerr">
        <header>
            <!-- end header_top -->
            <div class="header_bottom">
                <div class="social_network">
                    <a href="https://www.facebook.com/thanh.thuong.4444" target="_blank"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/thanh.thuong14/" target="_blank"><i
                            class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/thanh.thuong.4444" target="_blank"><i
                            class="fab fa-twitter"></i></a>
                    <a href="https://www.tiktok.com/@thuongnguyenqq" target="_blank"><i class="fab fa-tiktok"></i></a>
                </div>
                <nav class="nav_top">
                    <button class="bnt-bars">
                        <i class="fas fa-bars"></i>
                    </button>
                    <ul>
                        <li><a href="?module=customer&action=lists">Danh sách gói tập</a></li>
                        <li><a href="?module=customer&action=pt">Danh sách huấn luyện viên</a></li>
                        <li><a href="?module=auth&action=logout">Đăng suất</a></li>
                        <!-- end logo -->
                    </ul>
                </nav>
               <h1><?php echo getSession('fullname') ?></h1>
                <!-- <img class="img-fluid" src="../images/' . $row['logo'] . '" alt="Theme-Logo" /> -->
            </div>
            <!-- end header_bottom -->
        </header>