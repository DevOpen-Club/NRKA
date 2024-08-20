<?php
$databasefile = './config/database.php';
$database = include($databasefile);
$commodity = $_GET['id'];
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
$query = "SELECT * FROM nr_commodity WHERE id = " . $commodity . "";
$result = $connection->query($query);
$order=date("YmdHis") . mt_rand(1000, 9999);
if ($result->num_rows > 0) {
    // 输出结果
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['name'];
        $introduce = $row['introduce'];
        $price = $row['price'];
        $image = $row['image'];
        $status = $row['status'];
        $user = $row['user'];
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
    <style>
        .submit {
            background-color: green;
            color: white;
            padding: 10px;
            font-size: 15px;
            border: none;
            border-radius: 10px;
            width: 100%;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <br>
    <div class="round">
        <h1>
            下单支付
        </h1>
    </div>
    <br>
    <div class="round">
        <p>订单号：
            <?php echo $order; ?>
        </p>
        <p>
            <span style="color: rgb(255, 0, 0);">请务必复制好订单号！仅可通过订单号获得兑换码/卡密！</span>
        </p>
        <p>商品名称：
            <?php echo $name; ?>
        </p>
        <p>所属商户：
            <?php echo $user; ?>
        </p>
        <h3>订单金额：
            <?php echo $price; ?>
        </h3>
    </div>
    <div class="round">
        <button class="submit" id="submit" onclick="redirectToURL()">微信支付</button>
        <p>暂且仅支持微信支付。</p>
    </div>
    <script src="https://cdn.staticfile.net/layui/2.9.4/layui.js"></script>
    <script>
        layer.alert('您当前下单的商品由<strong><?php echo $user; ?></strong>提供，请谨防诈骗！若发现诈骗现象，请及时联系管理员，我们有机会帮你追回！', {
            time: 5 * 1000,
            success: function (layero, index) {
                var timeNum = this.time / 1000, setText = function (start) {
                    layer.title('<span class="layui-font-red">' + (start ? timeNum : --timeNum) + '</span> 秒后自动关闭', index);
                };
                setText(!0);
                this.timer = setInterval(setText, 1000);
                if (timeNum <= 0) clearInterval(this.timer);
            },
            end: function () {
                clearInterval(this.timer);
            }
        });
        function redirectToURL() {
            window.location.href = "./pay/index.php?order=<?php echo $order;?>&commodity=<?php echo $id;?>";
        }
        
    </script>
</body>