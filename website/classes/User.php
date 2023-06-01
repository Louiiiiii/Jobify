<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/website/classes/DB.php";

class User extends DB
{
    public $user_id;
    public $email;
    public $passwordhash;

    public function __construct($email, $password = null, $user_id = null)
    {
        $this->email = $email;
        $this->passwordhash = hash('sha512',$password);
        $this->user_id = $user_id;
        parent::__construct();
    }

    public static function insertuser($email, $password)
    {
        $user = new User($email,$password);

        $user_id = $user->getUser_id();

        if($user_id == null) {
            $stmt = $user->pdo->prepare("INSERT INTO User (email, passwordhash) VALUES (?,?)");
            $stmt->bindParam(1, $user->email, PDO::PARAM_STR);
            $stmt->bindParam(2, $user->passwordhash, PDO::PARAM_STR);
            $stmt->execute();
            $user_id = $user->getUser_id();
        }
        return $user_id;

    }

	public function getUser_id()
	{
		$stmt = $this->pdo->prepare('select user_id from User where lower(email) = lower(?)');
		$stmt->bindParam(1,$this->email);
		$stmt->execute();
		$result = $stmt->fetch();
		if($result)
		{
			return $result[0];
		}
		return null;
	}


    public static function validateCredentials($email,$password)
    {
        $user = new User($email,$password);
        $stmt = $user->pdo->prepare("select count(*) from User where email = ? and passwordhash = ?");
        $stmt->bindParam(1, $user->email, PDO::PARAM_STR);
        $stmt->bindParam(2, $user->passwordhash, PDO::PARAM_STR);
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
        $stmt = $user->pdo->prepare("select count(*) AS 'count' from User where email = ?");
        $stmt->bindParam(1, $user->email, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->fetch()[0] >= 1){
            return true;
        }
        return false;
    }
}