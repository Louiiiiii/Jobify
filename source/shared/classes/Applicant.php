<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/source/shared/classes/User.php";

class Applicant extends User
{
    public $applicant_id;
    public $firstname;
    public $lastname;
    public $birthdate;
    public $description;
    public $allow_headhunting;
    public $street_id;
    public $education;

    public $user_id;

    public function __construct($firstname, $lastname, $birthdate,$description, $allow_headhunting,$user_id, $street_id,$education)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthdate = $birthdate;
        $this->description = $description;
        $this->allow_headhunting = $allow_headhunting;
        $this->street_id = $street_id;
        $this->education = $education;
        $this->user_id = $user_id;
        parent::__construct(null,null);
    }


    public function getApplicantByUserId() {
        $stmt = $this->pdo->prepare('select * from applicant where user_id = ?');
        $stmt->bindParam(1,$this->user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        $applicant = new Applicant($result['firstname'],$result['lastname'],$result['birthdate'],$result['description'],$result['allow_headhunting'],$result['user_id'],$result['street_id'],$result['education_id']);
        $applicant->getApplicant_id();
        return $applicant;
    }

    public function addEducation($education){
        $education_id = $this->getEducation_id($education);
        if ($education_id == null)
        {
            $db = new DB();
            $stmt = $db->pdo->prepare('insert into education (name) values (?)');
            $stmt->bindParam(1, $education);
            $stmt->execute();
            $education_id = self::getEducation_id($education);
        }
        return $education_id;
    }

    public function getEducation_id($education){
        $stmt = $this->pdo->prepare('select education_id from education where lower(name) = lower(?)');
        $stmt->bindParam(1,$education);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result == null)
        {
            return $result[0];
        }
        return null;
    }

    public function addIndustry($industry,$parent = null, $addCorrelation = true){
        $industry_id = $this->getIndustry_id($industry);
        if ($parent != null) {
            $parent_id = $this->getIndustry_id($parent);
        }
        else {
            $parent_id = null;
        }
        if ($industry_id == null)
        {
            $db = new DB();
            $stmt = $db->pdo->prepare('insert into industry (name, parent_industry) values (?,?)');
            $stmt->bindParam(1, $industry);
            $stmt->bindParam(2, $parent_id, PDO::PARAM_INT);
            $stmt->execute();
            $industry_id = self::getIndustry_id($industry);
        }

        if ($addCorrelation){
            addApplicant_Industry($industry_id);
        }
        return $industry_id;
    }

    public function getIndustry_id($industry, $parent = null){
        if($parent != null){
            $parent_id = $this->getIndustry_id($parent);
        } else {
            $parent_id = null;
        }
        $query = 'select industry_id from industry where lower(name) = lower(?)';
        if ($parent_id == null){
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
        if ($result)
        {
            return $result[0];
        }
        return null;
    }

    public function getApplicant_id() {
        $stmt = $this->pdo->prepare('select applicant_id id from applicant where user_id = ?');
        $stmt->bindParam(1,$this->user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        $this->applicant_id =$result[0];
        return $result[0];
    }

    public function addApplicant_Industry($industry_id){
        $id = $this->getApplicantIndustry_id($industry_id);
        if ($id == null) {
            $this->getApplicant_id();
            $stmt = $this->pdo->prepare('insert into applicant_industry (applicant_id,industry_id) values (?,?)');
            $stmt->bindparam(1, $this->applicant_id);
            $stmt->bindparam(2, $industry_id);
            $stmt->execute();
            $id = $this->getApplicantIndustry_id($industry_id);
        }
        return $id;

    }

    public function getApplicantIndustry_id($industry_id){
        $this->getApplicant_id();
        $stmt = $this->pdo->prepare('select applicant_industry_id from applicant_industry where applicant_id = ? and industry_id = ?');
        $stmt->bindparam(1, $this->applicant_id);
        $stmt->bindparam(2, $industry_id);
        $stmt->execute();
        $result = $stmt->fetch();
        if($result){
            return $result[0];
        }
        return null;
    }

    public function applyForJob($job_id, $text = '',$applicationstatus_id = 1){
        $application_id = $this->getApplication_id($job_id);
        if ($application_id == null){
            $stmt = $this->pdo->prepare('insert into application (text, applicationstatus_id, job_id, applicant_id) values(?,?,?,?)');
            $stmt->bindparam(1, $text);
            $stmt->bindparam(2, $applicationstatus_id, PDO::PARAM_INT);
            $stmt->bindparam(3, $job_id, PDO::PARAM_INT);
            $stmt->bindparam(4, $application_id, PDO::PARAM_INT);
            $stmt->execute();
            $application_id = $this->getApplication_id($job_id);
        }
        return $application_id;
    }

    public function getApplication_id($job_id){
        $stmt = $this->pdo->prepare('select application_id from application where applicant_id = ? and job_id = ?');
        $stmt->bindparam(1,$this->applicant_id,PDO::PARAM_INT);
        $stmt->bindparam(2,$job_id,PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result){
            return $result[0];
        }
        return null;
    }
}