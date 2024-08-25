<?php
if (!defined('_INCODE')) die('Access Deined...');
$id = getBody()['id'];
echo $id;
if (isLogin()&& getSession("admin")==1) {
    if (!empty($id)) {
        $deletePt = delete("cource", "id=$id");
        if ($deletePt) {
            setFlashData('msg', 'Xóa khóa tập thành công');
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Không tồn tại khóa tập trong hệ thống ');
            setFlashData('msg_type', 'danger');
        }

    } else {
        setFlashData('msg', 'Không tồn tại khóa tập trong hệ thống ');
        setFlashData('msg_type', 'danger');
    }
} else {
    die('Access Deined...');
}

redirect('?module=admin&action=list_cource');