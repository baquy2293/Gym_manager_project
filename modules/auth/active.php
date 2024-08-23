<?php
if (!defined('_INCODE')) die('Access Deined...');
/*File này chức chức năng kích hoạt tài khoản*/
layout("header_login");
echo '<div class="container text-center"><br/>';

$token = getBody()['token'];
$tokenQuery = firstRaw("SELECT id, fullname, email FROM users WHERE activeToken='$token'");
if (!empty($token) && !empty($tokenQuery['id'])) {
    if (isPost()) {
        $userId = $tokenQuery['id'];
        $dataUpdate = [
            'activeToken' => null
        ];
        $updateStatus = update('users', $dataUpdate, "id=$userId");
        if ($updateStatus) {
            setFlashData('msg', 'Kích hoạt tài khoản thành công tài khoản! ');
            setFlashData('msg_type', 'success');
            //Tạo link login
            $loginLink = _WEB_HOST_ROOT . '?module=auth&action=login';
            //Gửi email nếu kích hoạt thành công
            $subject = 'Kích hoạt tài khoản thành công';
            $content = 'Chúc mừng ' . $tokenQuery['fullname'] . ' đã kích hoạt thành công.<br/>';
            $content .= 'Bạn có thể đăng nhập tại link sau: ' . $loginLink . '<br/>';
            $content .= 'Trân trọng!';
            sendMail($tokenQuery['email'], $subject, $content);
        } else {
            setFlashData('msg', 'Kích hoạt tài khoản không thành công! Vui lòng liên hệ quản trị viên');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=auth&action=login');
    }
} else {
    getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
}

$msg = getFlashData("msg");
$type = getFlashData("msg_type");
echo '</div>';
?>
    <div class="loginbox" style="text-align: center">
        <form method="POST">
            <h1> Bạn có yêu cầu đăng kí tài khoản</h1>
            <?php getMsg($msg, $type); ?>
            <div class="buton">
                <button type="submit" class="btn btn-success btn-large"> Xác Nhận</button>
            </div>
            <input type="hidden" name="token" value="<?php echo $token; ?>">
        </form>
    </div>

<?php

layout('header-footer');
?>