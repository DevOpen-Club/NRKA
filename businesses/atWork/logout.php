<?php
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
    // 将 cookie 的过期时间设置为一个过去的时间
    setcookie('username', '', time() - 3600, '/');
    // 将 cookie 的过期时间设置为一个过去的时间
    setcookie('password', '', time() - 3600, '/');
    header("Location: ../../index.php");
} else {
    http_response_code(404);
    exit();
}

?>