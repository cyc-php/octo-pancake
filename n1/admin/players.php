<?php
include '../config.php';
include '../functions.php';
checkLogin();
if ($_SESSION['role'] !== 'admin') exit;

// 安全刪除使用者
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: retask.php");
    exit;
}

// 取得使用者及其獎勵統計資料
$query = "
    SELECT 
        u.id, u.username, u.role,
        COALESCE(SUM(r.exp), 0) AS total_exp,
        COALESCE(SUM(r.coins), 0) AS total_coins
    FROM users u
    LEFT JOIN user_tasks ut ON u.id = ut.user_id AND ut.reward_claimed = 'yes'
    LEFT JOIN rewards r ON ut.task_id = r.task_id
    GROUP BY u.id
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>使用者管理</title>
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
    <div class="game-title text-center">👥 使用者管理</div>

    <table class="table table-dark table-bordered table-hover text-center align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>帳號</th>
                <th>身份</th>
                <th>總經驗值</th>
                <th>總金幣</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= $row['role'] ?></td>
                <td>🌟 <?= $row['total_exp'] ?></td>
                <td>💰 <?= $row['total_coins'] ?></td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('確定要刪除？')" class="btn btn-sm btn-danger">刪除</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-link mt-4">⬅️ 返回主控版</a>
</div>
</body>
</html>
