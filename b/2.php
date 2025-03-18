<?php
session_start();
?>

<html>
<head></head>
<body>
<?php
if(isset($_SESSION["ad"])){
    echo "Welcome! admin<br>";
    echo "<a href='1.php'>Logout</a>";

    
}
?>
</body>
</html>