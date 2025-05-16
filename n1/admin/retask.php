<?php
include '../config.php';
include '../functions.php';
checkLogin();
if (!isAdmin()) exit("無權限");

// 建立任務
if (isset($_POST['create_task'])) {
    $stmt = $conn->prepare("INSERT INTO tasks (title, description, reward, deadline) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $_POST['title'], $_POST['desc'], $_POST['reward'], $_POST['deadline']);
    $stmt->execute();
    $task_id = $stmt->insert_id;

    $stmt = $conn->prepare("INSERT INTO rewards (task_id, exp, coins, item_name) VALUES (?, 0, 0, '')");
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    echo "<div class='alert alert-success'>任務建立成功！</div>";
}

// 設定獎勵
 if (isset($_POST['set_reward'])) {


    {
       $stmt = $conn->prepare("UPDATE rewards SET exp=?, coins=?, item_name=? WHERE task_id=?");
        $stmt->bind_param("iisi", $_POST['exp'], $_POST['coins'], $_POST['item_name'], $_POST['task_id']);
        $stmt->execute();
        echo "<div class='alert alert-success'>獎勵已更新</div>";
    }
}

// 編輯任務
if (isset($_POST['edit_task'])) {
    $stmt = $conn->prepare("UPDATE tasks SET title=?, description=?, reward=?, deadline=? WHERE id=?");
    $stmt->bind_param("ssssi", $_POST['edit_title'], $_POST['edit_desc'], $_POST['edit_reward'], $_POST['edit_deadline'], $_POST['edit_id']);
    $stmt->execute();
    echo "<div class='alert alert-success'>任務已更新</div>";
}

// 刪除任務
if (isset($_POST['delete_task'])) {
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id=?");
    $stmt->bind_param("i", $_POST['delete_id']);
    $stmt->execute();
    echo "<div class='alert alert-warning'>任務已刪除</div>";
}

$tasks = $conn->query("SELECT * FROM tasks");
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>任務與獎勵管理</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1a1a2e; color: #eaeaea; font-family: 'Segoe UI'; }
        .game-title { font-size: 32px; font-weight: bold; color: #00ffcc; margin-bottom: 20px; text-shadow: 2px 2px 4px #000; }
        .btn-game { background-color: #00ffcc; border: none; color: #1a1a2e; }
        .btn-game:hover { background-color: #00ccaa; }
        .card { background-color: #16213e; border: 1px solid #00ffcc; }
        a { color: #00ffcc; }
    </style>
</head>
<body class="d-flex flex-column align-items-center">
<div class="container mt-4">
    <div class="game-title text-center">🎮 任務與獎勵管理</div>

    <h2>📝 新增任務</h2>
    <form method="POST" class="p-4 card mb-4">
        <input name="title" class="form-control mb-2" placeholder="標題" required>
        <input name="desc" class="form-control mb-2" placeholder="描述" required>
        <input name="reward" class="form-control mb-2" placeholder="獎勵簡述" required>
        <input type="date" name="deadline" class="form-control mb-3" required>
        <input type="submit" name="create_task" value="建立任務" class="btn btn-game w-100">
    </form>

    <h2>🎁 設定獎勵</h2>
    <form method="POST" class="p-4 card mb-4">
        <select name="task_id" class="form-control mb-2" required>
            <option value="">選擇任務</option>
            <?php
            $task_options = $conn->query("SELECT id, title FROM tasks");
            while ($task = $task_options->fetch_assoc()) {
                echo "<option value='{$task['id']}'>{$task['title']}</option>";
            }
            ?>
        </select>
        <input name="exp" class="form-control mb-2" placeholder="經驗值" required>
        <input name="coins" class="form-control mb-2" placeholder="金幣數量" required>
        <input name="item_name" class="form-control mb-3" placeholder="道具名稱 (含副檔名)" required>
        <input type="submit" name="set_reward" value="設定獎勵" class="btn btn-game w-100">
    </form>

    <h2>📋 任務列表</h2>
    <ul class="list-group mb-4">
    <?php
    $tasks->data_seek(0);
    while ($row = $tasks->fetch_assoc()):
        $stmt = $conn->prepare("SELECT * FROM rewards WHERE task_id=?");
        $stmt->bind_param("i", $row['id']);
        $stmt->execute();
        $reward = $stmt->get_result()->fetch_assoc();
    ?>
        <li class="list-group-item bg-dark text-light">
            <form method="POST" class="mb-2">
                📝 <input name="edit_title" value="<?= htmlspecialchars($row['title']) ?>" required>
                <input name="edit_desc" value="<?= htmlspecialchars($row['description']) ?>" required>
                🎁 <input name="edit_reward" value="<?= htmlspecialchars($row['reward']) ?>" required>
                ⏰ <input type="date" name="edit_deadline" value="<?= $row['deadline'] ?>" required>
                <input type="hidden" name="edit_id" value="<?= $row['id'] ?>">
                <button name="edit_task" class="btn btn-sm btn-game">修改</button>
                <button name="delete_task" value="1" class="btn btn-sm btn-danger" onclick="return confirm('確認刪除任務？');">刪除</button>
                <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
            </form>
            ➕ <b>EXP:</b> <?= $reward['exp'] ?> | 💰 <b>金幣:</b> <?= $reward['coins'] ?> | 🧩 <b>道具:</b> <?= htmlspecialchars($reward['item_name']) ?>
        </li>
    <?php endwhile; ?>
    </ul>

    <a href="dashboard.php" class="btn btn-link mt-4">回主控版</a>
</div>
</body>
</html>

