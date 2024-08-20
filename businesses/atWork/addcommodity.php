<?php
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {

} else {
    http_response_code(404);
    exit();
}
// 获取传入的参数和 key
$name = $_POST['name'];
$price = $_POST['price'];
$introduce = $_POST['introduce'];
$key = $_POST['key'];
$ka=$_POST['ka'];
// 重新计算 key 的值
$encoded_url=urlencode($name  . $introduce . $ka);
$encoded_url = str_replace("%2A", "*", $encoded_url);
$valid_key = md5(base64_encode($encoded_url));

echo $name  . $introduce . $ka;
echo '     '.urlencode($name  . $introduce . $ka);
// 比较传入的 key 值和计算出的验证值
if ($key != $valid_key) {
    // 如果传入的 key 与验证值不匹配，返回错误信息
    http_response_code(400);
    echo "Invalid key!";
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

// 检查是否存在指定的commodity_id
$sql = "INSERT INTO nr_commodity (name, introduce, price, image, status, ka, user) VALUES ( '$name', '$introduce', '$price', '4', '1', '$ka', '".$_COOKIE['username']."')";
$result = $conn->query($sql);

if ($result==true) {
    echo "新增成功-1";
    $sql = "SELECT * FROM nr_user WHERE password='".$_COOKIE['password']."'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        echo "查询成功-2";
        
        while ($row = $result->fetch_assoc()) {
            $money = $row['money'];
            if ((float)$money>=0.1){
                echo "余额充足-3";
                $money=(float)$money-0.1;
                $sql = "UPDATE `nr_user` SET money = ".$money." WHERE password='".$_COOKIE['password']."'";
                $result = $conn->query($sql);
                if ($result==true) {
                    echo "商品添加完成！-4";
                }else{
                    echo "商品添加失败。-4";
                }
            }
        }
        
    }else{
        echo "查询失败-2";
    }
    
} else {
    echo "新增失败-1". $conn->error;;
}

// 关闭数据库连接
$conn->close();

?>
