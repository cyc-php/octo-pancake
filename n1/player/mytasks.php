<?php
include '../config.php';
include '../functions.php';
checkLogin();
$user_id = $_SESSION['user_id'];

if (isset($_GET['claim_id'])) {
    $task_id = intval($_GET['claim_id']);
    
    // 檢查是否可以領取獎勵
    $check = $conn->prepare("SELECT * FROM user_tasks WHERE user_id=? AND task_id=? AND status='completed' AND reward_claimed='no'");
    $check->bind_param("ii", $user_id, $task_id);
    $check->execute();
    $result_check = $check->get_result();

    if ($result_check->num_rows > 0) {
        $reward_stmt = $conn->prepare("SELECT * FROM rewards WHERE task_id=?");
        $reward_stmt->bind_param("i", $task_id);
        $reward_stmt->execute();
        $reward_result = $reward_stmt->get_result();

        if ($r = $reward_result->fetch_assoc()) {
            $update = $conn->prepare("UPDATE user_tasks SET reward_claimed='yes' WHERE user_id=? AND task_id=?");
            $update->bind_param("ii", $user_id, $task_id);
            $update->execute();

            $_SESSION['message'] = "🎉 已領取獎勵！獲得 {$r['exp']} 經驗、{$r['coins']} 金幣、{$r['item_name']} 道具";
            header("Location: mytasks.php");
            exit;
        }
    } else {
        echo "<div class='alert alert-warning mt-3'>❗ 無可領取的獎勵</div>";
    }
}

// 只撈出尚未領取獎勵的任務
$result = $conn->prepare("SELECT * FROM user_tasks WHERE user_id=? AND reward_claimed='no'");
$result->bind_param("i", $user_id);
$result->execute();
$tasks = $result->get_result();
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>我的任務</title>
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

    <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-success mt-3">
            <?= $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <h2 class="text-center mb-4">🎯 我的任務</h2>
    <div class="card p-4 mb-4">
        <ul class="list-group">
        <?php while ($row = mysqli_fetch_assoc($tasks)): ?>
            <li class="list-group-item bg-dark text-light d-flex justify-content-between align-items-center">
                <span>📋 任務ID: <?= $row['task_id'] ?> - 狀態: <?= $row['status'] ?></span>
                <span>
                <?php if ($row['status'] == 'completed' && $row['reward_claimed'] == 'no'): ?>
                    <a href="?claim_id=<?= $row['task_id'] ?>" class="btn btn-game btn-sm">領取獎勵</a>
                <?php elseif ($row['status'] == 'in_progress'): ?>
                    <span class="badge bg-info">⏳ 進行中</span>
                <?php endif; ?>
                </span>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>
    <div class="text-center">
        <a href="board.php" class="btn btn-outline-light">← 回任務看板</a>
        <a href="history.php" class="btn btn-outline-light">📜 查看歷史紀錄</a>
    </div>
</div>
</body>
</html>


