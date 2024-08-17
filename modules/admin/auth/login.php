<?php layout("header_login"); ?>

<div id="loginbox">
    <form id="loginform" method="POST" class="form-vertical" action="#">
        <h3 class="text-center text-uppercase">Đăng nhập hệ thống</h3>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="far fa-user"></i></i></span>
                    <input type="text" name="user" placeholder="Email..." required/>
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="fas fa-lock"></i></i></span>
                    <input type="password" name="pass" placeholder="Mật khẩu..." required/>
                </div>
            </div>
        </div>
        <div class="form-actions center">
            <button type="submit" class="btn btn-block btn-large btn-info" title="Log In" name="login"
                    value="Admin Login">Đăng nhập
            </button>
        </div>
    </form>
    <?php
    if (isset($_POST['login'])) {
        $username = mysqli_real_escape_string($conn, $_POST['user']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);

        $password = md5($password);

        $query = mysqli_query($conn, "SELECT * FROM admin WHERE  password='$password' and username='$username'");
        $row = mysqli_fetch_array($query);
        $num_row = mysqli_num_rows($query);

        if ($num_row > 0) {
            $_SESSION['user_id'] = $row['user_id'];
            header('location:admin/index.php');
        } else {
            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                Invalid Username and Password
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                                </div>";
        }
    }
    ?>
    <div class="pull-left">
        <a href="?module=customer&action=auth/login">Khách hàng đăng nhập</a>
    </div>

    <div class="pull-right">
        <a href="?module=admin&action=auth/forgot">Quên mật khẩu</a>
    </div>

    <?php

    layout("footer_login");

    ?>

