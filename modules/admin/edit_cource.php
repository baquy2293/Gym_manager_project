<?php
if (!defined('_INCODE')) die('Access Deined...');
layout('header', "admin");
$body = getBody();

if (!empty($body['id'])) {
    $courceId = $body['id'];

    //Kiểm tra userId có tồn tại trong Database hay không?
    //Nếu tồn tại => Lấy ra thông tin
    //Nếu không tồn tại => Chuyển hướng về trang lists
    $courceDetail = firstRaw("SELECT * FROM cource WHERE id=$courceId");
    if (!empty($courceDetail)) {
        //Tồn tại
        //Gán giá trị $userDetail vào flashData
        setFlashData('courceDetail', $courceDetail);
    } else {

        redirect('?module=admin&action=list_cource');
    }

} else {
    redirect('?module=admin&action=list_cource');
}

if (isPost()) {
    $body = getBody();
    $error = [];

    if (empty(trim($body['name']))) {
        $errors['name']['required'] = 'Tên bắt buộc phải nhập';
    }else{
        $name = trim($body['name']);
        $sql = "SELECT id FROM cource WHERE name='$name'AND id<>$courceId ";
        if (getRows($sql) > 0) {
            $errors['name']['unique'] = 'Tên đã tồn tại';
        }
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
        $courceId = $body['id'];
        $insertStatus = update("cource", $dataInsert, "id=$courceId");
        if ($insertStatus) {
            setFlashData('msg', 'Sửa khóa tập thành công');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Hệ thống đang gặp sự cố! Vui lòng thử lại sau.');
            setFlashData('msg_type', 'danger');
        }
        redirect('?module=admin&action=list_cource');
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
$courceDetail = getFlashData('courceDetail');
if (!empty($courceDetail)) {
    $old = $courceDetail;
}

?>

<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Sửa khóa tập</h3>
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
                                             ><?php echo old('description', $old); ?></textarea>
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
                                <input name="id" type="hidden" value="<?php echo $courceId ?>">


                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>