<?php
if (!defined('_INCODE')) die('Access Deined...');
/*File này chức chức năng kích hoạt tài khoản*/
layout('header-login');
echo '<div class="container text-center"><br/>';
$token = getBody()['token'];
if (!empty($token)){
    //Truy vấn kiểm tra token với database
    $tokenQuery = firstRaw("SELECT id, fullname, email FROM users WHERE activeToken='$token'");
    if (!empty($tokenQuery)){
        $userId = $tokenQuery['id'];
        $dataUpdate = [
            'status' => 1,
            'activeToken' => null
        ];
        $updateStatus = update('users', $dataUpdate, "id=$userId");
        if ($updateStatus){
            setFlashData('msg', 'Kích hoạt tài khoản thành công! Bạn có thể đăng nhập ngay bây giờ');
            setFlashData('msg_type', 'success');

            //Tạo link login
            $loginLink = _WEB_HOST_ROOT.'?module=auth&action=login';

            //Gửi email nếu kích hoạt thành công
            $subject = 'Kích hoạt tài khoản thành công';
            $content = 'Chúc mừng '.$tokenQuery['fullname'].' đã kích hoạt thành công.<br/>';
            $content.='Bạn có thể đăng nhập tại link sau: '.$loginLink.'<br/>';
            $content.='Trân trọng!';

            sendMail($tokenQuery['email'], $subject, $content);

        }else{
            setFlashData('msg', 'Kích hoạt tài khoản không thành công! Vui lòng liên hệ quản trị viên');
            setFlashData('msg_type', 'danger');
        }

        redirect('?module=auth&action=login');

    }else{
        getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
    }
}else{
    getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
}
echo '</div>';
layout('header-footer');