<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 22.03.2018
 * Time: 18:17
 */
class User
{
    public $email;
    public $password;
    public $password2;
    public $users;
    public $errors = array();

    public function checkEmail()
    {
        $conn = Db::connect();
        $sql = 'SELECT * FROM users WHERE e_mail = :email';
        $result = $conn->prepare($sql);
        $result->bindParam(':email', $this->email, PDO::PARAM_STR);
        $result->execute();
        if ($result->fetchColumn()) {
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
        if (!preg_match('/[A-z0-9]{5,30}$/', $password)) {
            $this->errors[] = "Paswords not equal";
        }
        $this->password = md5($password);

        if ($this->checkEmail()) {
            $this->errors[] = "email olredy exists";
        }
        if (!$this->errors) {
            $conn = Db::connect();
            $sql = "INSERT INTO users(e_mail, password)
    VALUES (:email,:pass)";
            // use exec() because no results are returned
            $res = $conn->prepare($sql);
            $res->bindParam(':email', $this->email, PDO::PARAM_STR);
            $res->bindParam(':pass', $this->password, PDO::PARAM_STR);

            $res->execute();

            $_SESSION['user'] = $this->email;
            echo "<br> succsess register<br>";

        } else {
            echo $this->errors[0];
        }
    }

    public function login($email, $password)
    {
        $this->email = $email;
        $this->password = md5($password);
        $conn = Db::connect();
        $sql = 'SELECT * FROM users WHERE e_mail = :email AND password=:pass';
        $result = $conn->prepare($sql);
        $result->bindParam(':email', $this->email, PDO::PARAM_STR);
        $result->bindParam(':pass', $this->password, PDO::PARAM_STR);
        //$result->setFetchMode(PDO::FETCH_ASSOC);
        $result->execute();
        //var_dump($res);
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if ($user != null) {
            echo "<br> Hello user with id ".$user['id']."<br>";
            echo "<br>Your last wisit is" . $user['last_visit'];
            $_SESSION['id']=$user['id'];


            return true;
            return false;


        }
        if (!$user) {
            echo $this->errors[] = "logim or pass invalid";
            return $this->errors[0];
        }

        

    }

    public function updatelastVisit($id)
    {

        $conn = Db::connect();
        $sql = "UPDATE  users SET last_visit= :last_visit WHERE id=:id";
        $result = $conn->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':last_visit', date("y-m-d H:i:s"), PDO::PARAM_INT);
        
        return $result->execute();
    }

    public function logout($id){

        $this->updatelastVisit($id);

       session_destroy();

    }

}