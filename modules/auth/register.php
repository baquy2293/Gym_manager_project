<?php
if (!defined('_INCODE')) die('Access Deined...');
layout("header_login");

if (isPost()) {
    $body = getBody();
    $error = [];
    if (empty(trim($body['fullname']))) {
        $errors['fullname']['required'] = 'Họ tên bắt buộc phải nhập';
    } elseif (strlen(trim($body['fullname'])) < 5) {
        $errors['fullname']['min'] = 'Họ tên phải >= 5 ký tự';
    }

    if (empty(trim($body['phone']))) {
        $errors['phone']['required'] = 'Số điện thoại bắt buộc phải nhập';
    } elseif (!isPhone(trim($body['phone']))) {
        $errors['phone']['isPhone'] = 'Số điện thoại không hợp lệ';
    }

    if (empty(trim($body['email']))) {
        $errors['email']['required'] = 'Email bắt buộc phải nhập';
    } else {
        //Kiểm tra email hợp lệ
        if (!isEmail(trim($body['email']))) {
            $errors['email']['isEmail'] = 'Email không hợp lệ';
        } else {
//            Kiểm tra email có tồn tại trong DB
            $email = trim($body['email']);
            $sql = "SELECT id FROM users WHERE email='$email'";
            if (getRows($sql) > 0) {
                $errors['email']['unique'] = 'Địa chỉ email đã tồn tại';
            }
        }
    }

    if (empty(trim($body['password']))) {
        $errors['password']['required'] = 'Mật khẩu bắt buộc phải nhập';
    } else {
        if (strlen(trim($body['password'])) < 8) {
            $errors['password']['min'] = 'Mật khẩu không được nhỏ hơn 8 ký tự';
        }
    }

    if (empty(trim($body['confirm_password']))) {
        $errors['confirm_password']['required'] = 'Xác nhận mật khẩu không được để trống';
    } else {
        if (trim($body['password']) != trim($body['confirm_password'])) {
            $errors['confirm_password']['match'] = 'Hai mật khẩu không khớp nhau';
        }
    }

    if (empty(trim($body['address']))) {
        $errors['address']['required'] = 'Địa chỉ không được để trống';
    }

    if (empty(trim($body['gender']))) {
        $errors['gender'] = 'Giới tính bắt buộc phải chọn ';
    }


    if (empty($errors)) {
        $activeToken = sha1(uniqid() . time());
        $dataInsert = [
            'email' => $body['email'],
            'fullname' => $body['fullname'],
            'phone' => $body['phone'],
            'address' => $body['address'],
            'password' => password_hash($body['password'], PASSWORD_DEFAULT),
            'activeToken' => $activeToken,
            'gender' => $body['gender'],
            'createAt' => date('Y-m-d H:i:s'),
            'admin' => "0"
        ];

        $insertStatus = insert('users', $dataInsert);
        if ($insertStatus) {
            $linkActive = _WEB_HOST_ROOT . '?module=auth&action=active&token=' . $activeToken;
            $subject = ' Kích hoạt tài khoản';
            $content = 'Bạn có yêu cầu đăng kí tài khoản từ : ' . $body['fullname'] . '<br/>';
            $content .= 'Vui lòng click vào link dưới đây để kích hoạt tài khoản: <br/>';
            $content .= $linkActive . '<br/>';
            $content .= 'Trân trọng!';

            $admin = firstRaw("SELECT email FROM users WHERE admin='1'");
            //Tiến hành gửi email
            $sendStatus = sendMail($admin['email'], $subject, $content);
            if ($sendStatus) {
                setFlashData('msg', 'Đăng ký tài khoản thành công. Vui lòng chờ quản trị  kích hoạt tài khoản');
                setFlashData('msg_type', 'success');
            } else {
                setFlashData('msg', 'Hệ thống đang gặp sự cố! Vui lòng thử lại sau.');
                setFlashData('msg_type', 'danger');
            }

        } else {
            setFlashData('msg', 'Hệ thống đang gặp sự cố! Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=auth&action=register');
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
        redirect('?module=auth&action=register');
    }
}
$msg = getFlashData("msg");
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>


<div id="loginbox">
    <form method="POST">
        <h3 class="text-center text-uppercase" style="color:#FFFFFF;">Khách hàng đăng kí</h3>
        <?php

        getMsg($msg, $msgType); ?>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" placeholder="Email..." value="<?php echo old('email', $old); ?>"/>
                    <?php echo form_error('email', $errors, '<span class="error">', '</span>'); ?>
                </div>
            </div>
        </div>
        <div class=" control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="fas fa-user"></i></span>
                    <input type="text" name="fullname" placeholder="Tên đầy đủ ..."
                           value="<?php echo old('fullname', $old); ?>"/>
                    <?php echo form_error('fullname', $errors, '<span class="error">', '</span>'); ?>
                </div>
            </div>
        </div>
        <div class=" control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="fas fa-phone"></i></span>
                    <input type="number" name="phone" placeholder="Số điện thoại ..."
                           value="<?php echo old('phone', $old); ?>"/>
                    <?php echo form_error('phone', $errors, '<span class="error">', '</span>'); ?>
                </div>
            </div>
        </div>
        <div class=" control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="fas fa-map-marker-alt"></i></i></span>
                    <input type="text" name="address" placeholder="Địa chỉ ..."
                           value="<?php echo old('address', $old); ?>"/>
                    <?php echo form_error('address', $errors, '<span class="error">', '</span>'); ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="fas fa-lock"></i></i></span>
                    <input type="password" name="password" placeholder="Mật khẩu..."/>
                    <?php echo form_error('password', $errors, '<span class="error">', '</span>'); ?>
                </div>
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <div class="main_input_box">
                    <span class="add-on bg_ly"><i class="fas fa-lock"></i></i></span>
                    <input type="password" name="confirm_password"
                           placeholder="Xác nhận mật khảu..."/>
                    <?php echo form_error('confirm_password', $errors, '<span class="error">', '</span>'); ?>
                </div>
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <select name="gender" id="select" class="btn btn-block">
                    <option value="" selected="selected">
                        Chọn giới tính
                    </option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <!--                --><?php //echo form_error('gender', $errors, '<span class="error">', '</span>'); ?>
            </div>
        </div>

        <div class="form-actions center">
            <button type="submit" class="btn btn-block btn-large btn-info"
                    value="Admin Login">Đăng kí
            </button>
            <br>
            <a href="?module=auth/&action=login"><p
                        class="btn btn-success btn-large btn-block"> Đăng nhập </p>
            </a>

        </div>
    </form>

    <?php

    layout("footer_login");

    ?>
