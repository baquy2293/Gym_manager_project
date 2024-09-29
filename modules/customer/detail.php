<?php 
if (!isLogin()){

    redirect("?module=auth&action=login");
}
$data=[
    'pageTitle'=>'Chi tiết khóa học',
    'style'=> 'detail',
];
layout('header','client',$data);


// if(isPost()){
//     $body = getBody();

// }
?>
        <main>
            <div class="box_information_product">
                <div class="title_information_product">
                    <h1>Thông Tin Sản Phẩm</h1>
                </div>
                <form action="" method="post">
                    <div class="show_product">
                        <?php
                       
                        if (isset($_GET['id'])) {

                            $idProduct = $_GET['id'];
                            // $result = $conn -> query("SELECT product.image, product.nameProduct, product.price, product.discount, size.size1, size.size2, size.size3  FROM product INNER JOIN size INNER JOIN category ON product.id_category = category.id_category AND category.id_size = size.id_size WHERE id_product = ".$idProduct."");
                            $result_cource = getRaw("select * from cource where id = '$idProduct'");
                            $result_pt = getRaw("select * from pt ");
                            foreach ($result_cource as $key => $row) {
                                echo '
                                <div class="img_product">
                                  <img src="'._WEB_HOST_TEMPLATE.'/img/' . $row['img'] . '" alt="" />
                                </div>
                                <!-- end img_product -->
                                <div class="information_product">
                                  <div class="title_product_item">
                                    <h2>' . $row['name'] . '</h2>
                                  </div>
                                  <div class="content_product_item">
                                    <p class="price">Giá: <span>' . ($row['price'] ) . ' đ</span></p>
                                    <div class="size">
                                      <label for="">Lựa Chọn giáo viên: </label>
                                      <select name="listChooseSize" id="">';
                                      foreach ($result_pt as $key2 => $row2) {
                                        echo '<option value="' . $row2['id'] . '">' . $row2['fullname'] . '</option>';
                                      } 
                                            echo '
                                        </select>
                                      </div>
                                        <div class="buy_roduct">
                                          <button type="submit" class="bnt_buyNow">Mua Ngay</button>
                                        </div>
                                    </div>
                                    <!-- end content_product_item -->
                                  </div>
                                  <!-- end information_product -->
                                  ';
                            }
                        }
                        ?>
                    </div>
                </form>
                <!-- end show_product -->
            </div>
        </main>
<?php

layout('footer','client',$data);