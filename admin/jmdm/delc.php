// if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {

// } else {
//     http_response_code(404);
//     exit();
// }
// ?>
// <?php
// // 获取传入的参数
// $commodity_id = $_GET['commodity_id'];
// $user = $_GET['user'];
// $key = $_GET['key'];

// // 拼接并加密验证值
// $valid_key = md5(base64_encode(urlencode($commodity_id . $user)));
// if ($key != $valid_key) {
//     // 如果传入的值和验证值不匹配，返回错误信息
//     http_response_code(400);
//     echo "Invalid parameters!";
//     exit;
// }
// $databasefile = '../../config/database.php';
// $database = include($databasefile);
// // 创建数据库连接
// $servername = $database['host'];
// $username =  $database['user'];
// $password = $database['password'];
// $dbname = $database['name'];
// $conn = new mysqli($servername, $username, $password, $dbname);

// // 检查连接是否成功
// if ($conn->connect_error) {
//     die("数据库连接失败: " . $conn->connect_error);
// }

// // 检查是否存在指定的commodity_id
// $sql = "SELECT * FROM nr_commodity WHERE id = $commodity_id";
// $result = $conn->query($sql);

// if ($result && $result->num_rows > 0) {
//     // 删除对应的行
//     $delete_sql = "DELETE FROM nr_commodity WHERE id = $commodity_id";
//     if ($conn->query($delete_sql) === TRUE) {
//         // echo "Commodity deleted successfully!";
//     } else {
//         echo "Error deleting commodity: " . $conn->error;
//     }
// } else {
//     echo "Commodity not found!";
// }

// // 关闭数据库连接
// $conn->close();
