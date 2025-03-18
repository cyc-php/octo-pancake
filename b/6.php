<?php

if(isset($_COOKIE["name"])){
    echo "Welcome back, ".$_COOKIE["name"];
}

?>



<h1>Please Login to use the system</h1>
<form action="5.php" method="post">
Please input your username: <input type="text" name="name"><br>
Please input your password: <input type="password" name="pwd"><br>
<input type="submit"><br>

<?php
date_default_timezone_set("Asia/Taipei");
echo time();
echo "<br>";
echo "Time now:";
echo date("Y-m-d H:i:s");
//header("Refresh:1");
?>

</form>