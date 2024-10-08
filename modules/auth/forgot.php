<?php
if (!defined('_INCODE')) die('Access Deined...');
layout("header_login");$token = sha1(time());

if (isPost()&& $_SESSION['token'] == $_POST['token']) {
    $body = getBody();
    if (!empty($body['email'])) {
        $email = $body['email'];
        $queryUser = firstRaw("SELECT id FROM users WHERE email='$email'");
        if (!empty($queryUser)) {
            $userId = $queryUser['id'];
            //Tạo forgotToken
            $forgotToken = sha1(uniqid() . time());
            $dataUpdate = [
                'forgotToken' => $forgotToken
            ];
            $updateStatus = update('users', $dataUpdate, "id=$userId");
            if ($updateStatus) {
                //Tạo link khôi phục
                $linkReset = _WEB_HOST_ROOT . '?module=auth&action=reset&token=' . $forgotToken;
                //Thiết lập gửi email
                $subject = 'Yêu cầu khôi phục mật khẩu';
                $content = 'Chào bạn: ' . $email . '<br/>';
                $content .= 'Chúng tôi nhận được yêu cầu khôi phục mật khẩu từ bạn. Vui lòng click vào link sau để khôi phục: <br/>';
                $content .= $linkReset . '<br/>';
                $content .= 'Trân trọng!';
                //Tiến hành gửi email
                $sendStatus = sendMail($email, $subject, $content);
                if ($sendStatus) {
                    setFlashData('msg', 'Vui lòng kiểm tra email để xem hướng dẫn đặt lại mật khẩu');
                    setFlashData('msg_type', 'success');
                } else {
                    setFlashData('msg', 'Lỗi hệ thống! Bạn không thể sử dụng chức năng này');
                    setFlashData('msg_type', 'danger');
                }
            } else {
                setFlashData('msg', 'Lỗi hệ thống! Bạn không thể sử dụng chức năng này');
                setFlashData('msg_type', 'danger');
            }
        } else {
            setFlashData('msg', 'Địa chỉ email không tồn tại trong hệ thống');
            setFlashData('msg_type', 'danger');
        }
    } else {
    }
    redirect('?module=auth&action=forgot');
}
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>

<div id="loginbox">
    <form id="loginform" method="POST" class="form-vertical" action="#">
        <h3 class="text-center text-uppercase" style="color:#FFFFFF;">Đặt lại mật khẩu</h3>
        <?php getMsg($msg, $msgType); ?>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="fas fa-lock"></i></i></span>
                    <input type="email" name="email" placeholder="Email..." required/>
                </div>
            </div>
        </div>
        <div class="form-actions center">
        <input type="hidden" name='token' value="<?php echo $token; ?>">
        <?PHP $_SESSION['token'] = $token ?>
            <button type="submit" class="btn btn-block btn-large btn-info" title="Log In" name="login"
                    value="Admin Login">Xác nhận
            </button>
        </div>
    </form>

    <div class="pull-left">
        <a href="?module=auth&action=login">Đăng nhập</a>
    </div>

    <div class="pull-right">
        <a href="?module=auth&action=register">Đăng kí</a>
    </div>

    <?php

    layout("footer_login");

    ?>

