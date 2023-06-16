<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/website/classes/User.php";

class Company extends User
{
    /*user_id?*/
    private $company_id;
    public $name;
    public $slogan;
    public $description;
    public $address_id;

    public function __construct($name, $address_id, $slogan=null, $description=null, $user_id = null, $email = null, $passwordnothashed = null)
    {
        $this->name = $name;
        $this->address_id = $address_id;
        $this->slogan = $slogan;
        $this->description = $description;
        parent::__construct($email, $passwordnothashed, $user_id);
    }

    public function insertCompany()
    {
        $stmt = $this->pdo->prepare("insert into Company (name, address_id, user_id, slogan, description) values (?,?,?,?,?)");
        $stmt->bindParam(1, $this->name, PDO::PARAM_STR);
        $stmt->bindParam(2, $this->address_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(4, $this->slogan, PDO::PARAM_STR);
        $stmt->bindParam(5, $this->description, PDO::PARAM_STR);

        $stmt->execute();
    }

    public static function getAllCompanyNames(){
        $db = new DB();
        $stmt = $db->pdo->prepare('select name from Company');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN,0);
    }
}

