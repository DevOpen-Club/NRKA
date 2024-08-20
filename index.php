<?php
$databasefile = './config/database.php';
$database = include($databasefile);

// 获取数据库连接信息
$host = $database['host'];
$user = $database['user'];
$name = $database['name'];
$password = $database['password'];

// 连接到数据库
$connection = new mysqli($host, $user, $password, $name);
if ($connection->connect_error) {
    die("连接数据库失败: " . $connection->connect_error);
}

// 查询nr_config表
$query = "SELECT * FROM nr_config WHERE id = 0";
$result = $connection->query($query);

if ($result->num_rows > 0) {
    // 输出结果
    while ($row = $result->fetch_assoc()) {
        $broadcast = $row['broadcast'];
        $sitename = $row['sitename'];
        $broadcasttext = $row['broadcasttext'];
        // echo "broadcast: " . $broadcast . "<br>";
        // echo "sitename: " . $sitename . "<br>";
    }
} else {
    echo "没有找到匹配的数据";
}

// 关闭数据库连接
$connection->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="./CSS/broudcast.css">
    <link rel="stylesheet" href="./CSS/broudcast-icon.css">
    <link rel="stylesheet" href="./CSS/shop-icon.css">
    <link rel="stylesheet" href="./CSS/commodity-card.css">
    <link rel="stylesheet" href="https://cdn.staticfile.net/layui/2.9.4/css/layui.css">
</head>

<body>
    <br>
    <div class="round">
        <h1>
            <?php echo $sitename ?>
        </h1>
    </div>
    <br>
    <div class="round">
        <div class='ad'>
            <i class="iconfont">&#xe633;</i>
            <p class='content'>
                <span>
                    <?php echo $broadcast; ?>
                </span>
            </p>
        </div>
        <div class="broadcast-icon">
            <img style="width: 30px;
  height: 30px;" src="./CSS/img/broadcast.svg" alt="广播图标">
            <span class="divider">|</span>
            <span class="label">公告</span>
        </div>
        <hr class="horizontal-divider">
        <?php echo $broadcasttext; ?>
    </div>
    <br>
    <div class="round">
        <div class="shop-icon">
            <img style="width: 30px;
  height: 30px;" src="./CSS/img/shop.svg" alt="商品图标">
            <span class="divider">|</span>
            <span class="label">购物</span>
        </div>
        <hr class="horizontal-divider">
        <?php
        $databasefile = './config/database.php';
        $database = include($databasefile);

        $servername = $database['host'];
        ;
        $username = $database['user'];
        ;
        $password = $database['password'];
        ;
        $dbname = $database['name'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        $sql = "SELECT id, name, introduce, price, image, status FROM nr_commodity WHERE status=1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $introduce = $row['introduce'];
                $price = $row['price'];
                $image = $row['image'];
                $status = $row['status'];
                echo '<div class="round">
                <div class="container">
                    <div class="image-wrapper">
                        <img src="' . $image . '"
                            alt="Product Image">
                    </div>
                    <div class="details">
                        <h2 class="title">' . $name . '</h2>
                        <p class="description">' . $introduce . '</p>
                        <p class="price">￥ ' . $price . '</p>
                    </div>
                    <div>
                        <a href="./cart.php?id=' . $id . '"><button type="button" class="layui-btn layui-bg-blue">查看详情</button></a>
                    </div>
                </div>
            </div>';
                // echo "id: " . $id . "<br>";
                // echo "name: " . $name . "<br>";
                // echo "introduce: " . $introduce . "<br>";
                // echo "price: " . $price . "<br>";
                // echo "image: " . $image . "<br>";
                // echo "status: " . $status . "<br>";
                // echo "<br>";<?php echo date("YmdHis").mt_rand(100,999);
            }
        } else {
            echo "没有更多商品了呢~/^&^./";
        }
        ?>

    </div>
    <p style="text-align: center;">
        <a href="./businesses" target="_self"><span style="color: rgb(79, 129, 189);">商户入驻</span></a>
    </p>
    <script src="https://cdn.staticfile.net/layui/2.9.4/layui.js"></script>

</body>