<?php
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {

} else {
    http_response_code(404);
    exit();
}
?>
<?php
$databasefile = '../../config/database.php';
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
$query = "SELECT * FROM nr_user WHERE password = '" . $_COOKIE['password'] . "'";
$result = $connection->query($query);
if ($result->num_rows > 0) {
    // 输出结果
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];
        $name = $row['name'];
        $money = $row['money'];
        $paymentcode = $row['paymentcode'];

        $status = $row['status'];
        $password = $row['password'];
        $ordercount = $row['ordercount'];

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
    <link rel="stylesheet" href="../../CSS/style.css">
    <link rel="stylesheet" href="../../CSS/broudcast.css">
    <link rel="stylesheet" href="../../CSS/broudcast-icon.css">
    <link rel="stylesheet" href="../../CSS/shop-icon.css">

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
            <?php echo $name; ?> 的钱包
        </h1>
    </div>
    <br>
    <div class="round">
        <h1 style="text-align: center;">
            <span style="font-size: 36px; color: rgb(227, 108, 9);">￥
                <?php echo $money; ?><br />
            </span>
        </h1>
    </div>
    <br>
    <div class="round">
        <p style="text-align: center;">

            账户状态：
            <?php
            if ($status == '1') {
                echo '<span style="color: rgb(0, 176, 80);">正常</span>';
            } else {
                echo '<span style="color: rgb(255, 0, 0);">异常，请联系管理员</span>';
            }
            ?>
        </p>
        <p style="text-align: center;">
            <span style="color: rgb(0, 0, 0);">可提资金：<span style="color: rgb(255, 0, 0);">￥
                    <?php echo (float) $money - 1; ?>
                </span></span>
        </p>
        <p style="text-align: center;">
            <span style="color: rgb(0, 0, 0);">收款方式：微信
                <?php
                if ($paymentcode) {
                    echo '<span
            style="color: rgb(146, 208, 80);">[收款码已上传]</span>';
                } else {
                    echo '<span
            style="color: rgb(255,0,0);">[请联系管理员]</span>';
                }
                ?>
                <br />
            </span>
        </p>
        <p style="text-align: center;">
            <span style="color: rgb(0, 0, 0);">结算周期：T+1</span>
        </p>
    </div>
    <br>
    <div class="round">
        <button type="button" class="layui-btn layui-btn-lg layui-btn-normal" onclick="recditToMoney(<?php echo (float)$money-1;?>,'<?php echo $paymentcode?>',<?php echo $money?>)" <?php if ($money<=1){echo "disabled";}?>>提现可用资金</button>
    </div>
    <script src="https://cdn.staticfile.net/layui/2.9.4/layui.js"></script>
    <script src="https://cdn.bootcss.com/blueimp-md5/2.12.0/js/md5.min.js"></script>
    <script>
        function recditToMoney(money,paymentcode,y){
            layer.confirm('确认提现'+money+'元？若无违规将在1天后打款至微信账户。', { icon: 3 }, function () {
                var xhr = new XMLHttpRequest();

                // 设置请求方法和URL
                var url = "tixian.php?money=" + money + "&paymentcode="+paymentcode+"&y="+y+"&key=" + md5(btoa(encodeURIComponent(money+paymentcode+y)));
                xhr.open("GET", url, true);

                // 定义请求完成时的回调函数
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // 请求成功，显示服务器返回的结果
                        location.reload();
                    } else if (xhr.readyState === 4) {
                        // 请求出错或失败，显示错误信息
                        alert("Error: " + xhr.status);
                    }
                };

                // 发送请求
                xhr.send();
                location.reload();
            }, function () {
                layer.msg('已取消');
            });
        }
    </script>

</body>