<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 22.03.2018
 * Time: 18:17
 */
class User
{
    private $email;
    private $password;
    public $password2;
    public $users;
    public $errors = array();
    public function checkUser()
    {
        $conn = Db::connect();
        $sql = 'SELECT * FROM users WHERE username = :email';
        $result = $conn->prepare($sql);
        $result->bindParam(':email', $this->email, PDO::PARAM_STR);
        $result->execute();
        if($result->fetchColumn()){
            return true;
            return false;
        }
    }
    public function register($email, $password, $password2)
    {
        $this->email = $email;
        $this->password = $password;
        $this->password2 = $password2;

        if ($password2 != $password) {
            $this->errors[] = "Paswords not equal";
        }
        if($this->checkUser()){
            $this->errors[] ="User olredy exists";
        }
        if (!$this->errors) {
            $conn =Db::connect();
            $sql = "INSERT INTO users(email, password)
    VALUES (:email,:pass)";
            // use exec() because no results are returned
            $res = $conn->prepare($sql);
            $res->bindParam(':email', $this->login, PDO::PARAM_STR);
            $res->bindParam(':pass', $this->password, PDO::PARAM_STR);

            $res->execute();
            //
            $_SESSION['user']=$this->login;
            header("Location: /index");
        }else{
            echo $this->errors[0];
        }
    }

    public function login($email,$password)
    {
        $this->email = $email;
        $this->password = $password;
        $conn =Db::connect();
        $sql = 'SELECT * FROM users WHERE email = email AND password=:pass';
        $result = $conn->prepare($sql);
        $result->bindParam(':email', $this->email, PDO::PARAM_STR);
        $result->bindParam(':pass', $this->password, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        $user = $result->fetch();
        // var_dump($user);
        if($user!=null){
            $_SESSION['user']=$this->email;
            $_SESSION['user_id']=$user['id'];
            // var_dump($_SESSION);
            header("Location: /dashboard");
            return true;
            return false;
        }
        if(!$user){
            echo $this->errors[]="logim or pass invalid";
            return $this->errors[0];
        }
    }

    public function logout(){
        session_destroy();
        header('Location:index');
    }


}