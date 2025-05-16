<?php
include '../config.php';
include '../functions.php';
checkLogin();
$result = mysqli_query($conn, "SELECT * FROM tasks");
$user_id = $_SESSION['user_id'];
$reward_result = mysqli_query($conn, "
    SELECT SUM(r.exp) as total_exp, SUM(r.coins) as total_coins, GROUP_CONCAT(r.item_name SEPARATOR ', ') as items
    FROM user_tasks ut
    JOIN rewards r ON ut.task_id = r.task_id
    WHERE ut.user_id = $user_id AND ut.reward_claimed = 'yes'
");
$reward_data = mysqli_fetch_assoc($reward_result);
$total_exp = $reward_data['total_exp'] ?? 0;
$total_coins = $reward_data['total_coins'] ?? 0;
$items = $reward_data['items'] ?? '無';
$stmt = $conn->prepare("
    SELECT * FROM tasks t
    WHERE NOT EXISTS (
        SELECT 1 FROM user_tasks ut
        WHERE ut.task_id = t.id 
        AND ut.user_id = ? 
        AND (ut.status = 'completed' OR ut.reward_claimed = 'yes')
    )
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();



?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>任務看板</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1a1a2e; color: #eaeaea; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .game-title { font-size: 32px; font-weight: bold; color: #00ffcc; margin-bottom: 20px; text-shadow: 2px 2px 4px #000; }
        .btn-game { background-color: #00ffcc; border: none; color: #1a1a2e; }
        .btn-game:hover { background-color: #00ccaa; }
        .card { background-color: #16213e; border: 1px solid #00ffcc; }
        a { color: #00ffcc; }
    </style>
</head>
<body class="d-flex flex-column align-items-center">
<div class="container mt-4">
<div class="game-title text-center">🎮 遊戲任務系統</div>

<h2 class="text-center mb-4">📝 任務看板</h2>
<div class="card p-4 mb-4">
<ul class="list-group">
<?php while ($row = mysqli_fetch_assoc($result)): ?>
    <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
        <span>🎯 <?= $row['title'] ?></span>
        <a href="task_detail.php?id=<?= $row['id'] ?>" class="btn btn-game btn-sm">查看</a>
    </li>
<?php endwhile; ?>
</ul>
</div>
<div class="text-center">
    <a href="mytasks.php" class="btn btn-outline-light">🎯 前往我的任務（領取獎勵）</a>
    <a href="../logout.php" class="btn btn-link ms-3">登出</a>
</div>
</div>
<div class="position-absolute top-0 end-0 p-3 text-end">
    <div>🌟 經驗：<?= $total_exp ?></div>
    <div>💰 金幣：<?= $total_coins ?></div>
    <div>🎁 道具：<?= $items ?></div>
</div>

</body>
</html>

