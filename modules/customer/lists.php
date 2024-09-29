<?php
if (!isLogin()) {

    redirect("?module=auth&action=login");
}

$data = [
    'pageTitle' => 'Danh sách khóa tập',
    'style' => 'home',
];
layout('header', 'client', $data);

?>
<!-- end header -->
<main>
    <!-- end product-hot -->
    <div class="product_lemonTea">
        <div class="title-product_hot">
            <h1 id="title_deal">Danh sách khóa tập</h1>
        </div>
        <!-- end title-product_hot -->
        <div class="box-product_Hot">
            <?php

            $result = getRaw("SELECT * FROM cource");
            foreach ($result as $key => $value) {

                echo '
                    <div class="item-product-hot">
                      <div class="item-product-hot-img">
                       <img src="' . _WEB_HOST_TEMPLATE . '/img/' . $value['img'] . '" alt="">
                        <a href="?module=customer&action=detail&id=' . $value["id"] . '">Mua Ngay</a>
                      </div>
                      <div class="item-product-information">
               <a href="?module=customer&action=detail&id=' . $value["id"] . '" class="name-product">' . substr($value['name'], 0, 24) . '</a>
            <span class="discount"> ' . $value['time'] . 'T</span>
              <span class="text-primary">' . $value['description'] . ' đ</span>
              <br>
                        <span class="priceSaled-product">' . number_format($value['price']) . ' đ</span>
                      </div>
                    </div>
                    <!-- end  item-product-hot-->
                    ';
            }
            ?>
        </div>
    </div>

    <div class="product_lemonTea">
        <div class="title-product_hot">
            <h1 id="title_deal">Khóa tập của tôi</h1>
        </div>
        <!-- end title-product_hot -->
        <div class="box-product_Hot">
            <table class="table table-striped table-success  table-bordered">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Khóa học</th>
                        <th scope="col">Lịch trình</th>
                        <th scope="col">Tên người hướng dẫn</th>
                        <th scope="col">Ngày hết hạn</th>
                        <th scope="col">Trạng thái</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = getRaw("SELECT c.name,c.plan,pt.fullname,byc.active,byc.end FROM bycource as byc JOIN pt on byc.pt_id=pt.id JOIN cource as c on c.id=byc.cource_id JOIN users as u ON u.id=byc.user_id WHERE u.id='25'");
                    $a = 1;
                    foreach ($data as $key => $value) {
                        $active = false;
                        $timecrent = new DateTime();
                        $time = new  DateTime($value['end']);
                        if ($time > $timecrent) {
                            $active = true;
                        }
                        if ($value['active'] == 1) {
                            echo ' <tr>
                <th scope="row">' . $a++ . '</th>
                 <td>' . $value['name'] . '</td>
                    <td>' . $value['plan'] . '</td>
                    <td>' . $value['fullname'] . '</td>
                    <td>' . (new DateTime($value['end']))->format('H:i:s d-m-Y') . '</td>
                    ';
                            if ($active) {
                                echo "<td class='text-success'>Còn hạn</td>";
                            } else {
                                echo "<td class='text-danger'>Hết hạn</td>";
                            }
                            echo " </tr>  ";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php
layout('footer', 'client', $data);
