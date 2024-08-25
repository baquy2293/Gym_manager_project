<?php

layout('header', 'admin');
layout('sidebar', 'admin');
$qry = "select * from cource";
$result = getRaw($qry);
$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>
    <div class="content-wrapper">
    <div class="span12">
        <br>
        <a class="btn btn-large btn-primary text-white" href="?module=admin&action=add_cource"><i class="fa fa-plus"
                                                                                                  aria-hidden="true"></i>
            Thêm khóa tập</a>

        <div class='widget-box'>
            <br>
            <?php
            getMsg($msg, $msgType);
            ?>
            <br>

            <table class='table table-bordered table-hover'>
                <thead>
                <tr style="text-align: center">
                    <th class="col-1">STT</th>
                    <th class="col-2">Tên khóa tập</th>
                    <th class="col-2">Giá khóa tập</th>
                    <th class="col-2">Thời lượng(/tháng)</th>
                    <th class="col-3">Mô tả</th>
                    <th class="col-2">Hành động</th>
                </tr>
                </thead>
                <?php
                if (!empty($result)):
                $count = 0; //Hiển thị số thứ tự
                foreach ($result

                as $item):
                $count++;
                ?>
                <tbody>
                <tr class=''>
                    <td>
                        <div class='text-center'><?php echo $count; ?></div>
                    </td>
                    <td>
                        <div class='text-center'><?php echo $item['name']; ?></div>
                    </td>
                    <td>
                        <div class='text-center'><?php echo $item['price']." VND"; ?></div>
                    </td>
                    <td>
                        <div class='text-center'><?php echo $item['time']. " tháng"; ?></div>
                    </td>
                    <td>
                        <div class='text-center'><?php echo $item['description']; ?></div>
                    </td>
                    <td>
                        <div class='text-center'><a
                                    href="<?php echo _WEB_HOST_ROOT . '?module=admin&action=edit_cource&id=' . $item['id']; ?>"><i
                                        class='fas fa-edit' style='color:#28b779'></i> Edit
                                |</a href='edit_pt.php?id=" .<?php echo $item['id'] ?> .
                                "'> <a
                                    href="<?php echo _WEB_HOST_ROOT . '?module=admin&action=delete_cource&id=' . $item['id']; ?>"
                                    style='color:#F66;'><i
                                        class='fas fa-trash'></i> Remove</a></div>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="7">
                            <div class="alert alert-danger text-center">Không có khóa tập nào</div>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active">
                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
<?php
layout("footer", "admin"); ?>