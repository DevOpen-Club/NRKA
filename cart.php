<?php
$commodityid = $_GET['id'];
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
$query = "SELECT * FROM nr_commodity WHERE id =" . $commodityid . "";
$result = $connection->query($query);

if ($result->num_rows > 0) {
    // 输出结果
    while ($row = $result->fetch_assoc()) {
        $status = $row['status'];
        if ($status ==1) {
            $id = $row['id'];
            $name = $row['name'];
            $introduce = $row['introduce'];
            $price = $row['price'];
            $image = $row['image'];
            
            $user = $row['user'];
            // echo "broadcast: " . $broadcast . "<br>";
            // echo "sitename: " . $sitename . "<br>";
        }
        
    }
} else {
    echo "没有找到匹配的数据";
}

// 关闭数据库连接
$connection->close();
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Global Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            padding: 10px;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
        }

        .navbar-text {
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            margin: 0;
        }

        .return-button {
            color: black;
            font-size: 16px;
            justify-self: flex-start;
        }

        .image {
            width: 100%;
            max-width: 450px;
            margin-top: 70px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
            margin-left: 10px;
        }

        .price {
            font-size: 18px;
            font-weight: bold;
        }

        .provider {
            font-size: 12px;
            color: gray;
        }

        .divider {
            border-bottom: 1px solid lightgray;
            margin-top: 10px;
            margin-bottom: 10px;
            width: 100%;
        }

        .description {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        }

        .report-button {
            color: gray;
            font-size: 12px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-seller-button {
            color: gray;
            font-size: 12px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .submit-button {
            background-color: orange;
            color: white;
            padding: 10px;
            font-size: 15px;
            border: none;
            border-radius: 10px;
            width: 60%;
            margin-right: 10px;
        }

        .navbar {
            display: flex;
            justify-content: center;
        }

        .navbar .navbar-text {
            text-align: center;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.staticfile.net/layui/2.9.4/css/layui.css">
</head>

<body>
    <div class="container">
        <div class="navbar">
            <h1 class="navbar-text">
                <?php echo $name; ?>
            </h1>
        </div>
        <img class="image" src="<?php echo $image; ?>" alt="商品图片">
        <h2 class="title">
            <?php echo $name; ?>
        </h2>
        <div class="price">
            <i class="layui-icon layui-icon-rmb" style="font-size: 20px; color: #ff0000;"></i>
            <?php echo $price; ?>
        </div>
        <div class="provider">
            <i class="layui-icon layui-icon-username" style="font-size: 10px; color: #1E9FFF;"></i>
            <?php echo $user; ?>
        </div>
        <hr class="divider">
        <p class="description">
            <?php echo $introduce; ?>
        </p>
    </div>
    <div class="footer">
        <a class="report-button" href="./">
            <i class="layui-icon layui-icon-home" style="font-size: 35px;"></i>

        </a>
        <a class="report-button" href="./report.php">
            <img src="./CSS/img/report.svg" alt="举报图标" style="width: 35px;
  height: 35px;">

        </a>
        <a class="contact-seller-button" href="./contact.php">
            <img src="./CSS/img/contact.svg" alt="联系卖家图标" style="width: 35px;
  height: 35px;">

        </a>
        <button class="submit-button" id="submit" onclick="redirectToURL()"><i class="layui-icon layui-icon-cart"
                style="font-size: 20px; color: #ffffff;"></i> 提交订单</button>
    </div>
    <script>
        function redirectToURL() {
            window.location.href = "./pay.php?id=<?php echo $id;?>";
        }
    </script>
</body>

</html>