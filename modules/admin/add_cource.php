<?php
if (!defined('_INCODE')) die('Access Deined...');
layout('header', "admin");

if (isPost()) {
    $body = getBody();
    $errors = [];
    if (empty(trim($body['name']))) {
        $errors['name']['required'] = 'Tên bắt buộc phải nhập';
    }

    if (empty(trim($body['price']))) {
        $errors['price']['required'] = 'Tiền bắt buộc phải nhập';
    }

    if (empty(trim($body['time']))) {
        $errors['time']['required'] = 'Thời hạn bắt buộc phải nhập';
    }

    if (empty(trim($body['description']))) {
        $errors['description']['required'] = 'Mô tả không được để trống';
    }

    if (empty($errors)) {
        $dataInsert = [
            'name' => $body['name'],
            'price' => $body['price'],
            'time' => $body['time'],
            'description' => $body['description'],
        ];

        $insertStatus = insert('cource', $dataInsert);
        if ($insertStatus) {
            setFlashData('msg', 'Thêm khóa học thành công');
            setFlashData('msg_type', 'success');
            redirect('?module=admin&action=list_cource');

        } else {
            setFlashData('msg', 'Hệ thống đang gặp sự cố! Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger');
        }
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('msg_type', 'danger');
    }
    setFlashData('errors', $errors);
    setFlashData('old', $body);
    redirect('?module=admin&action=add_cource');
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
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Thêm khóa tập</h3>
                        <?php getMsg($msg, $msgType); ?>
                        <form method="post">
                            <div class="col-md-12 mb-3">
                                <div data-mdb-input-init class="form-outline">
                                    <input type="text" name="name" placeholder="Tên khóa học ..."
                                           class="form-control form-control-lg"
                                           value="<?php echo old('name', $old); ?>"/>
                                    <?php echo form_error('name', $errors, '<span class="error btn-warning">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div data-mdb-input-init class="form-outline">
                                    <input type="number" placeholder="Giá tiền..." name="price"
                                           class="form-control form-control-lg"
                                           value="<?php echo old('price', $old); ?>"/>
                                    <?php echo form_error('price', $errors, '<span class="error btn-warning">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div data-mdb-input-init class="form-outline">
                                    <input type="number" placeholder="Thời hạn..." name="time"
                                           class="form-control form-control-lg"
                                           value="<?php echo old('time', $old); ?>"/>
                                    <?php echo form_error('time', $errors, '<span class="error btn-warning">', '</span>'); ?>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div data-mdb-input-init class="form-outline">
                                    <textarea placeholder="Mô tả ..." name="description"
                                              class="form-control form-control-lg"
                                              value="<?php echo old('description', $old); ?>"></textarea>

                                    <?php echo form_error('description', $errors, '<span class="error btn-warning">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-6 mb-5 btn-large">
                                    <button type="submit" class="btn btn-success btn-large "> Thêm</button>
                                </div>
                                <div class="col-md-6 mb-5 btn-large">
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