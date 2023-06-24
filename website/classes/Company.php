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

    public function updateDB()
    {
        $this->company_id = $this->getCompany_id();
        if ($this->company_id == null) {
            $success = $this->insertCompany();
        }
        elseif ($this->company_id != null)
        {
            $success = $this->updateCompany();
        }
        return $success;
    }

    private function updateCompany()
    {
        $stmt = $this->pdo->prepare('update Company set name = ?, slogan = ?, description = ?, address_id = ? where company_id = ?');
        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->slogan);
        $stmt->bindParam(3, $this->description);
        $stmt->bindParam(4, $this->address_id);
        $stmt->bindParam(5, $this->company_id);
        return $stmt->execute();
    }

    public static function getDatabyId($company_id):Company{
        $db = new DB();
        $stmt = $db->pdo->prepare('select * 
                                           from Company
                                          where company_id = ?');
        $stmt->bindParam(1,$company_id);
        $stmt->execute();
        $res = $stmt->fetch();
        $company = new Company($res['name'],$res['address_id'],$res['slogan'],$res['description'],$res['user_id']);
        $company->company_id = $res['company_id'];
        return $company;
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

    public static function getCompany_Data(){
        $db = new DB();
        $stmt = $db->pdo->prepare('select company_id, name from Company');
        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result != null)
        {
            return $result;
        }
        return null;
    }

    public static function getProfileDataFromCompany($user_id) {
        $db = new DB();
        $stmt = $db->pdo->prepare('
            SELECT 
                c.name,
                c.slogan,
                c.description,
                u.email,
                cou.country,
                s.state,
                p.Postalcode,
                ci.city,
                a.street,
                a.number
            FROM jobify.user u
            LEFT JOIN jobify.company c ON u.user_id = c.user_id 
            LEFT JOIN jobify.address a ON c.address_id = a.address_id
            LEFT JOIN jobify.city_postalcode cp ON a.City_Postalcode_id = cp.City_Postalcode_id
            LEFT JOIN jobify.postalcode p ON cp.postalcode_id = p.postalcode_id
            LEFT JOIN jobify.city ci ON cp.city_id = ci.city_id
            LEFT JOIN jobify.state s ON p.state_id = s.state_id
            LEFT JOIN jobify.country cou ON s.country_id = cou.country_id
            WHERE u.user_id = ?
        ;');        
        $stmt->bindParam(1,$user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result != null)
        {
            return $result;
        }
        return null;
    }
}

