
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>遊戲任務系統</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #1a1a2e;
        color: #eaeaea;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .game-title {
        font-size: 32px;
        font-weight: bold;
        color: #00ffcc;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px #000;
    }
    .btn-game {
        background-color: #00ffcc;
        border: none;
        color: #1a1a2e;
    }
    .btn-game:hover {
        background-color: #00ccaa;
    }
    .card {
        background-color: #16213e;
        border: 1px solid #00ffcc;
    }
    a { color: #00ffcc; }
</style>

</head>
<body class="d-flex flex-column align-items-center">
<div class="container mt-4">
<div class="game-title text-center">🎮 遊戲任務系統</div>

<?php
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];  // 接收用戶選擇的身分
    
    // 確保 role 只能是 player 或 admin
    if ($role !== 'player' && $role !== 'admin') {
        echo "<div class='alert alert-danger'>身分錯誤，請重新選擇</div>";
        exit;
    }

    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>註冊成功，請<a href='login.php'>登入</a></div>";
    } else {
        echo "<div class='alert alert-danger'>錯誤: " . mysqli_error($conn) . "</div>";
    }
}
?>
<form method="POST" class="p-4 card">
    <input name="username" class="form-control mb-2" placeholder="帳號" required>
    <input type="password" name="password" class="form-control mb-3" placeholder="密碼" required>

    <!-- 身分選擇 -->
    <select name="role" class="form-control mb-3">
        <option value="player">玩家</option>
        <option value="admin">管理者</option>
    </select><br>

    <input type="submit" value="註冊" class="btn btn-game w-100">
</form>



</div></body></html>
