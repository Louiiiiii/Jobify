<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/website/classes/User.php";

// TODO: set right path
$path = 'C:/testpath';
class File extends User
{
    protected $file_id;
    public $name;
    public $upldate;
    public $filetype_name;
    public $job_id;

    public function __construct($filetype_name,$name,$job_id,$date = null, $user_email = null, $user_passwordhash = null)
    {
		if($date == null)
		{
			$date = date('d-m-y h:i:s');
		}
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
        $stmt = $db->pdo->prepare("Select filetype_id from Filetype where lower(type) = lower(?)");
        $stmt->bindParam(1,$filetype);
        $stmt->execute();
        $result = $stmt->fetch();
        print_r($result);
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
			$stmt = $db->pdo->prepare('insert into Filetype (type) values (?)');
			$stmt->bindParam(1, $filetype);
			$stmt->execute();
			$filetype_id = self::getFiletypeId($filetype);
		}
		return $filetype_id;
	}

	private function getFile_id(){
		$stmt = $this->pdo->prepare('select file_id from File where name = ? and filetype_id = ? and user_id = ? and ifnull(job_id,0) = ifnull(?,0)');
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
		$stmt = $this->pdo->prepare('select job_id from File where file_id = ?');
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
		$stmt = $this->pdo->prepare('insert into File (name,upldate,filetype_id,user_id, job_id) values (?,?,?,?,?)');
		$stmt->bindParam(2, $this->name);
		$stmt->bindParam(3, $this->upldate);
		$stmt->bindParam(4, $filetype_id);
		$stmt->bindParam(5, $this->user_id);
		$stmt->bindParam(6, $this->job_id);
		return $stmt->execute();
	}

	private function updateJob(): bool
	{
		$stmt = $this->pdo->prepare('update File set job_id = ? where file_id = ?');
		$stmt->bindParam(1, $this->job_id);
		$stmt->bindParam(2, $this->file_id);
		return $stmt->execute();
	}

	function uploadFile($file, $user_id) {
        print_r($file);

        $FileFormat = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));
        $allowedFileFormats = ["jpg","png","jpeg","pdf","docx","xlsx","txt"];
        
        $folderName = $user_id;
        $uplFilesDir = $_SERVER['DOCUMENT_ROOT'] . "/source/uplfiles/";
        $folderPath = $uplFilesDir . $folderName;

        $targetFilePath = $folderPath . "/" . $file["name"];


        //check file format
        foreach ($allowedFileFormats as $type) {
            if ($type == $FileFormat) {
                break;
            } else {
                echo "<script>alert('Sorry, wrong file format! (allowed formats: jpg, png, jpeg, pdf, docx, xlsx, txt)');</script>";
                return false;
            }
        }

        //check size
        if ($file["size"] > 3000000) {
            echo "<script>alert('Sorry, your file is to big! (max 3 MB)');</script>";
            return false;
        }

        // Check if folder already exists
        if (!is_dir($folderPath)) {
            mkdir($folderPath);
        }

        // Check if file already exists
        if (file_exists($targetFilePath)) {
            echo "<script>alert('Sorry, a file with this name is already exsisting!');</script>";
            return false;
        }

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return true;
        } else {
            return false;
        }
    }

    public static function getFile($user_id, $filetype){
        $db = new DB();
        $stmt = $db->pdo->prepare('
            SELECT f.*
            FROM File f
            LEFT JOIN Filetype ft ON f.filetype_id = ft.filetype_id
            WHERE user_id = ?
            AND ft.type = ? 
            ORDER BY f.upldate desc
        ');
        $stmt->bindParam(1,$user_id,PDO::PARAM_INT);
        $stmt->bindParam(2,$filetype,PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        if($res != null){
            return $res;
        }
    }

    public function getAllFilesByUser($user_id){
        $db = new DB();
        $stmt = $db->pdo->prepare('
            SELECT f.file_id,
                f.name,
                ft.type
            FROM File f
            LEFT JOIN Filetype ft ON f.filetype_id = ft.filetype_id
            WHERE user_id = ?'
        );
        $stmt->bindParam(1,$user_id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();

        /*
         * rückgabe:
        (
            [0] => Array
                (
                    [name] => apple
                    [0] => apple
                    [colour] => red
                    [1] => red
                )

            [1] => Array
                (
                    [name] => pear
                    [0] => pear
                    [colour] => green
                    [1] => green
                )
        )
                 * */
    }
}