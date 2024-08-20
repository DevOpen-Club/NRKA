<?php
if ($_POST) {
  $data = $_POST;
} else {
  $data = $_GET;
}
$out_trade_no = $data['out_trade_no'];
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
$sql = "SELECT * FROM `nr_order` WHERE order_number=$out_trade_no";

if (mysqli_query($conn, $sql)) {
  $result = mysqli_query($conn, $sql);
  while ($row = $result->fetch_assoc()) {
    $ka = $row['ka'];
  }
} else {
  echo "数据更新失败：" . mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background-image: url(background.jpg);
      background-size: cover;
      font-family: Arial, sans-serif;
    }

    .card-container {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 300px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .card-header {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      background-color: #007bff;
      color: #fff;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .card-header img {
      width: 50px;
      height: 50px;
      margin-right: 10px;
    }

    .card-header h2 {
      font-size: 24px;
      font-weight: bold;
    }

    .card-body {
      padding: 20px;

    }

    .message {
      font-size: 18px;
      margin-bottom: 20px;
    }

    .button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <div class="card-container">
    <div class="card-header">
      <img src="/CSS/img/check.svg" alt="成功图标">
      <h2>支付成功</h2>
    </div>
    <div class="card-body">
      <p class="message">以下是您的订单信息，请务必妥善保管：</p>
      <p><strong>订单号：
          <?php echo $out_trade_no; ?><strong></p>
      <h3>兑换码：
        <?php echo $ka; ?>
      </h3>
      <p>若商品有问题请即时在24h内联系平台！</p>
      <a class="button" href="/">返回首页</a>
    </div>
  </div>
</body>

</html>