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
//var_dump($_SESSION);


    $user = new User();
if(isset($_POST['submit'])){
    
    $user->register($_POST['email'],$_POST['password'] ,$_POST['password2'] );
}else if(isset($_POST['submit2'])){

    $user->login($_POST['email'],$_POST['password']);
    $i=0;
    $i = $_SESSION['er'];

    if($user->errors){
        $i++;
        $_SESSION['er']=$i;
        
        if($_SESSION['er']>=2){
            echo "Try again after 2 minutes";
            
            sleep(18);
            echo "<br>";
            echo "ready";
            session_destroy();

        }
    }

}else if(isset($_POST['logaut'])){
   
    if(isset($_SESSION['id'])){
        $user->logout($_SESSION['id']);
    }



}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register-Login</title>
    <style>
        .container{
            width: 80%;
            margin: 0 auto;
            text-align: center;
           
        }
    </style>
</head>
<body>
<div class="container">
<h2>Regiser</h2>
<?php

echo $errors;?>
<form action="index.php" method="post" id="register">
    <div>
        <p><label for="">Email:</label></p>
       <p> <input type="email" name="email" ></p>
    </div>
    <div>
        <p><label for="">Pass:</label></p>
        <p><input type="password" name="password"></p>
    <div><p><label for="">Pass2</label></p>
        <p><input type="password" name="password2"></p>
    </div>
    <div><p><input type="submit" name="submit" value="register" id="submit"></p></div>
</form>


<h2>Login</h2>
<form action="#" method="post" id="login">
    <div><p><label for="">Email:</label></p>
        <p><input type="email" name="email" ></p></div>
    <div><p><label for="">Pass:</label></p>
        <p><input type="password" name="password"></p>
        <div></div><input type="submit" name="logaut" id="logaut" value="logout"></div>
    <div><p><input type="submit" name="submit2" value="login" id="login"></p></div>
</form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="scripts.js"></script>
</body>
</html>
