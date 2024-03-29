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
		$job = new Job($res['title'],$res['isapprenticeship'],$res['company_id'],$res['salary'],$res['description']);
		$job->job_id = $job_id;
		return $job;
	}

	public static function getAdditionalData($job_id)
	{
		$db = new DB;
		$stmt = $db->pdo->prepare("select i.name industry,
												concat(a.street,' ',a.number) address,
												concat(p.Postalcode,' ',ci.city) city,
												s.state state,
												co.country country
										      from Job j
									 	 left join Job_Industry ji on j.job_id = ji.job_id
								 		 left join Industry i on ji.industry_id = i.industry_id
							 			 left join Company c on j.company_id = c.company_id
							 			 left join Address a on c.address_id = a.address_id
										 left join City_Postalcode cp on a.city_postalcode_id = cp.city_postalcode_id
										 left join City ci on cp.city_id = ci.city_id
										 left join Postalcode p on cp.postalcode_id = p.postalcode_id
										 left join State s on p.state_id = s.state_id
										 left join Country co on s.country_id = co.country_id
  											 where j.job_id = ?");
		$stmt->bindParam(1,$job_id);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function updateJob() {
		$db = new DB();
		$stmt = $db->pdo->prepare('
			update Job
			set title = :title,
			description = :description,
			salary = :salary,
			isapprenticeship = :isapprenticeship
			where job_id = :job_id
		');
		$stmt->bindParam('job_id',$this->job_id,PDO::PARAM_INT);
		$stmt->bindParam('title', $this->title);
		$stmt->bindParam('description', $this->description);
		$stmt->bindParam('salary', $this->salary, PDO::PARAM_INT);
		$stmt->bindParam('isapprenticeship', $this->isapprenticeship, PDO::PARAM_INT);
		$stmt->execute();
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
		$stmt = $db->pdo->prepare('
			select * 
			from Job 
			where company_id = ?
		;');
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

		if($stmt->execute()) {
			return true;
		} else {
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

	public static function addHeadhuntRequest($text, $job_id, $applicant_id)
	{
		$Db = new DB();
		$stmt = $Db->pdo->prepare("
			INSERT INTO Headhunt (text, job_id, applicant_id) 
			VALUES (?,?,?)
		;");
		$stmt->bindParam(1, $text, PDO::PARAM_STR);
		$stmt->bindParam(2, $job_id, PDO::PARAM_INT);
		$stmt->bindParam(3, $applicant_id, PDO::PARAM_INT);

		if($stmt->execute()) {
			return true;
		} else {
			return false;
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

	public static function deleteHeadhunt($job_id, $applicant_id)
	{
		$myDb = new DB();
		$stmt = $myDb->pdo->prepare("
			DELETE FROM Headhunt WHERE job_id = ? AND applicant_id = ?
		;");
		
		$stmt->bindParam(1, $job_id, PDO::PARAM_INT);
		$stmt->bindParam(2, $applicant_id, PDO::PARAM_INT);

		if($stmt->execute()) {
			return true;
		} else {
			return false;
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
			FROM Job_Industry ji
			LEFT JOIN Industry i ON ji.industry_id = i.industry_id
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

