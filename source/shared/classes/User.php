<?php
require_once "DB.php";
class User
{
    public $email;
    public $password;
    public $db;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->db = new DB();
    }

    public static function insertuser($email, $password)
    {
        $hashedpw = hash('sha512',$password);
        $user = new User($email,$hashedpw);
        $stmt = $user->db->pdo->prepare("INSERT INTO jobify.user (email, passwordhash) VALUES (?,?)");
        $stmt->bindParam(1, $user->email, PDO::PARAM_STR);
        $stmt->bindParam(2, $user->password, PDO::PARAM_STR);
        return($stmt->execute()); //True wenn erfolgreich False wenn fehlgeschlagen
    }

    public static function validateCredentials($email,$password)
    {
        $hashedpw = hash('sha512',$password);
        $user = new User($email,$hashedpw);
        $stmt = $user->db->pdo->prepare("select count (*) from user where email = ? and passwordhash = ?");
        $stmt->bindParam(1, $user->email, PDO::PARAM_STR);
        $stmt->bindParam(2, $user->password, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->fetch() >= 1){
            return true;
        }
        return false;
    }
}