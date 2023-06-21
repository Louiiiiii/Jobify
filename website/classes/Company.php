<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/website/classes/User.php";

class Company extends User
{
    /*user_id?*/
    public $company_id;
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

    public static function getCompanyByUserId($user_id){
        $db = new DB;
        $stmt = $db->pdo->prepare('select * from Company where user_id = ?');
        $stmt->bindParam(1,$user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_BOTH);
        $company = new Company($result['name'],$result['address_id'],$result['slogan'],$result['description'],$result['user_id']);
        $company->getCompany_id();
        return $company;
    }

    public function getCompany_id(){
        $stmt = $this->pdo->prepare('select company_id id from Company where user_id = ?');
        $stmt->bindParam(1,$this->user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result != null) {
            $this->company_id = $result[0];
            return $result[0];
        }
        return null;
    }
}

