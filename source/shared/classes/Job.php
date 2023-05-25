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
        $stmt = $job->pdo->prepare("insert into job (job_id, title, description, salary, isvolunteerwork, company_id) values (?,?,?,?,?)");
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


    public static function insertorupdjob($job_id, $title, $description=null, $salary=null, $isvolunteerwork, $company_id)
    {
        $stmt = pdo->prepare("select job_id from job where job_id = ?");
        $stmt->bindParam(1, $job_id, PDO::PARAM_STR);

        $statement->execute();

        // Fetch the first row
        $row = $statement->fetch(PDO::FETCH_ASSOC);
    
        // Check if a row was returned
        if ($row) {
            
        }
        else{

        }

        $job = new job($title, $description=null, $salary=null, $isvolunteerwork, $company_id);
        $stmt = $job->pdo->prepare("insert into job (job_id, title, description, salary, isvolunteerwork, company_id) values (?,?,?,?,?)");
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
}

