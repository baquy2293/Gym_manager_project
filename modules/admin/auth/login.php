<?php
layout("header_login");
if (isPost()) {
    $body = getBody();
    var_dump($body);
    if (!empty(trim($body['email'])) && !empty(trim($body['password']))) {
        //Kiểm tra đăng nhập
        $email = $body['email'];
        $password = $body['password'];
        //Truy vấn lấy thông tin user theo email
        $userQuery = firstRaw("SELECT id, password FROM user_admin WHERE email='$email' ");
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
                    //Chuyển hướng qua trang quản lý users
                    redirect('?module=admin/active&action=test');
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
    redirect('?module=admin&action=auth/login');
}
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

<div id="loginbox">
    <form method="POST" class="form-vertical">
        <h3 class="text-center text-uppercase">Đăng nhập hệ thống</h3>

        <?php getMsg($msg, $msgType); ?>

        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_lg"><i class="far fa-user"></i></i></span>
                    <input type="text" name="email"
                           placeholder="Email..."/>
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="fas fa-lock"></i></i></span>
                    <input type="password" name="password" placeholder="Mật khẩu..." required/>
                </div>
            </div>
        </div>
        <div class="form-actions center">
            <button type="submit" class="btn btn-block btn-large btn-info">
                Đăng nhập
            </button>
        </div>
    </form>
    <div class="pull-left">
        <a href="?module=customer&action=auth/login">Khách hàng đăng nhập</a>
    </div>

    <div class="pull-right">
        <a href="?module=admin&action=auth/forgot">Quên mật khẩu</a>
    </div>

    <?php
    layout("footer_login");
    ?>

