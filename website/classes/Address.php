<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/website/classes/DB.php";
class Address extends DB
{
    public $address_id;
    public $street;
    public $number;
    public $additionalInfo;
    public $state;
    public $country;
    public $postalcode;
    public $city;

     public function __construct($street,$number,$state,$country,$postalcode,$city,$additionalInfo = null)
     {
         $this->street = $street;
         $this->number = $number;
         $this->additionalInfo = $additionalInfo;
         $this->state = $state;
         $this->country = $country;
         $this->postalcode = $postalcode;
         $this->city = $city;
         parent::__construct();
     }

	 public function addToDB()
	 {
		 $country_id = self::addCountry($this->country);
		 $city_id = self::addCity($this->city);
		 $state_id = self::addState($this->state,$country_id);
		 $postalcode_id = self::addPostalCode($this->postalcode, $state_id);
		 $city_postalcode_id = self::addCity_PostalCode($city_id, $postalcode_id);
		 $this->address_id = self::addAddress($this->street,$this->number,$city_postalcode_id,$this->additionalInfo);
	 }

    private static function addCountry($country)
     {
		 $country_id = self::getCountry_id($country);
         if($country_id == null)
         {
             $db = new DB();
             $stmt = $db->pdo->prepare('insert into Country (country) values (?)');
             $stmt->bindParam(1, $country);
             $stmt->execute();
			 $country_id = self::getCountry_id($country);
         }
		 return $country_id;
     }

	private static function getCountry_id($country){
		$db = new DB();
		$stmt = $db->pdo->prepare('select country_id from Country where lower(country) = lower(?)');
		$stmt->bindParam(1,$country);
		$stmt->execute();
		$result = $stmt->fetch();
		if($result)
		{
			return $result[0];
		}
		return null;
	}

	private static function addCity($city)
	{
		$city_id = self::getCity_id($city);
		if($city_id == null)
		{
			$db = new DB();
			$stmt = $db->pdo->prepare('insert into City (city) values (?)');
			$stmt->bindParam(1, $city);
			$stmt->execute();
			$city_id = self::getCity_id($city);
		}
		return $city_id;
	}

	private static function getCity_id($city)
	{
		$db = new DB();
		$stmt = $db->pdo->prepare('select city_id from City where lower(city) = lower(?)');
		$stmt->bindParam(1,$city);
		$stmt->execute();
		$result = $stmt->fetch();
		if($result)
		{
			return $result[0];
		}
		return null;
	}

    private static function addState($state, $country_id){
		$state_id = self::getState_id($state,$country_id);
        if($state_id == null) {
            $db = new DB();
            $stmt = $db->pdo->prepare('insert into State (state,country_id) values (?,?)');
            $stmt->bindParam(1, $state);
            $stmt->bindParam(2, $country_id, PDO::PARAM_INT);
            $stmt->execute();
			$state_id = self::getState_id($state,$country_id);
        }
		return $state_id;
    }

    private static function getState_id($state, $country_id){
		$db = new DB();
		$stmt = $db->pdo->prepare('select state_id from State where lower(state) = lower(?) and country_id = ?');
		$stmt->bindParam(1,$state);
		$stmt->bindParam(2,$country_id);
		$stmt->execute();
		$result = $stmt->fetch();
		if($result)
		{
			return $result[0];
		}
		return null;
	}

	private static function addPostalCode($postalCode, $state_id){
		$postalCode_id = self::getPostalCode_id($postalCode, $state_id);
		if($postalCode_id == null) {
			$db = new DB();
			$stmt = $db->pdo->prepare('insert into Postalcode (postalcode,state_id) values (?,?)');
			$stmt->bindParam(1, $postalCode);
			$stmt->bindParam(2, $state_id, PDO::PARAM_INT);
			$stmt->execute();
			$postalCode_id = self::getPostalCode_id($postalCode,$state_id);
		}
		return $postalCode_id;
	}

	private static function getPostalCode_id($postalCode, $state_id){
		$db = new DB();
		$stmt = $db->pdo->prepare('select postalcode_id from Postalcode where lower(postalcode) = lower(?) and state_id = ?');
		$stmt->bindParam(1,$postalCode);
		$stmt->bindParam(2,$state_id);
		$stmt->execute();
		$result = $stmt->fetch();
		if($result)
		{
			return $result[0];
		}
		return null;
	}

	private static function addCity_PostalCode($city_id, $postalcode_id){
		$city_postalCode_id = self::getCity_PostalCode_id($city_id, $postalcode_id);
		if($city_postalCode_id == null) {
			$db = new DB();
			$stmt = $db->pdo->prepare('insert into City_Postalcode (city_id,postalcode_id) values (?,?)');
			$stmt->bindParam(1, $city_id, PDO::PARAM_INT);
			$stmt->bindParam(2, $postalcode_id, PDO::PARAM_INT);
			$stmt->execute();
			$city_postalCode_id = self::getCity_PostalCode_id($city_id, $postalcode_id);
		}
		return $city_postalCode_id;
	}

	private static function getCity_PostalCode_id($city_id, $postalcode_id){
		$db = new DB();
		$stmt = $db->pdo->prepare('select city_postalcode_id from City_Postalcode where postalcode_id = ? and city_id = ?');
		$stmt->bindParam(1,$postalcode_id,pdo::PARAM_INT);
		$stmt->bindParam(2,$city_id,pdo::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		if($result)
		{
			return $result[0];
		}
		return null;
	}

	private static function addAddress($street, $number,$city_postalcode_id, $additionalInfo = null){
		$address_id = self::getAddress_id($street, $number,$city_postalcode_id,$additionalInfo);
		if($address_id == null) {
			$db = new DB();
			$stmt = $db->pdo->prepare('insert into Address (street,number,additionalinfo,City_postalcode_id) values (?,?,?,?)');
			$stmt->bindParam(1, $street);
			$stmt->bindParam(2, $number);
			$stmt->bindParam(3, $additionalInfo,);
			$stmt->bindParam(4, $city_postalcode_id, PDO::PARAM_INT);
			$stmt->execute();
			$address_id = self::getAddress_id($street, $number,$city_postalcode_id, $additionalInfo);
		}
		return $address_id;
	}

	public static function getAddress_id($street, $number,$city_postalcode_id, $additionalInfo = null){
		$db = new DB();
		$stmt = $db->pdo->prepare('select address_id from Address where lower(street) = lower(?) and lower(number) = lower(?) and ifnull(lower(additionalInfo),0) = ifnull(lower(?),0) and city_postalcode_id = ?');
		$stmt->bindParam(1,$street);
		$stmt->bindParam(2,$number);
		$stmt->bindParam(3,$additionalInfo);
		$stmt->bindParam(4,$city_postalcode_id);
		$stmt->execute();
		$result = $stmt->fetch();
		if($result)
		{
			return $result[0];
		}
		return null;
	}

    public static function getAddressbyUserId($user_id){
         $db = new DB();
         $applicant = Applicant::getApplicantByUserId($user_id);
         $company = Company::getCompanyByUserId($user_id);
         if ($applicant->applicant_id != null){
            $stmt = $db->pdo->prepare('select address_id from Applicant where user_id = ?');
            $stmt->bindParam(1,$user_id,PDO::PARAM_INT);
            $stmt->execute();
            $address_id = $stmt->fetch();
         }elseif($company->company_id != null){
            $stmt = $db->pdo->prepare('select address_id from Company where user_id = ?');
            $stmt->bindParam(1,$user_id,PDO::PARAM_INT);
            $stmt->execute();
            $address_id = $stmt->fetch();
         }
         $stmt = $db->pdo->prepare('SELECT    a.street,
                                                    a.number,
                                                    c.city,
                                                    pc.Postalcode,
                                                    s.state,
                                                    co.country
                                                FROM Address a 
                                                LEFT JOIN City_Postalcode cp ON a.City_Postalcode_id = cp.City_Postalcode_id
                                                LEFT JOIN City c ON cp.city_id = c.city_id
                                                LEFT JOIN Postalcode pc ON cp.postalcode_id = pc.postalcode_id
                                                LEFT JOIN State s ON pc.state_id = s.state_id
                                                LEFT JOIN Country co ON s.country_id = co.country_id
                                                WHERE a.address_id = ?');
         $stmt->bindParam(1,$address_id);
         $stmt->execute();
         return $stmt->fetch();
    }
}