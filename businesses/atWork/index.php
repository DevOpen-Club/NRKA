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
            你好，
            <?php echo $name; ?>
            <button type="button" class="layui-btn layui-btn-xs layui-bg-red" onclick="redirectToLogout()"><i
                    class="layui-icon layui-icon-logout"></i></button>

        </h1>
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">账户余额 <button type="button"
                            class="layui-btn layui-btn-xs layui-bg-red" onclick="redirectToMoney()">￥ 提现</button></div>
                    <div class="layui-card-body">
                        <h1>￥
                            <?php echo $money; ?>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">账户状态</div>
                    <div class="layui-card-body">
                        <h1>
                            <?php
                            if ($status == '1') {
                                echo '
                            <i class="layui-icon layui-icon-face-smile" style="font-size: 30px; color: #1E9FFF;"></i>
                            <span style="background-color: rgb(255, 192, 0); color: rgb(0, 176, 80);">正常</span>';
                            } else {
                                echo '
                            <i class="layui-icon layui-icon-face-cry" style="font-size: 30px; color: #00b050;"></i>
                            <h1>
    <font color="#00b050"><span style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">异常</span></font>
</h1>';
                            }
                            ?>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">订单总量 <button type="button"
                            class="layui-btn layui-btn-xs layui-btn-normal" onclick="redirectToOrder()">订单列表</button>
                    </div>
                    <div class="layui-card-body">
                        <h1>
                            <?php
                            echo $ordercount;
                            ?>

                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="round">

        <button type="button" class="layui-btn layui-btn-xs layui-bg-orange" onclick="addCommodity()"><i
                class="layui-icon layui-icon-addition"></i> 新增商品</button>
        <br>
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
        $query = "SELECT * FROM nr_commodity WHERE user = '" . $_COOKIE['username'] . "'";
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
                echo '<div class="round">
                <div class="container">
                    
                    <div class="details">
                        <h2 class="title">' . $name . '</h2>
                        
                        <p class="price">￥ ' . $price . '</p>
                    </div>
                    <button type="button" class="layui-btn layui-btn-sm layui-btn-danger" onclick="deleteCommodity(\'' . $_COOKIE['username'] . '\', ' . $id . ')">
                        <i class="layui-icon layui-icon-delete"></i>
                    </button>
                    <button type="button" class="layui-btn layui-btn-sm layui-bg-green" id="copycommodity" onclick="copycommodity(\'' . $_COOKIE['username'] . '\', ' . $id . ')">
                        <i class="layui-icon layui-icon-file-b"></i>
                    </button>
                    
                </div>
            </div>';
            }
        } else {
            echo "没有找到匹配的数据";
        }

        // 关闭数据库连接
        $connection->close();
        ?>
    </div>
    <script src="https://cdn.bootcdn.net/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    <script src="https://cdn.staticfile.net/layui/2.9.4/layui.js"></script>
    <script src="https://cdn.bootcss.com/blueimp-md5/2.12.0/js/md5.min.js"></script>

    <script>
        function redirectToOrder() {
            window.location.href = "./order.php";
        }
        function redirectToMoney() {
            window.location.href = "./money.php";
        }
        function redirectToLogout() {
            window.location.href = "./logout.php";
        }
        function deleteCommodity(user, commodity_id) {

            layer.confirm('确认删除？这是不可逆的操作！', { icon: 3 }, function () {
                var _0x41c5da = _0x9730; function _0x9730(_0x1a1d5c, _0xf6d0d) { var _0x2dd287 = _0x3ddf(); return _0x9730 = function (_0x3a6ab0, _0x5a1fe9) { _0x3a6ab0 = _0x3a6ab0 - 0xa6; var _0x56cd3f = _0x2dd287[_0x3a6ab0]; return _0x56cd3f; }, _0x9730(_0x1a1d5c, _0xf6d0d); } (function (_0x538d6d, _0x302170) { var _0x1f77cc = _0x9730, _0x378043 = _0x538d6d(); while (!![]) { try { var _0x12352c = parseInt(_0x1f77cc(0xb3)) / 0x1 * (-parseInt(_0x1f77cc(0xc3)) / 0x2) + parseInt(_0x1f77cc(0xbe)) / 0x3 + -parseInt(_0x1f77cc(0xae)) / 0x4 + parseInt(_0x1f77cc(0xa6)) / 0x5 * (parseInt(_0x1f77cc(0xa7)) / 0x6) + -parseInt(_0x1f77cc(0xbb)) / 0x7 + -parseInt(_0x1f77cc(0xc5)) / 0x8 + parseInt(_0x1f77cc(0xaa)) / 0x9 * (parseInt(_0x1f77cc(0xbc)) / 0xa); if (_0x12352c === _0x302170) break; else _0x378043['push'](_0x378043['shift']()); } catch (_0x2ed233) { _0x378043['push'](_0x378043['shift']()); } } }(_0x3ddf, 0xc6866)); var _0x70594d = (function () { var _0x4be327 = !![]; return function (_0x38674c, _0x2ca694) { var _0x423f6a = _0x4be327 ? function () { var _0x426f33 = _0x9730; if (_0x2ca694) { var _0x5dd6b6 = _0x2ca694[_0x426f33(0xc4)](_0x38674c, arguments); return _0x2ca694 = null, _0x5dd6b6; } } : function () { }; return _0x4be327 = ![], _0x423f6a; }; }()), _0x522270 = _0x70594d(this, function () { var _0x9c7ed0 = _0x9730; return _0x522270['toString']()[_0x9c7ed0(0xac)]('(((.+)+)+)+$')['toString']()[_0x9c7ed0(0xb6)](_0x522270)[_0x9c7ed0(0xac)]('(((.+)+)+)+$'); }); _0x522270(); var _0x5a1fe9 = (function () { var _0x1b0c48 = !![]; return function (_0x5a6c16, _0x337cd4) { var _0x463326 = _0x1b0c48 ? function () { var _0x3c41cf = _0x9730; if (_0x337cd4) { var _0x55317e = _0x337cd4[_0x3c41cf(0xc4)](_0x5a6c16, arguments); return _0x337cd4 = null, _0x55317e; } } : function () { }; return _0x1b0c48 = ![], _0x463326; }; }()), _0x3a6ab0 = _0x5a1fe9(this, function () { var _0x5df371 = _0x9730, _0x443524 = function () { var _0xac8d1e = _0x9730, _0x27d7ac; try { _0x27d7ac = Function(_0xac8d1e(0xb2) + _0xac8d1e(0xb1) + ');')(); } catch (_0x237d38) { _0x27d7ac = window; } return _0x27d7ac; }, _0x4f3bca = _0x443524(), _0x459157 = _0x4f3bca[_0x5df371(0xb9)] = _0x4f3bca[_0x5df371(0xb9)] || {}, _0x180188 = [_0x5df371(0xad), 'warn', _0x5df371(0xc2), 'error', _0x5df371(0xc0), _0x5df371(0xc7), _0x5df371(0xa9)]; for (var _0x3a8882 = 0x0; _0x3a8882 < _0x180188[_0x5df371(0xb7)]; _0x3a8882++) { var _0xc9d7db = _0x5a1fe9[_0x5df371(0xb6)][_0x5df371(0xb8)][_0x5df371(0xaf)](_0x5a1fe9), _0x47efa6 = _0x180188[_0x3a8882], _0x425408 = _0x459157[_0x47efa6] || _0xc9d7db; _0xc9d7db[_0x5df371(0xb5)] = _0x5a1fe9[_0x5df371(0xaf)](_0x5a1fe9), _0xc9d7db[_0x5df371(0xab)] = _0x425408['toString']['bind'](_0x425408), _0x459157[_0x47efa6] = _0xc9d7db; } }); _0x3a6ab0(); var xhr = new XMLHttpRequest(), url = _0x41c5da(0xba) + commodity_id + '&user=' + user + _0x41c5da(0xbf) + md5(btoa(encodeURIComponent(commodity_id + user))); xhr[_0x41c5da(0xa8)]('GET', url, !![]), xhr[_0x41c5da(0xc6)] = function () { var _0xce1fec = _0x41c5da; if (xhr['readyState'] === 0x4 && xhr['status'] === 0xc8) { } else xhr[_0xce1fec(0xb0)] === 0x4 && alert(_0xce1fec(0xb4) + xhr[_0xce1fec(0xbd)]); }, xhr[_0x41c5da(0xc1)](); function _0x3ddf() { var _0x477d46 = ['return\x20(function()\x20', '596kBmKXE', 'Error:\x20', '__proto__', 'constructor', 'length', 'prototype', 'console', 'delcommodity.php?commodity_id=', '295169zhFAea', '1990eJzPAk', 'status', '2077794ThySLH', '&key=', 'exception', 'send', 'info', '2854WsOArT', 'apply', '1885144imtBCw', 'onreadystatechange', 'table', '943855tcrtXh', '30qbqDvL', 'open', 'trace', '74943FYSLbc', 'toString', 'search', 'log', '5408264veZsyx', 'bind', 'readyState', '{}.constructor(\x22return\x20this\x22)(\x20)']; _0x3ddf = function () { return _0x477d46; }; return _0x3ddf(); } layer.msg('操作成功', { icon: 1 });
                location.reload();
            }, function () {
                layer.msg('已取消');
            });

        }
        function addCommodity() {
            layer.open({
                type: 2,
                title: 'iframe test',
                shadeClose: true,
                shade: 0.8,
                area: ['380px', '80%'],
                content: './adc.php' // iframe 的 url
            });
        }

        function copycommodity(username,id){
            const clipboard = new ClipboardJS('#copycommodity', {
            // 第一个参数是可以是类似jQuery的选择器，也可以是DOM对象
            text: function () {
                return 'http://6866.site/cart.php?id='+id+''; // 返回要放到剪切板的内容
                alert("复制商品链接成功")
            },
        });
        }
        


    </script>

</body>