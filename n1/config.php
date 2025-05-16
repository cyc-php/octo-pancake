
<?php
$conn = mysqli_connect("localhost", "root", "", "your_project");
if (!$conn) {
    die("資料庫連線失敗: " . mysqli_connect_error());
}
session_start();
?>
