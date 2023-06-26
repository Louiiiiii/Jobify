<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/website/classes/DB.php";

class Job extends DB
{
	/*user_id?*/
	public $job_id;
	public $title;
	public $description;
	public $salary;
	public $isapprenticeship;
	public $company_id;


	public function __construct($title, $isapprenticeship, $company_id, $salary, $description=null)
	{
		$this->title = $title;
		$this->description = $description;
		$this->salary = $salary;
		$this->isapprenticeship = $isapprenticeship;
		$this->company_id = $company_id;
	}

	public static function getDatabyId($job_id):Job{
		$db = new DB;
		$stmt = $db->pdo->prepare('select * from Job where job_id = ?');
		$stmt->bindParam(1,$job_id);
		$stmt->execute();
		$res = $stmt->fetch();
		$job = new Job($res['title'],$res['isapprenticeship'],$res['company_id'],$res['description'],$res['salary']);
		$job->job_id = $job_id;
		return $job;
	}

	public function updateJob() {
		$db = new DB();
		$query = 'update Job ';
		if ($this->title != null){
			$query = $query . 'set title = :title';
			if ($this->description != null or $this->salary != null or $this->isapprenticeship != null){
				$query = $query . ', ';
			}
		}
		if ($this->description != null){
			if ($this->title == null){
				$query = $query . 'set ';
			}
			$query = $query . 'description = :desctiption';
			if ($this->salary != null or $this->isapprenticeship != null){
				$query = $query . ', ';
			}
		}
		if ($this->salary != null){
			if ($this->title == null and $this->description == null){
				$query = $query . 'set ';
			}
			$query = $query . 'salary = :salary';
			if ($this->isapprenticeship != null){
				$query = $query . ', ';
			}
		}
		if ($this->isapprenticeship != null){
			if ($this->title == null and $this->description == null and $this->salary == null){
				$query = $query . 'set ';
			}
			$query = $query . 'isapprenticeship = :isapprenticeship ';
		}
		$query = $query . 'where job_id = :job_id';

		$stmt = $db->pdo->prepare($query);
		$stmt->bindParam('job_id',$this->job_id,PDO::PARAM_INT);

		if ($this->title != null) {
			$stmt->bindParam('title', $this->title);
		}
		if ($this->description != null) {
			$stmt->bindParam('description', $this->description);
		}
		if ($this->salary != null) {
			$stmt->bindParam('salary', $this->salary, PDO::PARAM_INT);
		}
		if ($this->isapprenticeship != null) {
			$stmt->bindParam('isapprenticeship', $this->isapprenticeship, PDO::PARAM_INT);
		}
		$stmt->execute();
		$stmt->debugDumpParams();
	}

	public function insertjob()
	{
		$db = new DB();
		$stmt = $db->pdo->prepare("insert into Job (title, description, salary, isapprenticeship, company_id) values (?,?,?,?,?)");
		$stmt->bindParam(1, $this->title);
		$stmt->bindParam(2, $this->description);
		$stmt->bindParam(3, $this->salary, PDO::PARAM_INT);
		$stmt->bindParam(4, $this->isapprenticeship, PDO::PARAM_INT);
		$stmt->bindParam(5, $this->company_id, PDO::PARAM_INT);

		if($stmt->execute())
		{
			return $db->pdo->lastInsertId();
		} else {
			return null;
		}
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

	public static function deleteJobByJobID($job_id)
	{
		$db = new DB();
		$stmt = $db->pdo->prepare("DELETE FROM Job WHERE job_id = ?");
		$stmt->bindParam(1, $job_id, PDO::PARAM_INT);

		if($stmt->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	public static function insertorupdjob($job_id, $title, $isapprenticeship, $company_id,$description=null, $salary=null)
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

		$job = new job($title, $isapprenticeship, $company_id, $description=null, $salary=null);
		$stmt = $job->pdo->prepare("insert into Job (job_id, title, description, salary, isapprenticeship, company_id) values (?,?,?,?,?)");
		$stmt->bindParam(1, $job_id, PDO::PARAM_STR);
		$stmt->bindParam(2, $title, PDO::PARAM_INT);
		$stmt->bindParam(3, $description, PDO::PARAM_INT);
		$stmt->bindParam(4, $salary, PDO::PARAM_STR);
		$stmt->bindParam(5, $isapprenticeship, PDO::PARAM_STR);
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

	public static function getJobIndustries($job_id){
		$db = new DB();
		$stmt = $db->pdo->prepare('
			SELECT 
				i.industry_id,
				i.name
			FROM jobify.job_industry ji
			LEFT JOIN jobify.industry i ON ji.industry_id = i.industry_id
			WHERE ji.job_id = ?
		;');
		$stmt->bindParam(1, $job_id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();

		if ($result != null)
		{
			return $result;
		}
		return null;
	}

	public static function addIndustryToJob($job_id, $industry_id) {
		$db = new DB();
		$stmt = $db->pdo->prepare('
			INSERT INTO Job_Industry (job_id, industry_id)
			VALUES(?,?)
		;');
		$stmt->bindParam(1, $job_id, PDO::PARAM_INT);
		$stmt->bindParam(2, $industry_id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();		

		return $result;
	}

	public static function delAllIndustriesByJob($job_id) {
		$db = new DB();
		$stmt = $db->pdo->prepare('
			DELETE FROM Job_Industry WHERE job_id = ?
		;');
		$stmt->bindParam(1, $job_id, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();		

		return $result;
	}
}

