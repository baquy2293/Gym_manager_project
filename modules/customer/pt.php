<?php
$data = [
    'pageTitle' => 'Danh sách huấn luyện viên',
    'style' => 'home',
];
layout("header", "client", $data);
?>

<main>
    <!-- end product-hot -->
    <div class="product_lemonTea">
        <div class="title-product_hot">
            <h1 id="title_deal">Danh sách Huấn luyện viên</h1>
        </div>
        <!-- end title-product_hot -->
        <table class="table table-striped table-success  table-bordered">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">email</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Giới tính</th>
                    <th scope="col">Địa chỉ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $data = getRaw('select * from pt');
                $a=1;
                foreach ($data as $key => $value) {
                echo ' <tr>
                <th scope="row">'.$a++.'</th>
                 <td>'.$value['email'].'</td>
                    <td>'.$value['fullname'].'</td>
                    <td>'.$value['phone'].'</td>
                     <td>'.$value['gender'].'</td>
                    <td>'.$value['address'].'</td> 
                    </tr>   
                ';
                }
                ?>
            </tbody>
        </table>
    </div>
</main>