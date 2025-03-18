<?php
session_start();
?>
<h1>Login Result</h1>

<?php

$defaultName="user";
$defalutPwd="123456";

$defaultAdminName="nuk";
$defalutAdminPwd="0000";

$name=$_POST["name"];
$pwd=$_POST["pwd"];

if($defaultName==$name && $defalutPwd==$pwd){
    echo "user login success";
    $_SESSION["user"]=1;
    $cookiedate=strtotime("+10 seconds",time());
    setcookie("name",$name,$cookiedate);
    header("Location:4.php");
}else{
    echo "Login failed, will send you back to login again";
    header("Refresh:3;url='6.php'");
}

if($defaultAdminName==$name && $defalutAdminPwd==$pwd){
    echo "Admin login success";
    $_SESSION["ad"]=1;
    $cookiedate=strtotime("+10 seconds",time());
    setcookie("name",$name,$cookiedate);
    header("Location:2.php");
}else{
    echo "Login failed, will send you back to login again";
    header("Refresh:3;url='6.php'");
}
?>