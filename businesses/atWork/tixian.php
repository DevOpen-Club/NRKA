<?php
// 获取传入的参数
$money = $_GET['money'];
$key = $_GET['key'];
$paymentcode=$_GET['paymentcode'];
$y=$_GET['y'];
echo $money.' '.$paymentcode.' '.$y; 
// 拼接并加密验证值
$valid_key = md5(base64_encode(urlencode($money.$paymentcode.$y)));
echo $valid_key;
if ($key != $valid_key) {
    // 如果传入的值和验证值不匹配，返回错误信息
    http_response_code(400);
    echo "Invalid parameters!";
    exit;
}


$databasefile = '../../config/database.php';
$database = include($databasefile);
// 创建数据库连接
$servername = $database['host'];
$username =  $database['user'];
$password = $database['password'];
$dbname = $database['name'];
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}
$now=date("YmdHis");
$sql = "INSERT INTO nr_money (money, paymentcode, time, status) VALUES ( '$money', '$paymentcode', '$now', '0')";
$result = $conn->query($sql);
$updatemoney=(float)$y-(float)$money;
if ($result==true) {
    $sql = "UPDATE nr_user SET money = ".(string)$updatemoney." WHERE password='".$_COOKIE['password']."'";
    $result = $conn->query($sql);
    if ($result==true) {
        echo "提现申请成功";
    }else{
        echo "提现申请失败";
    }
}else{
    echo "一片迷茫";
}