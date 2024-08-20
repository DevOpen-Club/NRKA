<?php

echo '请稍后，正在为您下单';
$commodity_id = $_GET['commodity'];
$order_id = $_GET['order'];

$databasefile = '../config/database.php';
$database = include($databasefile);

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
$query = "SELECT * FROM nr_commodity WHERE id = " . $commodity_id . "";
$result = $connection->query($query);

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

        $servername = $database['host']; // 数据库服务器名称
        $username = $database['user']; // 数据库用户名
        $password = $database['password']; // 数据库密码
        $dbname = $database['name']; // 数据库名

        // 创建数据库连接
        $conn = new mysqli($servername, $username, $password, $dbname);

        // 检查连接是否成功
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }
        $time = date('YmdHis');
        // 准备插入数据的 SQL 查询
        $sql = "INSERT INTO nr_order (order_number, commodity_name, price,paytype,time,status,commodity_id)
        VALUES ($order_id, '$name', $price,'wechat',$time,0,$commodity_id)";

        // 执行 SQL 查询
        if ($conn->query($sql) === TRUE) {
            echo "订单已创建";
        } else {
            echo "错误: " . $sql . "<br>" . $conn->error;
        }

        // 关闭数据库连接
        $conn->close();

        $zzcode_id="123456";//这里改成您的商户id
        $zzcode_key="cf7addb128b8da2bccfb8bfc336d3435"; //这是您的KEY
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "pid" => $zzcode_id,//你的商户ID
            "type" => 'wxpay',//alipay支付宝支付、wxpay微信支付
            "notify_url" => 'http://6866.site/pay/notify.php',//异步通知地址
            "return_url" => 'http://6866.site/pay/return.php',//页面返回地址
            "out_trade_no" => $order_id,//订单号
            "name" => $name,//商品名称
            "money" =>$price,//支付金额
            "sitename" => 'DevOpen',//网站名称
            "sign_type"=>'MD5'
        );
        ksort($parameter); //重新排序$parameter数组
        reset($parameter); //内部指针指向数组中的第一个元素
        $sign = ''; //初始化需要签名的字符为空
        $urls = ''; //初始化URL参数为空
        foreach ($parameter AS $key => $val) { //遍历需要传递的参数
            if ($val == '' || $key == 'sign' || $key == "sign_type" ) continue; //跳过这些不参数签名
            if ($sign != '') { //后面追加&拼接URL
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值
        }
        $query = $urls . '&sign=' . md5($sign .$zzcode_key).'&sign_type=MD5'; //创建订单所需的参数
        $url = "https://pay.devopen.top/submit.php?{$query}"; //支付页面
        header("Location:{$url}"); //跳转到支付页面   






        // echo "broadcast: " . $broadcast . "<br>";
        // echo "sitename: " . $sitename . "<br>";
    }
} else {
    echo "没有找到匹配的数据";
}

// 关闭数据库连接
$connection->close();


?>