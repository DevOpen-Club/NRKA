<?php
if($_POST){
    $data=$_POST;
}else{
    $data=$_GET;
}
ksort($data); //排序post参数
reset($data); //内部指针指向数组中的第一个元素
$zzcode_key = "cf7addb128b8da2bccfb8bfc336d3435"; //这是您的密钥
$sign = '';//初始化
foreach ($data AS $key => $val) { //遍历POST参数
    if ($val == '' || $key == 'sign' || $key == "sign_type" ) continue; //跳过这些不参数签名
    if ($sign) $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
    $sign .= "$key=$val"; //拼接为url参数形式
}
if (md5($sign.$zzcode_key) != $data['sign']) { //不合法的数据
    exit('fail');  //验证失败
} else { //合法的数据
    //业务处理
    $out_trade_no = $data['out_trade_no']; //商户订单号
    $trade_no = $data['trade_no']; //订单号
    $databasefile = '../config/database.php';
    $database = include($databasefile);

    $host = $database['host'];
    $user = $database['user'];
    $name = $database['name'];
    $password = $database['password'];
    $conn = new mysqli($host, $user, $password, $name);
    if ($conn->connect_error) {
        die("连接数据库失败: " . $conn->connect_error);
    }
    $sql = "UPDATE `nr_order` SET status = 1 WHERE order_number=$out_trade_no";

    if (mysqli_query($conn, $sql)) {
        
    } else {
        echo "数据更新失败：" . mysqli_error($conn);
    }
    $sql = "SELECT * FROM `nr_order` WHERE order_number = $out_trade_no";
    if (mysqli_query($conn, $sql)) {
        $result=mysqli_query($conn, $sql);
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $order_number=$row['order_number'];
            $price=$row['price'];
            $commodity=$row['commodity_id'];
            $sql = "SELECT * FROM `nr_commodity` WHERE id = $commodity";
            if (mysqli_query($conn, $sql)) {
                $result=mysqli_query($conn, $sql);
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $user=$row['user'];
                    $ka=$row['ka'];
                    $sql = "SELECT * FROM `nr_user` WHERE name = '$user'";
                    if (mysqli_query($conn, $sql)) {
                        $result=mysqli_query($conn, $sql);
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['id'];
                            $money=$row['money'];
                            $money = (float)$money + (float)$price;
                            $sql = "UPDATE `nr_user` SET money = ".$money." WHERE name='$user'";
                            if (mysqli_query($conn, $sql)) {
                                $sql = "UPDATE `nr_order` SET ka = '$ka' WHERE commodity_id=$commodity";
                                if (mysqli_query($conn, $sql)) {
                                    $sql = "UPDATE `nr_commodity` SET status = 2 WHERE commodity_id=$commodity";
                                    if (mysqli_query($conn, $sql)) {
                                        
                                    } else {
                                        echo "获取失败" . mysqli_error($conn);
                                    }
                                } else {
                                    echo "获取失败" . mysqli_error($conn);
                                }
                            } else {
                                echo "获取失败" . mysqli_error($conn);
                            }
                        }
                    } else {
                        echo "获取失败" . mysqli_error($conn);
                    }
                }
            } else {
                echo "获取失败" . mysqli_error($conn);
            }
            // echo "broadcast: " . $broadcast . "<br>";
            // echo "sitename: " . $sitename . "<br>";
        }
    } else {
        echo "获取失败" . mysqli_error($conn);
    }
    $conn->close();

    $money = (float)$data['money']; //付款金额
    
    $out_trade_no = $data['out_trade_no']; //商户订单号
    exit('success'); //返回成功
}
?>