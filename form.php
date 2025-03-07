<html>
<head></head>
<body>
<form action="info.php"method="POST">    
input your name <input type="text" name="uName"value="English only"><br>
input your password <input type="password" name="upassword"><br>
input u r email: <input type="email" name ="uemail"><br>
select ur color <input type="color" name = "ucolor"><br>
ur age <input type="number" name= "uage" min="25"max="60"><br>
select u r birthday <input type="date"name ="ubirth"><br>
<input type="sumbit"><input type="reset">
</form>
</body>



<?php


$uName=$_POST["uName"]
$uName=$_POST["upassword"]
$uName=$_POST["uemail"]
$uName=$_POST["ucolor"]
$uName=$_POST["uage"]
$uName=$_POST["ubirth"]


echo "Your name is:".$uName;
echo "Your passeord is:".$upassword;
echo "Your mail  is:".$uemail;
echo "Your color is:".$ucolor;
echo "Your age is:".$uage;
echo "Your birth is:".$ubirth;
?> 

</html>
