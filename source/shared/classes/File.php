<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/source/shared/classes/User.php";

$path = 'C:/testpath';
class File extends User
{
    protected $file_id;
    public $path;
    public $name;
    public $upldate;
    public $filetype_name;
    public $job_id;

    public function __construct($path,$filetype_name,$user_email, $user_passwordhash, $name = null,$job_id = null,  $date = null)
    {
		if($date == null)
		{
			$date = date('d-m-y h:i:s');
		}
        $this->path = $path;
        $this->name = $name;
        $this->upldate = $date;
		$this->filetype_name = $filetype_name;
		$this->filetype_name = self::getFiletypeId($filetype_name);
        $this->job_id = $job_id;
        parent::__construct($user_email, $user_passwordhash);
    }
	public function updateDB()
	{
		$this->file_id = $this->getFile_id();
		if ($this->file_id == null) {
			$success = $this->insert();
		}
		elseif ($this->file_id != null && $this->hasDifferentJob())
		{
			$success = $this->updateJob();
		}
		return $success;
	}

    private static function getFiletypeId($filetype){
        $db = new DB();
        $stmt = $db->pdo->prepare("Select filetype_id from filetype where lower(type) = lower(?)");
        $stmt->bindParam(1,$filetype);
        $stmt->execute();
        $result = $stmt->fetch();
		if ($result == null)
		{
			return $result[0];
		}
		return null;
    }

	private static function addFileType($filetype)
	{
		$filetype_id = self::getFiletypeId($filetype);
		if($filetype_id == null) {
			$db = new DB();
			$stmt = $db->pdo->prepare('insert into filetype (filetype) values (?)');
			$stmt->bindParam(1, $filetype);
			$stmt->execute();
			$filetype_id = self::getFiletypeId($filetype);
		}
		return $filetype_id;
	}

	private function getFile_id(){
		$stmt = $this->pdo->prepare('select file_id from file where lower(path) = lower(?) and name = ? and filetype_id = ? and user_id = ? and ifnull(job_id,0) = ifnull(?,0)');
		$stmt->bindParam(1,$this->path);
		$stmt->bindParam(2,$this->name);
		$stmt->bindParam(3,$this->user_id);
		$stmt->bindParam(4,$this->job_id);
		$stmt->execute();
		$result = $stmt->fetch();
		if($result)
		{
			return $result[0];
		}
		return null;
	}

	private function hasDifferentJob(): bool
	{
		$stmt = $this->pdo->prepare('select job_id from file where file_id = ?');
		$stmt->bindParam(1,$this->file_id);
		$stmt->execute();
		$result = $stmt->fetch();
		if($result[0] != $this->job_id)
		{
			return true;
		}
		return false;
	}

	private function insert(): bool
	{
		$filetype_id = self::addFileType($this->filetype_name);
		$stmt = $this->pdo->prepare('insert into file (path,name,upldate,filetype_id,user_id, job_id) values (?,?,?,?,?,?)');
		$stmt->bindParam(1, $this->path);
		$stmt->bindParam(2, $this->name);
		$stmt->bindParam(3, $this->upldate);
		$stmt->bindParam(4, $filetype_id);
		$stmt->bindParam(5, $this->user_id);
		$stmt->bindParam(6, $this->job_id);
		return $stmt->execute();
	}

	private function updateJob(): bool
	{
		$stmt = $this->pdo->prepare('update file set job_id = ? where file_id = ?');
		$stmt->bindParam(1, $this->job_id);
		$stmt->bindParam(2, $this->file_id);
		return $stmt->execute();
	}
}