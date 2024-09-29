<?php 
if (!isLogin()){

    redirect("?module=auth&action=login");
}
$data=[
    'pageTitle'=>'Chi tiết khóa học',
    'style'=> 'detail',
];
layout('header','client',$data);

if(isPost()){
  $body = getBody();
  $now = new DateTime();
  $time = $now->format("Y-m-d H:i:s");
    $data = [
      'createAt'=> $now->format("Y-m-d H:i:s"),
      'end' => getTimeEnd($time,4),
      'user_id'=> $_SESSION['id_user'],
      'pt_id'=> $body['id_pt'],
      'cource_id'=> $_GET['id'],
      'active'=> 0,

    ];
    $status = insert("bycource",$data);
    if($status){
      echo '<div class ="text-center btn-success btn-lg btn-block active">Mua thành công</div>';
    }else{
      echo '<div class =" btn-danger btn-lg btn-block active">Mua thành công</div>';
    }
}

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
                                      <select name="id_pt" id="">';
                                      foreach ($result_pt as $key2 => $row2) {
                                        echo '<option value="' . $row2['id'] . '">' . $row2['fullname'] . '</option>';
                                      } 
                                            echo '
                                        </select>
                                        <p class="text-success" >'.$row['description'].'</p>
                                      </div>
                                        <div class="buy_roduct">
                                        <input type="hidden" name="id_cource" value="'.$_GET['id'].'">
                                        <input type="hidden" name="time" value="'.$_GET['time'].'">
                                          <button type="submit" class="bnt_buyNow" onclick="Bạn có chắc chắn muốn mua khóa tập">Mua Ngay</button>
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