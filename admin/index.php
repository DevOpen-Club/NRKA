<?php
$filePath = __DIR__ . '/adminer.php';

if (file_exists($filePath)) {
    echo '<h1>未正确配置【Adminer】</h1>';
    echo '<form method="post">';
    echo 'adminer入口名: <input type="text" name="newFilename">';
    echo '<input type="submit" value="保存">';
    echo '</form>';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newFilename = $_POST['newFilename'];
        $newFilePath = __DIR__ . '/' . $newFilename . '.php';

        if (preg_match('/^[a-zA-Z0-9]{6,}$/', $newFilename)) {
            $newFilePath = __DIR__ . '/' . $newFilename . '.php';

            if (rename($filePath, $newFilePath)) {
                echo '成功';
            } else {
                echo '失败';
            }
        } else {
            echo '不符合要求，请输入至少包含 6 个字符，不得包含特殊字符。';
        }

    }
}else{
    echo "Welcome to Nginx!!!";
}