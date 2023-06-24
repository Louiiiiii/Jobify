<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/website/classes/DB.php";

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

	public static function getDatabyId($job_id):Job{
		$db = new DB;
		$stmt = $db->pdo->prepare('select * from Job where job_id = ?');
		$stmt->bindParam(1,$job_id);
		$stmt->execute();
		$res = $stmt->fetch();
		$job = new Job($res['title'],$res['isvolunteerwork'],$res['company_id'],$res['description'],$res['salary']);
		$job->job_id = $job_id;
		return $job;
	}

	public static function getAllJobsByCompany($company_id){
		$db = new DB();
		$stmt = $db->pdo->prepare('select * 
  										   from Job 
  									      where company_id = ?');
		$stmt->bindParam(1,$company_id);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public static function getAllAplicantsforJobNotRejected($job_id){
		$db = new DB();
		$stmt = $db->pdo->prepare('select a.text applicationtext,
												a.applicationstatus_id status,
												a.application_id,
       											ap.*
  										   from Application a,
  										        Applicant ap
  									      where a.applicant_id = ap.applicant_id
  									        and a.job_id = ?
  									        and a.applicationstatus_id != 3');
		$stmt->bindParam(1,$job_id);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	public static function insertjob($job_id, $title, $isvolunteerwork, $company_id, $description=null, $salary=null)
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


	public static function insertorupdjob($job_id, $title, $isvolunteerwork, $company_id,$description=null, $salary=null)
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

		$job = new job($title, $isvolunteerwork, $company_id, $description=null, $salary=null);
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

	public static function getJob_Data(){
		$db = new DB();
		$stmt = $db->pdo->prepare('select job_id, title from Job');
		$stmt->execute();
		$result = $stmt->fetchAll();

		if ($result != null)
		{
			return $result;
		}
		return null;
	}
}

