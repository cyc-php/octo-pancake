<?php
// db.php - 資料庫連線設定
$host = 'localhost';
$dbname = 'mission_system';
$user = 'root';     // 建議上線前改為非 root 並加強密碼
$pass = '';         // 改為你自己設定的密碼

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("資料庫連線失敗: " . $e->getMessage());
}
?>
