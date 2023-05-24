<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/source/shared/classes/User.php";

class Company extends User
{
    /*user_id?*/
    private $company_id;
    public $name;
    public $slogan;
    public $description;
    public $address_id;

    public function __construct($name, $address_id, $slogan=null, $description=null)
    {
        $this->name = $name;
        $this->address_id = $address_id;
        $this->slogan = $slogan;
        $this->description = $description;
        parent::__construct(null, null);
    }

    public function insertCompany()
    {
        $stmt = $this->pdo->prepare("insert into company (name, address_id, user_id, slogan, description) values (?,?,?,?,?)");
        $stmt->bindParam(1, $this->name, PDO::PARAM_STR);
        $stmt->bindParam(2, $this->address_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(4, $this->slogan, PDO::PARAM_STR);
        $stmt->bindParam(5, $this->description, PDO::PARAM_STR);

        $stmt->execute();
    }
}

