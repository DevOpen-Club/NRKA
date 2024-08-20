<?php
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    // cookie 存在，进行跳转
    header("Location: index.php");
    exit(); // 确保脚本终止
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.staticfile.net/layui/2.9.4/css/layui.css" rel="stylesheet">
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
        
        .card-header h2 {
            font-size: 24px;
            font-weight: bold;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .form-group input {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
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
            background-color:#0056b3;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card-header">
            <h2>登录</h2>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">用户名:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">密码:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="登录" class="button">
                </div>
            </form>
        </div>
    </div>
    <script scr="https://cdn.staticfile.net/layui/2.9.4/layui.js"></script>
</body>
</html>

<?php
$databasefile = '../../config/database.php';
$database = include($databasefile);


// 数据库连接信息
$servername = $database['host'];
$databasename = $database['name'];
$databasepassword = $database['password'];;
$dbname = $database['name'];
echo $username;
// 处理登录请求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单提交的用户名和密码
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 创建数据库连接
    $conn = new mysqli($servername, $databasename, $databasepassword, $dbname);

    // 检查连接是否成功
    if ($conn->connect_error) {
        die("数据库连接失败: " . $conn->connect_error);
    }

    // 查询数据库中的用户记录
    $sql = "SELECT name, password FROM nr_user WHERE name = '$username'";
    $result = $conn->query($sql);

    // 验证用户名和密码
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row["password"] == $password) {
            
            // 设置Cookie
            setcookie("username", $username, time() + (3600), "/");
            setcookie("password", $password, time() + (3600), "/");
            
            // 跳转到/index.php页面
            header("Location: index.php");
            exit();
        } else {
            echo "密码错误";
        }
    } else {
        echo "用户名不存在";
    }

    $conn->close();
}
?>
