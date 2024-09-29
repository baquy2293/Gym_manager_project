<?php
ob_start();
layout('header', 'admin');
layout('sidebar', 'admin');

$allUserNum = getRows("SELECT id FROM bycource");

//1. Xác định được số lượng bản ghi trên 1 trang
$perPage = _PER_PAGE; //Mỗi trang có 3 bản ghi

//2. Tính số trang
$maxPage = ceil($allUserNum / $perPage);

//3. Xử lý số trang dựa vào phương thức GET
if (!empty(getBody()['page'])) {
    $page = getBody()['page'];
    if ($page < 1 || $page > $maxPage) {
        $page = 1;
    }
} else {
    $page = 1;
}

//4. Tính toán offset trong Limit dựa vào biến $page
/*
 * $page = 1 => offset = 0 = ($page-1)*$perPage = (1-1)*3 = 0
 * $page = 2 => offset = 3 = ($page-1)*$perPage = (2-1)*3 = 3
 * $page = 3 => offset = 6 = ($page-1)*$perPage = (3-1)*3 = 6
 *
 * */
$offset = ($page - 1) * $perPage;

//Truy vấn lấy tất cả bản ghi
$listAllpt = getRaw("SELECT byc.id as idb ,u.id as id,u.fullname,u.email,u.phone,c.name,pt.fullname as pt,byc.active,c.price FROM bycource as byc JOIN pt on byc.pt_id=pt.id JOIN cource as c on c.id=byc.cource_id JOIN users as u ON u.id=byc.user_id;");
//Xử lý query string tìm kiếm với phân trang
$queryString = null;
if (!empty($_SERVER['QUERY_STRING'])) {
    $queryString = $_SERVER['QUERY_STRING'];
    $queryString = str_replace('module=pt&action=list_pt', '', $queryString);
    $queryString = str_replace('&page=' . $page, '', $queryString);
    $queryString = trim($queryString, '&');
    $queryString = '&' . $queryString;
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = update('bycource', ['active' => "1"], "id='$id'");
    if ($status) {
        setFlashData("msg", "Đã xác nhận thanh toán");
        setFlashData("msg_type","success");
        redirect("?module=admin&action=price");
    }
}

$msg = getFlashData('msg');
$msgType = getFlashData('msg_type');
?>
<div class="content-wrapper">
    <div class="span12">
        <div class='widget-box'>
            <?php
            getMsg($msg, $msgType);
            ?>
            <br>
            <div class='widget-content nopadding'>
                <table class='table table-bordered table-hover'>
                    <thead>
                        <tr style="text-align: center">
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Khóa tập</th>
                            <th>Giá tiền</th>
                            <th>Huấn luyện viên</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($listAllpt)):
                            $count = 0; //Hiển thị số thứ tự
                            foreach ($listAllpt as $item):
                                $count++;
                        ?>
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
                                        <div class='text-center'><?php echo $item['name']; ?></div>
                                    </td>
                                    <td>
                                        <div class='text-center'><?php echo $item['price']; ?></div>
                                    </td>
                                    <td>
                                        <div class='text-center'><?php echo $item['pt']; ?></div>
                                    </td>
                                    <td>
                                        <?php
                                        if ($item['active'] == "1") {
                                            echo "<btn class='text-center btn btn-success'>Đã thanh toán</btn>";
                                        } else {
                                            echo "<btn><a class='text-center btn btn-danger' href='?module=admin&action=price&id=" . $item['idb'] . "'>Xác nhận thanh toán</a></btn>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach;
                        else: ?>
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
                            echo '<li class="page-item"><a class="page-link" href="' . _WEB_HOST_ROOT . '?module=cource&action=price' . $queryString . '&page=' . $prevPage . '">Trước</a></li>';
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
                                    href="?module=admin&action=price&page=<?php echo $index; ?>"><?php echo $index; ?></a>
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