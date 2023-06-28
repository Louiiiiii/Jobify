<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/website/classes/User.php";

class Applicant extends User
{
    public $applicant_id;
    public $firstname;
    public $lastname;
    public $birthdate;
    public $description;
    public $allow_headhunting;
    public $address_id;
    public $education_id;

    public function __construct($firstname, $lastname, $birthdate, $description, $allow_headhunting, $user_id, $address_id, $education, $email = null, $passwordnothashed = null) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthdate = $birthdate;
        $this->description = $description;
        $this->allow_headhunting = $allow_headhunting;
        $this->address_id = $address_id;
        $this->education_id = $education;
        parent::__construct($email, $passwordnothashed, $user_id);
    }

    public function updateDB() {
        $this->applicant_id = $this->getApplicant_id();
        if ($this->applicant_id == null) {
            $success = $this->insert();
        } elseif ($this->applicant_id != null) {
            $success = $this->update();
        }

        return $success;
    }

    public function addEducation($education) {
        $education_id = $this->getEducation_id($education);

        if ($education_id == null) {
            $db = new DB();

            $stmt = $db->pdo->prepare('
                insert into Education (name) 
                values (?)
            ;');

            $stmt->bindParam(1, $education);
            $stmt->execute();

            $education_id = self::getEducation_id($education);
        }

        return $education_id;
    }

    public function getEducation_id($education) {
        $stmt = $this->pdo->prepare('
            select 
                education_id 
            from Education 
            where lower(name) = lower(?)
        ;');

        $stmt->bindParam(1,$education);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result == null) {
            return $result[0];
        }

        return null;
    }

	public function getEducation() {
		$stmt = $this->pdo->prepare('
            select 
                e.* 
            from Education e, Applicant a
            where e.education_id = a.education_id
            and a.applicant_id = ?
        ;');

		$stmt->bindParam(1,$this->applicant_id,PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();
	}

    public function addIndustry($industry,$parent = null, $addCorrelation = true) {
        $industry_id = $this->getIndustry_id($industry);

        if ($parent != null) {
            $parent_id = $this->getIndustry_id($parent);
        } else {
            $parent_id = null;
        }

        if ($industry_id == null) {
            $db = new DB();
            $stmt = $db->pdo->prepare('
                insert into Industry (name, parent_industry_id) 
                values (?,?)
            ;');
            $stmt->bindParam(1, $industry);
            $stmt->bindParam(2, $parent_id, PDO::PARAM_INT);
            $stmt->execute();
            $industry_id = self::getIndustry_id($industry);
        }

        if ($addCorrelation){
            $this->addApplicant_Industry($industry_id);
        }

        return $industry_id;
    }

    public function getIndustry_id($industry, $parent = null) {

        if($parent != null) {
            $parent_id = $this->getIndustry_id($parent);
        } else {
            $parent_id = null;
        }

        $query = '
            select 
                industry_id 
            from Industry 
            where lower(name) = lower(?)
        ';

        if ($parent_id == null) {
            $query = $query . ' and parent_industry_id is null';
        } else {
            $query = $query . ' and parent_industry_id = ?';
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(1,$industry);

        if($parent_id != null) {
            $stmt->bindParam(2, $parent_id, PDO::PARAM_INT);
        }

        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            return $result[0];
        }

        return null;
    }

    public function getApplicant_id() {
        $stmt = $this->pdo->prepare('
            select 
                applicant_id id from Applicant 
            where user_id = ?
        ;');

        $stmt->bindParam(1,$this->user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result != null) {
            $this->applicant_id = $result[0];
            return $result[0];
        }

        return null;
    }

    public function addApplicant_Industry($industry_id) {
        $id = $this->getApplicantIndustry_id($industry_id);

        if ($id == null) {
            $this->getApplicant_id();

            $stmt = $this->pdo->prepare('
                insert into Applicant_Industry (applicant_id,industry_id) 
                values (?,?)
            ;');

            $stmt->bindparam(1, $this->applicant_id);
            $stmt->bindparam(2, $industry_id);
            $stmt->execute();
            $id = $this->getApplicantIndustry_id($industry_id);
        }

        return $id;

    }

    public function getApplicantIndustry_id($industry_id) {
        $this->getApplicant_id();

        $stmt = $this->pdo->prepare('
            select 
                applicant_industry_id 
            from Applicant_Industry 
            where applicant_id = ? 
            and industry_id = ?
        ;');

        $stmt->bindparam(1, $this->applicant_id);
        $stmt->bindparam(2, $industry_id);
        $stmt->execute();
        $result = $stmt->fetch();

        if($result) {
            return $result[0];
        }

        return null;
    }

    public function applyForJob($job_id, $text,$files = null,$applicationstatus_id = 1) {
        $application_id = $this->getApplication_id($job_id);

        if ($application_id == null) {
            $stmt = $this->pdo->prepare('
                insert into Application (text, applicationstatus_id, job_id, applicant_id) 
                values(?,?,?,?)
            ;');
            $stmt->bindparam(1, $text);
            $stmt->bindparam(2, $applicationstatus_id, PDO::PARAM_INT);
            $stmt->bindparam(3, $job_id, PDO::PARAM_INT);
            $stmt->bindparam(4, $this->applicant_id, PDO::PARAM_INT);
            $stmt->execute();
            $application_id = $this->getApplication_id($job_id);
        }

		if ($files != null) {
			foreach ($files as $file) {
				self::addApplication_File($file,$application_id);
			}
		}

        return $application_id;
    }

    public function getApplication_id($job_id) {
        $stmt = $this->pdo->prepare('
            select 
                application_id 
            from Application 
            where applicant_id = ? and job_id = ?'
        );

        $stmt->bindparam(1,$this->applicant_id,PDO::PARAM_INT);
        $stmt->bindparam(2,$job_id,PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            return $result[0];
        }

        return null;
    }

    public function changeFavoriteStatus($job_id) {
        if($this->checkFavorite($job_id)) {
            $stmt = $this->pdo->prepare('
                delete from Favorite 
                where applicant_id = ? 
                and job_id = ?
            ;');
        } else {
            $stmt = $this->pdo->prepare('insert into Favorite(applicant_id, job_id) values (?,?)');
        }

        $stmt->bindParam(1,$this->applicant_id,PDO::PARAM_INT);
        $stmt->bindParam(2,$job_id,PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getEduction_Data() {
        $stmt = $this->pdo->prepare('
            select 
                education_id, 
                name 
            from Education
        ;');

        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result != null)
        {
            return $result;
        }

        return null;
    }

    public static function deleteAllIndustriesFromApplicant($applicant_id) {
        $db = new DB;

        $stmt = $db->pdo->prepare('
            DELETE FROM Applicant_Industry 
            WHERE applicant_id = ?
        ;');

        $stmt->bindParam(1,$applicant_id, PDO::PARAM_INT);
        $stmt->execute();

        if(is_null(Applicant::countIndustriesFromApplicant($applicant_id))) {
            return true;
        }

        return false;
    }

    public static function countIndustriesFromApplicant($applicant_id) {
        $db = new DB;

        $stmt = $db->pdo->prepare('
            SELECT 
                COUNT(*) 
            FROM Applicant_industry 
            WHERE applicant_id = ?
        ;');

        $stmt->bindParam(1,$applicant_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result != null) {
            return $result;
        }

        return null;        
    }

    public static function getEducation_Data() {
        $db = new DB();

        $stmt = $db->pdo->prepare('
            select 
                education_id, 
                name 
            from Education
        ;');

        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result != null) {
            return $result;
        }

        return null;
    }

    public static function getApplicantByUserId($user_id) {
        $db = new DB;

        $stmt = $db->pdo->prepare('
            select 
                * 
            from Applicant 
            where user_id = ?
        ;');

        $stmt->bindParam(1,$user_id, PDO::PARAM_INT);
        $stmt->execute();

        while($result = $stmt->fetch(PDO::FETCH_BOTH)) {
			$applicant = new Applicant($result['firstname'],$result['lastname'],$result['birthdate'],$result['description'],$result['allow_headhunting'],$result['user_id'],$result['address_id'],$result['education_id']);
			$applicant->getApplicant_id();

			return $applicant;
		}

		return null;
    }

    public static function getUserIDByApplicantID ($applicant_id) {
        $db = new DB();

        $stmt_all_infos = $db->pdo->prepare('
            SELECT 
                u.user_id 
            FROM Applicant a 
            LEFT JOIN User u ON a.user_id = u.user_id
            WHERE applicant_id = ?
        ;');        
        $stmt_all_infos->bindParam(1,$applicant_id, PDO::PARAM_INT);
        $stmt_all_infos->execute();
        $result = $stmt_all_infos->fetchAll();

        if ($result != null)
        {
            return $result[0];
        }

        return null;     
    }

    public static function getProfileDataFromApplicant($user_id) {
        $db = new DB();

        $stmt_all_infos = $db->pdo->prepare('
            SELECT 
                ap.applicant_id,
                u.email,
                ap.firstname,
                ap.lastname,
                ap.birthdate,
                cou.country,
                s.state,
                p.Postalcode,
                ci.city,
                a.street,
                a.number,
                e.name AS "education", 
                ap.allow_headhunting
            FROM jobify.User u
            LEFT JOIN jobify.Applicant ap ON u.user_id = ap.user_id
            LEFT JOIN jobify.Address a ON ap.address_id = a.address_id
            LEFT JOIN jobify.City_Postalcode cp ON a.City_Postalcode_id = cp.City_Postalcode_id
            LEFT JOIN jobify.Postalcode p ON cp.postalcode_id = p.postalcode_id
            LEFT JOIN jobify.City ci ON cp.city_id = ci.city_id
            LEFT JOIN jobify.State s ON p.state_id = s.state_id
            LEFT JOIN jobify.Country cou ON s.country_id = cou.country_id
            LEFT JOIN jobify.Education e ON ap.education_id = e.education_id
            WHERE u.user_id = ?
        ;');  

        $stmt_all_infos->bindParam(1,$user_id, PDO::PARAM_INT);
        $stmt_all_infos->execute();
        $result_all_infos = $stmt_all_infos->fetchAll();

        $stmt_all_industries = $db->pdo->prepare('
            SELECT 
                i.name
            FROM jobify.User u
            LEFT JOIN jobify.Applicant ap ON u.user_id = ap.user_id
            LEFT JOIN jobify.Applicant_Industry ai ON ap.applicant_id = ai.applicant_id
            LEFT JOIN jobify.Industry i ON ai.industry_id = i.industry_id
            WHERE u.user_id = ?
        ;');   

        $stmt_all_industries->bindParam(1,$user_id, PDO::PARAM_INT);
        $stmt_all_industries->execute();
        $result_all_industries = $stmt_all_industries->fetchAll();

        $result = array("infos" => $result_all_infos, "industries" => $result_all_industries);

        if ($result != null)
        {
            return $result;
        }

        return null;        
    }

    public static function getApplicantsToHeadhunt () {
        $db = new DB();

        $stmt = $db->pdo->prepare('
            SELECT * FROM Applicant a
            LEFT JOIN Education e ON a.education_id = e.education_id
            WHERE a.allow_headhunting = 1
        ;');

        $stmt->execute();
        $result = $stmt->fetchAll();

        if($result != null){
            return $result;
        }
    }

    public static function getIndustry_Data() {
        $db = new DB();

        $stmt = $db->pdo->prepare('
            select 
                industry_id, 
                name 
            from Industry
        ;');

        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result != null) {
            return $result;
        }

        return null;
    }

    private function insert() {
        $stmt = $this->pdo->prepare('
            insert into Applicant (firstname, lastname, birthdate, description, allow_headhunting, user_id, address_id, education_id) 
            values (?,?,?,?,?,?,?,?)
        ;');

        $stmt->bindParam(1, $this->firstname);
        $stmt->bindParam(2, $this->lastname);
        $stmt->bindParam(3, $this->birthdate);
        $stmt->bindParam(4, $this->description);
        $stmt->bindParam(5, $this->allow_headhunting);
        $stmt->bindParam(6, $this->user_id);
        $stmt->bindParam(7, $this->address_id);
        $stmt->bindParam(8, $this->education_id);

        return $stmt->execute();
    }

    private function update() {
        $stmt = $this->pdo->prepare('
            update Applicant 
            set firstname = ?, 
            lastname = ?, 
            birthdate = ?, 
            description = ?,
            allow_headhunting = ?, 
            address_id = ?, 
            education_id = ? 
            where applicant_id = ?
        ;');

        $stmt->bindParam(1, $this->firstname);
        $stmt->bindParam(2, $this->lastname);
        $stmt->bindParam(3, $this->birthdate);
        $stmt->bindParam(4, $this->description);
        $stmt->bindParam(5, $this->allow_headhunting);
        $stmt->bindParam(6, $this->address_id);
        $stmt->bindParam(7, $this->education_id);
        $stmt->bindParam(8, $this->applicant_id);

        return $stmt->execute();
    }

    private function checkFavorite($job_id) {
        $stmt = $this->pdo->prepare('
            select * 
            from Favorite
            where applicant_id = ?
            and job_id = ?
        ;');

        $stmt->bindParam(1,$this->applicant_id,PDO::PARAM_INT);
        $stmt->bindParam(2,$job_id,PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() == 1;
    }

	private static function addApplication_File($file_id, $application_id) {
		if (self::checkApplication_File($file_id, $application_id)) {
			$db = new DB();

			$stmt = $db->pdo->prepare('
                insert into Application_File(application_id, file_id) values(?,?)
            ;');

			$stmt->bindParam(1,$application_id,PDO::PARAM_INT);
			$stmt->bindParam(2,$file_id,PDO::PARAM_INT);

			return $stmt->execute();
		}

		return false;
	}

	private static function checkApplication_File($file_id, $application_id):bool {
		$db = new DB();

		$stmt = $db->pdo->prepare('
            select * 
            from Application_File 
            where application_id = ? 
            and file_id = ?
        ;');

		$stmt->bindParam(1,$application_id,PDO::PARAM_INT);
		$stmt->bindParam(2,$file_id,PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->rowCount() >= 0;
	}
}


            
            
