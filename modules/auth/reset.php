<?php
if (!defined('_INCODE')) die('Access Deined...');
/*File này chứa chức năng đặt lại mật khẩu*/
layout("header_login");

$token = getBody()['token'];

if (!empty($token)) {
    //Truy vấn kiểm tra token với database
    $tokenQuery = firstRaw("SELECT id, email FROM users WHERE forgotToken='$token'");

    if (!empty($tokenQuery)) {
        $userId = $tokenQuery['id'];
        $email = $tokenQuery['email'];

        if (isPost()) {
            $body = getBody();
            $errors = []; //Mảng lưu trữ các lỗi
            //Validate mật khẩu: Bắt buộc phải nhập, >=8 ký tự
            if (empty(trim($body['password']))) {
                $errors['password']['required'] = 'Mật khẩu bắt buộc phải nhập';
            } else {
                if (strlen(trim($body['password'])) < 8) {
                    $errors['password']['min'] = 'Mật khẩu không được nhỏ hơn 8 ký tự';
                }
            }
            //Validate nhập lại mật khẩu: Bắt buộc phải nhập, giống trường mật khẩu
            if (empty(trim($body['confirm_password']))) {
                $errors['confirm_password']['required'] = 'Xác nhận mật khẩu không được để trống';
            } else {
                if (trim($body['password']) != trim($body['confirm_password'])) {
                    $errors['confirm_password']['match'] = 'Hai mật khẩu không khớp nhau';
                }
            }

            if (empty($errors)) {
                //xử lý update mật khẩu
                $passwordHash = password_hash($body['password'], PASSWORD_DEFAULT);
                $dateUpdate = [
                    'password' => $passwordHash,
                    'forgotToken' => null,
                    'updateAt' => date('Y-m-d H:i:s')
                ];
                $updateStatus = update('users', $dateUpdate, "id=$userId");
                if ($updateStatus) {

                    setFlashData('msg', 'Thay đổi mật khẩu thành công');
                    setFlashData('msg_type', 'success');

                    //Gửi email thông báo khi đổi xong
                    $subject = 'Bạn vừa đổi mật khẩu';
                    $content = 'Chúc mừng bạn đã đổi mật khẩu thành công!';
                    sendMail($email, $subject, $content);

                    redirect('?module=auth&action=login');
                } else {
                    setFlashData('msg', 'Lỗi hệ thống! Bạn không thể đổi mật khẩu');
                    setFlashData('msg_type', 'danger');
                }

            } else {
                setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
                setFlashData('msg_type', 'danger');
                setFlashData('errors', $errors);
            }
            redirect('?module=auth&action=reset&token=' . $token);
        } //End isPost()

        $msg = getFlashData('msg');
        $msgType = getFlashData('msg_type');
        $errors = getFlashData('errors');
    } else {
        getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
    }
} else {
    getMsg('Liên kết không tồn tại hoặc đã hết hạn', 'danger');
}
?>
    <div id="loginbox">
        <form id="loginform" method="POST" class="form-vertical" action="#">
            <h3 class="text-center text-uppercase" style="color: #FFFFFF">Đặt lại mật khẩu</h3>
            <?php getMsg($msg, $msgType); ?>

            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="far fa-user"></i></i></span>
                        <input type="password" name="password" placeholder="Mật khẩu..."/>
                        <?php echo form_error('password', $errors, '<span class="error">', '</span>'); ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="fas fa-lock"></i></i></span>
                        <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu..."/>
                        <?php echo form_error('confirm_password', $errors, '<span class="error">', '</span>'); ?>
                    </div>
                </div>
            </div>
            <div class="form-actions center">
                <button type="submit" class="btn btn-block btn-large btn-info">
                    Xác nhận
                </button>
            </div>
            <input type="hidden" name="token" value="<?php echo $token; ?>">
        </form>


    </div>';
<?php
layout('header-footer');