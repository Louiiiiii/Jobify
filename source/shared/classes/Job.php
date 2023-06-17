<?php

class Job extends DB
{
    /*user_id?*/
    private $job_id;
    public $title;
    public $description;
    public $salary;
    public $isvolunteerwork;
    public $company_id;


    public function __construct($title, $isvolunteerwork, $company_id,$description=null, $salary=null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->salary = $salary;
        $this->isvolunteerwork = $isvolunteerwork;
        $this->company_id = $company_id;
    }

    public static function insertjob($job_id, $title, $description=null, $salary=null, $isvolunteerwork, $company_id)
    {
        $job = new job($title, $description=null, $salary=null, $isvolunteerwork, $company_id);
        $stmt = $job->pdo->prepare("insert into Job (job_id, title, description, salary, isvolunteerwork, company_id) values (?,?,?,?,?)");
        $stmt->bindParam(1, $job_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $title, PDO::PARAM_INT);
        $stmt->bindParam(3, $description, PDO::PARAM_INT);
        $stmt->bindParam(4, $salary, PDO::PARAM_STR);
        $stmt->bindParam(5, $isvolunteerwork, PDO::PARAM_STR);
        $stmt->bindParam(6, $company_id, PDO::PARAM_STR);

        if($stmt->execute())
        {
            return $job;
        }
        else
        {
            return null;
        }
    }

    //TODO: OBLE new insertorupd implementieren
    public static function insertorupdjob($job_id, $title, $description=null, $salary=null, $isvolunteerwork, $company_id)
    {
		$db = new DB();
        $stmt = $db->pdo->prepare("select job_id from Job where job_id = ?");
        $stmt->bindParam(1, $job_id, PDO::PARAM_STR);

		$stmt->execute();

        // Fetch the first row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a row was returned
        if ($row) {

        }
        else{

        }

        $job = new job($title, $description=null, $salary=null, $isvolunteerwork, $company_id);
        $stmt = $job->pdo->prepare("insert into Job (job_id, title, description, salary, isvolunteerwork, company_id) values (?,?,?,?,?)");
        $stmt->bindParam(1, $job_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $title, PDO::PARAM_INT);
        $stmt->bindParam(3, $description, PDO::PARAM_INT);
        $stmt->bindParam(4, $salary, PDO::PARAM_STR);
        $stmt->bindParam(5, $isvolunteerwork, PDO::PARAM_STR);
        $stmt->bindParam(6, $company_id, PDO::PARAM_STR);

        if($stmt->execute())
        {
            return $job;
        }
        else
        {
            return null;
        }
    }

    //todo: change to insertorupd
    public function insertorupdHeadhunt($text=null, $applicant_id)
    {
        $stmt = $this->pdo->prepare("insert into Headhunt (text, job_id, applicant_id) values (?,?,?)");
        $stmt->bindParam(1, $text, PDO::PARAM_INT);
        $stmt->bindParam(2, $this->job_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $applicant_id, PDO::PARAM_STR);

        if($stmt->execute())
        {
            return $this;
        }
        else
        {
            return null;
        }
    }

    public static function getHeadhunt_Applicant($applicant_id)
    {
        $myDb = new DB();
        $stmt = $myDb->pdo->prepare("select * from Headhunt where applicant_id = (?)");
        $stmt->bindParam(1, $applicant_id, PDO::PARAM_INT);

        if($stmt->execute())
        {
            return $stmt->fetchAll();
        }
        else
        {
            return null;
        }
    }

    public static function getHeadhunt_Job($job_id)
    {
        $myDb = new DB();
        $stmt = $myDb->pdo->prepare("select * from Headhunt where job_id = (?)");
        $stmt->bindParam(1, $job_id, PDO::PARAM_INT);

        if($stmt->execute())
        {
            return $stmt->fetchAll();
        }
        else
        {
            return null;
        }
    }

    public static function getHeadhunt_Company($company_id)
    {
        $myDb = new DB();
        $stmt = $myDb->pdo->prepare("select * from Job, Headhunt where company_id = (?) and Job.job_id = Headhunt.job_id");
        $stmt->bindParam(1, $company_id, PDO::PARAM_INT);

        if($stmt->execute())
        {
            return $stmt->fetchAll();
        }
        else
        {
            return null;
        }
    }
}