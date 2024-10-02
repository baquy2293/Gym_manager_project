<?php

layout('header', 'admin');
layout('sidebar', 'admin');
$qry = "select * from users  where admin != '1' ";
$result = getRaw($qry);
$allUserNum=getRows($qry);
$perPage = _PER_PAGE; //Mỗi trang có 3 bản ghi

//2. Tính số trang
$maxPage = ceil($allUserNum/$perPage);

//3. Xử lý số trang dựa vào phương thức GET
if (!empty(getBody()['page'])){
    $page = getBody()['page'];
    if ($page<1 || $page>$maxPage){
        $page = 1;
    }
}else{
    $page = 1;
}
$offset = ($page-1)*$perPage;
//4. Tính toán offset trong Limit dựa vào biến $page
/*
 * $page = 1 => offset = 0 = ($page-1)*$perPage = (1-1)*3 = 0
 * $page = 2 => offset = 3 = ($page-1)*$perPage = (2-1)*3 = 3
 * $page = 3 => offset = 6 = ($page-1)*$perPage = (3-1)*3 = 6
 *
 * */
$queryString = null;
if (!empty($_SERVER['QUERY_STRING'])){
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('module=pt&action=list_pt', '', $queryString);
    $queryString = str_replace('&page='.$page, '', $queryString);
    $queryString = trim($queryString, '&');
    $queryString = '&'.$queryString;
}



$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>
<div class="content-wrapper">
    <div class="span12">
        <br>
        <a class="btn btn-large btn-primary text-white" href="?module=admin&action=add_user"><i class="fa fa-plus"
                aria-hidden="true"></i>
            Thêm người dùng</a>
        <br>
        <div class='widget-box'>
            <?php
            getMsg($msg, $msgType);
            ?>
            <div class='widget-content nopadding'>
                <table class='table table-bordered table-hover'>
                    <thead>
                        <tr style="text-align: center">
                            <th class="col-1">STT</th>
                            <th class="col-2">Họ tên</th>
                            <th class="col-2">Email</th>
                            <th class="col-2">Số điện thoại</th>
                            <th class="col-1">Giới tính</th>
                            <th class="col-2">Địa chỉ</th>
                            <th class="col-2">Hành động</th>
                        </tr>
                    </thead>
                    <?php
                    if (!empty($result)):
                    $count = 0; //Hiển thị số thứ tự
                    foreach ($result as $item):
                    $count++;
                    ?>
                    <tbody>
                        <tr class=''>
                            <td>
                                <div class='text-center'><?php echo $count; ?></div>
                            </td>
                            <td>
                                <div class='text-center'><?php echo $item['fullname']; ?></div>
                            </td>
                            <td>
                                <div class='text-center'><?php echo $item['email']; ?></div>
                            </td>
                            <td>
                                <div class='text-center'><?php echo $item['phone']; ?></div>
                            </td>
                            <td>
                                <div class='text-center'><?php echo $item['gender']; ?></div>
                            </td>
                            <td>
                                <div class='text-center'><?php echo $item['address']; ?></div>
                            </td>
                            <td>
                                <div class='text-center'><a <?php if ($item['activeToken'] == NULL   ) {  ?>
                                        href="<?php echo _WEB_HOST_ROOT . '?module=admin&action=edit_user&id=' . $item['id']; ?>"><i
                                            class='fas fa-edit' style='color:#28b779'></i> Edit
                                        |</a href='edit_pt.php?id=" .<?php echo $item['id'] ?> .
                                "'> <a href="<?php echo _WEB_HOST_ROOT . '?module=admin&action=delete_user&id=' . $item['id']; ?>"
                                        style='color:#F66;'><i class='fas fa-trash'></i> Remove</a></div>
                                        <?php }else{?>
                                            <a href="<?php echo _WEB_HOST_ROOT . '?module=auth&action=active&token=' . $item['activeToken']; ?>"
                                            style='color:#F66;'><i class="fas fa-clipboard-check"></i></i> Xác nhận</a>

                                            <?php }?>


                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="alert alert-danger text-center">Không có người dùng</div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <nav aria-label="...">
                    <ul class="pagination">
                        <?php
                        if ($page > 1) {
                            $prevPage = $page - 1;
                            echo '<li class="page-item"><a class="page-link" href="' . _WEB_HOST_ROOT . '?module=cource&action=list_user' . $queryString . '&page=' . $prevPage . '">Trước</a></li>';
                        }
                        ?>
                        <?php
                        $begin = $page - 2;
                        if ($begin < 1) {
                            $begin = 1;
                        }
                        $end = $page + 2;
                        if ($end > $maxPage) {
                            $end = $maxPage;
                        }
                        for ($index = $begin; $index <= $end; $index++) { ?>
                        <li class="page-item <?php echo ($index == $page) ? 'active' : ''; ?>">
                            <a class="page-link"
                                href="?module=admin&action=list_user&page=<?php echo $index; ?>"><?php echo $index; ?></a>
                        </li>

                        <?php } ?>
                        <?php
                        if ($page < $maxPage) {
                            $nextPage = $page + 1;
                            echo '<li class="page-item"><a class="page-link" href="?page=' . $nextPage . '">Sau</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <?php
layout("footer", "admin"); ?>