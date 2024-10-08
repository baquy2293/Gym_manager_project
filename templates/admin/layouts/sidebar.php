<?php
$userId = isLogin()['userId'];
$userDetail = getUserInfo($userId);

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="?module=admin&action=lists" class="brand-link">
        <img src="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/img/kma.jpg" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Quản trị phòng tập</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo _WEB_HOST_ADMIN_TEMPLATE; ?>/assets/img/quy.jpg" class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Bá Quý</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="?module=admin&action=lists" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        <p>
                            Quản lí người dùng
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?module=admin&action=list_user" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tất cả người dùng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?module=admin&action=add_user" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm thành viên</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-user-md" aria-hidden="true"></i>
                        <p>
                            Huấn luyện viên
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?module=admin&action=list_pt" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách PT</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?module=admin&action=add_pt" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm PT</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-book" aria-hidden="true"></i>
                        <p>
                            Khoá học
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?module=admin&action=list_cource" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách khóa học</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?module=admin&action=add_cource" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm khóa học</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?module=admin&action=register_cource" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách đăng kí khóa học</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="?module=admin&action=price" class="nav-link">
                        <i class="fa fa-money" aria-hidden="true"></i>
                        <p>
                            Thanh toán
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?module=auth&action=logout" class="nav-link">
                        <i class="fa fa-power-off" aria-hidden="true"></i>
                        <p>
                            Đăng xuất
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>