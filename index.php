<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 22.03.2018
 * Time: 18:18
 */
session_start();
include_once "model/Db.php";
include_once "model/User.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<h2>regiser</h2>
<form action="#" method="post" id="register">
    <div>Email<input type="email" name="email" ></div>
    <div>Pass:<input type="password" name="password">
    <div>Pass2<input type="password" name="password"></div>
    <input type="submit" name="submit" id="submit">
</form>


<h2>Login</h2>
<form action="#" method="post" id="register">
    <div>Email<input type="email" name="email" ></div>
    <div>Pass:<input type="password" name="password">

    <input type="submit" name="submit" id="submit">
</form>


</body>
</html>
