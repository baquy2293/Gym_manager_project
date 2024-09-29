<?php
if (!defined('_INCODE')) die('Access Deined...');
layout("header_login");
if (isPost()) {
    $body = getBody();
    if (!empty(trim($body['email'])) && !empty(trim($body['password']))) {
        //Kiểm tra đăng nhập
        $email = $body['email'];
        $password = $body['password'];
        //Truy vấn lấy thông tin user theo email
        $userQuery = firstRaw("SELECT id, password,admin,fullname FROM users WHERE email='$email' ");
        if (!empty($userQuery)) {
            $passwordHash = $userQuery['password'];
            $userId = $userQuery['id'];
            if (password_verify($password, $passwordHash)) {
                //Tạo token login
                $tokenLogin = sha1(uniqid() . time());
                //Insert dữ liệu vào bảng login_token
                $dataToken = [
                    'userId' => $userId,
                    'token' => $tokenLogin,
                    'createAt' => date('Y-m-d H:i:s')
                ];
                $insertTokenStatus = insert('login_token', $dataToken);
                if ($insertTokenStatus) {
                    //Insert token thành công
                    //Lưu loginToken vào session
                    setSession('loginToken', $tokenLogin);
                    setSession('admin', 1);
                    setSession('fullname', $userQuery['fullname']);
                    //Chuyển hướng qua trang quản lý users

                    if ($userQuery['admin'] == "1") {
                        redirect('?module=admin&action=lists');
                    } else
                        redirect('?module=customer&action=lists');

                } else {
                    setFlashData('msg', 'Lỗi hệ thống, bạn không thể đăng nhập vào lúc này');
                    setFlashData('msg_type', 'danger');
                    //redirect('?module=auth&action=login');
                }
            } else {
                setFlashData('msg', 'Mật khẩu không chính xác');
                setFlashData('msg_type', 'danger');
                setFlashData("email", $email);
                //redirect('?module=auth&action=login');
            }
        } else {
            setFlashData('msg', 'Email không tồn tại trong hệ thống ');
            setFlashData('msg_type', 'danger');
            setFlashData("email", $email);
            //redirect('?module=auth&action=login');
        }
    } else {
        setFlashData('msg', 'Vui lòng nhập email và mật khẩu');
        setFlashData('msg_type', 'danger');
        //redirect('?module=auth&action=login');
    }
    redirect('?module=auth&action=login');
}
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

<div id="loginbox">
    <form  method="POST" >
        <h3 class="text-center text-uppercase" style="color:#FFFFFF;">Đăng nhập hệ thống</h3>
        <?php getMsg($msg, $msgType); ?>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="far fa-user"></i></i></span>
                    <input type="text" name="email" placeholder="Email..."/>
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="fas fa-lock"></i></i></span>
                    <input type="password" name="password" placeholder="Mật khẩu..."/>
                </div>
            </div>
        </div>
        <div class="form-actions center">
            <button type="submit" class="btn btn-block btn-large btn-info" title="Log In" name="login"
                    value="Admin Login">Đăng nhập
            </button>
        </div>
    </form>
    <div class="pull-left">
        <a href="?module=auth&action=register">Đăng kí</a>
    </div>

    <div class="pull-right">
        <a href="?module=auth&action=forgot">Quên mật khẩu</a>
    </div>

    <?php
    layout("footer_login");
    ?>

