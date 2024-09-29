<?php
echo getSession("admin");

layout('header', 'admin');
layout('sidebar', 'admin');
?>
    <div class="content-wrapper ">
        <div class="card-block alert alert-info">
            <div class="row align-items-center b-b-default">
                <div class="col-sm-6 b-r-default p-b-20 p-t-20">
                    <div class="row align-items-center text-center">
                        <div class="col-4 p-r-0">
                            <i class="fa fa-user text-c-purple f-24"></i>
                        </div>
                        <div class="col-8 p-l-0 text-white">
                            <?php
                            echo '
                       <h5>'.getRows('SELECT * from users').'</h5>
                   <p class="text-muted m-b-0 text-white">Người Dùng</p>
                                                                            ';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 p-b-20 p-t-20">
                    <div class=" row align-items-center text-center">
                        <div class="col-4 p-r-0">
                            <i class="fa fa-user text-c-green f-24"></i>
                        </div>
                        <div class="col-8 p-l-0">
                            <?php
                            echo ' 
                             <h5>'.getRows("SELECT * FROM pt") .'</h5>
                             <p class="text-muted m-b-0 text-white">Giảng viên</p>
                            ';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                    <div class="row align-items-center text-center">
                        <div class="col-4 p-r-0 fa fa-cart-plus">
                        </div>
                        <div class="col-8 p-l-0">
                            <?php
                            echo '
                                                                                <h5>'.getRows("SELECT * FROM cource") .'</h5>
                                                                                <p class="text-muted m-b-0 text-white" >Khóa tập </p>
                                                                            ';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 p-b-20 p-t-20">
                    <div class="row align-items-center text-center">
                        <div class="col-4 p-r-0">
                            <i class="fa fa-money text-c-blue f-24"></i>
                        </div>
                        <div class="col-8 p-l-0">
                            <?php

                            echo '
                                                                                <h5>'.getRows("SELECT * FROM bycource ") .'</h5>
                                                                                <p class="text-muted m-b-0 text-white">Đã Bán </p>
                                                                            ';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display: flex; width: 100%;">
            <div class="left" style="flex: 1;">
                <canvas id="myChart" style="width: 100%; height: 250px;"></canvas> <!-- Biểu đồ Doughnut -->
            </div>
            <div class="right" style="flex: 2;">
                <canvas id="myChart1" style="width: 100%; height: 400px;"></canvas> <!-- Biểu đồ Bar -->
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <?php
        // Giả sử hàm getRaw() đã tồn tại và thực hiện việc lấy dữ liệu từ database.
        $sql = 'SELECT MONTH(bycource.createAt) AS month, 
               SUM(cource.price) AS price_count
        FROM bycource 
        JOIN cource 
        ON cource.id = bycource.cource_id 
        GROUP BY MONTH(bycource.createAt)';
        $data = getRaw($sql);
        $sqllesson = "SELECT COUNT(name) as sl, cource.name 
         FROM bycource 
         JOIN cource ON bycource.cource_id = cource.id 
         WHERE bycource.active='1'
         GROUP BY cource.name";
;
        $datalesson = getRaw($sqllesson);
        

        $month = [];
        $price = [];
        $name_cource = [];
        $quantity =[];

        foreach ($data as $row) {
            $month[] = $row['month'];
            $price[] = $row['price_count'];
        }

        foreach ($datalesson as $row) {
            $name_cource[] = $row['name'];
            $quantity[] = $row['sl'];
        }

        ?>

        <script>
            // Biểu đồ Doughnut
            const ctx = document.getElementById('myChart').getContext('2d');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: <?php echo json_encode(array_map(function($m) { return '' . $m; }, $name_cource)); ?>,
                    datasets: [{
                        label: 'Tổng giá trị',
                        data: <?php echo json_encode($quantity); ?>,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Biểu đồ Doughnut - Tổng khóa học đã được bán'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Biểu đồ Bar
            const ctx1 = document.getElementById('myChart1').getContext('2d');

            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_map(function($m) { return 'Tháng ' . $m; }, $month)); ?>,
                    datasets: [{
                        label: 'Tổng giá trị',
                        data: <?php echo json_encode($price); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Biểu đồ Bar - Tổng giá trị theo tháng'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

    </div>

<?php
layout("footer", "admin");