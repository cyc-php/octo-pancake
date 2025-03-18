<?php
session_start();
?>

<html>
<head></head>
<body>
<?php
if(isset($_SESSION["user"])){
    echo "Welcome!<br>";
    echo "<a href='1.php'>Logout</a>";

    echo "<form action='3.php' method='GET'>";
    echo "Please input your name:<input type='text' name='uName'><br>";
    echo "Please input your password:<input type='password' name='uPwd'><br>";
    echo "Please input your email:<input type='email' name='uEmail'><br>";
    echo "Please select your color: <input type='color' name='uColor'><br>";
    echo "Please select your age: <input type='number' name='uAge' min='25' max='60'><br>";
    echo "Please select your birthday: <input type='date' name='uBirth'><br>";
    echo "Please select how you like the webpage: <input type='range' name='uLike'><br>";
    echo "<input type='hidden' name='uSecret' value='?????'>";
    echo "Please select your city:";
    echo "<select name='uCity'>";
    echo "<option value='taipei'>Taipei</option>";
    echo "<option value='taichung'>Taichung</option>";
    echo "<option value='kaohsiung'>Kaohsiung</option>";
    echo "</select>";
    echo "<br><input type='submit'><input type='reset'>";
    echo "</form>";
}else{
    echo "illegal user!";
    header("Refresh:2;url='6.php'");
}
?>
</body>
</html>