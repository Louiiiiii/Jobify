<?php
class User extends DB
{
    protected $user_id;
    public $email;
    public $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
        parent::__construct();
    }

    public static function insertuser($email, $password)
    {
        $hashedpw = hash('sha512',$password);
        $user = new User($email,$hashedpw);
        $stmt = $user->pdo->prepare("INSERT INTO jobify.user (email, passwordhash) VALUES (?,?)");
        $stmt->bindParam(1, $user->email, PDO::PARAM_STR);
        $stmt->bindParam(2, $user->password, PDO::PARAM_STR);
        return($stmt->execute()); //True wenn erfolgreich False wenn fehlgeschlagen
    }

    public static function validateCredentials($email,$password)
    {
        $hashedpw = hash('sha512',$password);
        $user = new User($email,$hashedpw);
        $stmt = $user->pdo->prepare("select count(*) from user where email = ? and passwordhash = ?");
        $stmt->bindParam(1, $user->email, PDO::PARAM_STR);
        $stmt->bindParam(2, $user->password, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->fetch()[0] >= 1){
            return true;
        }
        return false;
    }

    public static function doesemailexist($email)
    {
        $pw = null;
        $user = new User($email, $pw);
        $stmt = $user->pdo->prepare("select count(*) AS 'count' from user where email = ?");
        $stmt->bindParam(1, $user->email, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->fetch()[0] >= 1){
            return true;
        }
        return false;
    }
}