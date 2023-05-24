<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/source/shared/classes/User.php";

class Company extends User
{
    /*user_id?*/
    private $company_id;
    public $name;
    public $slogan;
    public $description;
    public $street_id;

    public function __construct($name, $street_id, $slogan=null, $description=null)
    {
        $this->name = $name;
        $this->street_id = $street_id;
        $this->slogan = $slogan;
        $this->description = $description;
        parent::__construct(null, null);
    }

    public static function insertCompany($name, $address_id, $user_id, $slogan=null, $description=null)
    {
        $company = new Company($name, $address_id, $slogan, $description);
        $company->user_id = $user_id;
        $stmt = $company->pdo->prepare("insert into company (name, address_id, user_id, slogan, description) values (?,?,?,?,?)");
        $stmt->bindParam(1, $name, PDO::PARAM_STR);
        $stmt->bindParam(2, $address_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(4, $slogan, PDO::PARAM_STR);
        $stmt->bindParam(5, $description, PDO::PARAM_STR);

        if($stmt->execute())
        {
            return $company;
        }
        else
        {
            return null;
        }
    }
}

