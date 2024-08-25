<?php
if (!defined('_INCODE')) die('Access Deined...');
layout('header', "admin");
if (isPost()) {
    $body = getBody();
    $errors = [];
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
            $sql = "SELECT id FROM pt WHERE email='$email'";
            if (getRows($sql) > 0) {
                $errors['email']['unique'] = 'Địa chỉ email đã tồn tại';
            }
        }
    }
    if (empty(trim($body['address']))) {
        $errors['address']['required'] = 'Địa chỉ không được để trống';
    }
    if (empty($errors)) {
        if ($body['gender'] == 1) {
            $body['gender'] = "Nữ";
        } elseif ($body['gender'] == 2) {
            $body['gender'] = "Nam";
        } else {
            $body['gender'] = "Khác";
        }
        $dataInsert = [
            'email' => $body['email'],
            'fullname' => $body['fullname'],
            'phone' => $body['phone'],
            'address' => $body['address'],
            'gender' => $body['gender'],
            'createAt' => date('Y-m-d H:i:s'),
        ];
        $insertStatus = insert('pt', $dataInsert);
        if ($insertStatus) {
            setFlashData('msg', 'Thêm tài khoản thành công');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Hệ thống đang gặp sự cố! Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=admin&action=list_pt');
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $body);
    }
}
$msg = getFlashData("msg");
$msgType = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>
<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Thêm huấn luyện viên</h3>
                        <?php getMsg($msg, $msgType); ?>
                        <form method="post">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" name="fullname" placeholder="Họ và tên ..."
                                               class="form-control form-control-lg"
                                               value="<?php echo old('fullname', $old); ?>"/>
                                        <label class="form-label" for="fullname">Họ và tên</label>
                                        <?php echo form_error('fullname', $errors, '<span class="error btn-warning">', '</span>'); ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div data-mdb-input-init class="form-outline">
                                        <input type="text" placeholder="Địa chỉ ..." name="address"
                                               class="form-control form-control-lg"
                                               value="<?php echo old('address', $old); ?>"/>
                                        <label class="form-label" for="address">Địa chỉ</label>
                                        <?php echo form_error('address', $errors, '<span class="error btn-warning">', '</span>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4 d-flex align-items-center">
                                    <div data-mdb-input-init class="form-outline datepicker w-100">
                                        <input type="text" placeholder="Số điện thoại ..."
                                               class="form-control form-control-lg" name="phone"
                                               value="<?php echo old('phone', $old); ?>"/>
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <?php echo form_error('phone', $errors, '<span class="error btn-warning">', '</span>'); ?>

                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h6 class="mb-2 pb-1">Giới tính: </h6>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender"
                                               name="femaleGender"
                                               value="1" checked/>
                                        <label class="form-check-label" for="femaleGender">Nữ</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender"
                                               id="maleGender"
                                               value="2"/>
                                        <label class="form-check-label" for="maleGender">Nam</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender"
                                               id="otherGender"
                                               value="0"/>
                                        <label class="form-check-label" for="otherGender">Khác</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4 pb-2">

                                    <div data-mdb-input-init class="form-outline">
                                        <input type="email" placeholder="Email..." name="email"
                                               class="form-control form-control-lg"
                                               value="<?php echo old('email', $old); ?>"/>
                                        <label class="form-label" for="email">Email</label>
                                        <?php echo form_error('email', $errors, '<span class="error btn-warning">', '</span>'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-7 pb-2 btn-large">
                                    <button type="submit" class="btn btn-success btn-large "> Thêm</button>
                                </div>
                                <div class="col-md-6 mb-7 pb-2 btn-large">
                                    <a href="?module=admin&action=list_pt" class="btn btn-danger btn-large">
                                        Hủy </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>