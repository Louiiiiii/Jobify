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

    public function __construct($filetype_name, $name, $user_email, $date = null, $user_passwordunhashed = null)
    {
		if($date == null)
		{
			$date = date('d-m-y h:i:s');
		}
        $this->name = $name;
        $this->upldate = $date;
		$this->filetype_name = $filetype_name;
        parent::__construct($user_email, $user_passwordunhashed);
        $this->user_id = $this->getUser_id();
    }
	public function updateDB()
	{
		$this->file_id = $this->getFile_id();
		if ($this->file_id == null) {
			$success = $this->insert();
		}
		return $success;
	}

    private static function getFiletypeId($filetype){
        $db = new DB();
        $stmt = $db->pdo->prepare("Select filetype_id from Filetype where lower(type) = lower(?)");
        $stmt->bindParam(1,$filetype);
        $stmt->execute();
        $result = $stmt->fetch();
		if ($result != null)
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
        $filetypeid = self::getFiletypeId($this->filetype_name);
		$stmt = $this->pdo->prepare('select file_id from File where name = ? and user_id = ?  and filetype_id = ?');
		$stmt->bindParam(1,$this->name);
        $stmt->bindParam(2,$this->user_id);
        $stmt->bindParam(3,$filetypeid);
		$stmt->execute();
		$result = $stmt->fetch();
		if($result)
		{
            $this->file_id = $result[0];
			return $result[0];
		}
		return null;
	}

	private function insert(): bool
	{
		$filetype_id = self::addFileType($this->filetype_name);
		$stmt = $this->pdo->prepare('insert into File (name,upldate,filetype_id,user_id) values (?,?,?,?)');
		$stmt->bindParam(1, $this->name);
		$stmt->bindParam(2, $this->upldate);
		$stmt->bindParam(3, $filetype_id);
		$stmt->bindParam(4, $this->user_id);
		return $stmt->execute();
	}

    public function addJob($job_id) {
        $this->getFile_id();
        if (!$this->checkJob($job_id)){
            $stmt = $this->pdo->prepare('insert into Job_File (job_id, file_id) values(?,?)');
            $stmt->bindParam(1,$job_id,PDO::PARAM_INT);
            $stmt->bindParam(2,$this->file_id,PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public function delJob($job_id){
        $this->getFile_id();
        if ($this->checkJob($job_id)){
            $stmt = $this->pdo->prepare('delete from File_Job where job_id = ? and file_id = ?');
            $stmt->bindParam(1,$job_id,PDO::PARAM_INT);
            $stmt->bindParam(2,$this->file_id,PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    public static function getFileName($fileid){
        $db = new DB();
        $stmt = $db->pdo->prepare("Select name from File where file_id = ?");
        $stmt->bindParam(1,$fileid);
        $stmt->execute();
        $result = $stmt->fetch();
		if ($result != null)
		{
			return $result[0];
		}
		return null;
    }

    private function checkJob($job_id){
        $stmt = $this->pdo->prepare('select * from Job_File where job_id = ? and file_id = ?');
        $stmt->bindParam(1,$job_id,PDO::PARAM_INT);
        $stmt->bindParam(2,$this->file_id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() >= 1;
    }

	public static function uploadFile($file, $filetype_name, $user_id, $user_email) {

        $FileFormat = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));
        $allowedFileFormats = ["jpg","png","jpeg","pdf","docx","xlsx","txt"];
        
        $folderName = $user_id;
        $uplFilesDir = $_SERVER['DOCUMENT_ROOT'] . "/website/uplfiles/";
        $folderPath = $uplFilesDir . $folderName;

        $targetFilePath = $folderPath . "/" . $file["name"];


        //check file format
        $file_format_ok = 0;

        //check if file format is under the $allowedFileFormats 
        foreach ($allowedFileFormats as $type) {
            if ($type == $FileFormat) {
                $file_format_ok = 1;
            }
        }

        //if file format is not under $allowedFileFormats var $file_type_ok will still be 0 and therefore this if will faile
        if ($file_format_ok == 0) {
            doAlert("Sorry, wrong file format! (allowed formats: jpg, png, jpeg, pdf, docx, xlsx, txt)");
            return false;
        }

        //check size
        if ($file["size"] > 3000000) {
            doAlert("Sorry, your file is to big! (max 3 MB)");
            return false;
        }

        // Check if folder already exists
        if (!is_dir($folderPath)) {
            mkdir($folderPath);
        }

        // Check if file already exists
        if (file_exists($targetFilePath)) {
            doAlert("Sorry, a file with this name is already exsisting!");
            return false;
        }

        //The result of file_exists() is cached. Use clearstatcache() to clear the cache.
        clearstatcache();

        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {

            $file = NEW FILE($filetype_name, $file["name"], $user_email);

            if($file->updateDB()) {
                doAlert("File upload has worked fine!");
                return true;
            } else {
                doAlert("Sorry, something went wrong by writing in out DB!");
                return false;
            }

        } else {
            doAlert("Sorry, your file wasn't uploaded!");
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
			LIMIT 1 
        ');
        $stmt->bindParam(1,$user_id,PDO::PARAM_INT);
        $stmt->bindParam(2,$filetype,PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        if($res != null){
            return $res;
        }
    }

    public static function delFile($file_id, $user_id){
        $File = false;
        $Job_File = false;
        $Application_File = false;
        $file_nema = FILE::getFileName($file_id);
        $file_path = $_SERVER['DOCUMENT_ROOT'] . "/website/uplfiles/" . $user_id . "/" . $file_nema;

        $db = new DB();
        $stmt = $db->pdo->prepare('delete from File where file_id = ?');
        $stmt->bindParam(1,$file_id,PDO::PARAM_INT);
        if($stmt->execute()) {
            $File = true;
        }
        $stmt = $db->pdo->prepare('delete from Application_File where file_id = ?');
        $stmt->bindParam(1,$file_id,PDO::PARAM_INT);
        if($stmt->execute()) {
            $Application_File = true;
        }

        if (unlink($file_path)) {
            $file_nema = true;
        } else {
            $file_nema = false;
        }

        if($File && $Application_File && $file_path) {
            return true;
        }

        return false;
    }

    public static function getAllFilesByUser($user_id){
        $db = new DB();
        $stmt = $db->pdo->prepare('
            SELECT f.file_id,
                f.name,
                ft.type
            FROM File f
            LEFT JOIN Filetype ft ON f.filetype_id = ft.filetype_id
            WHERE user_id = ?
            ORDER BY f.file_id
        ');
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

	public static function getAllFilesByApplication($application_id){
		$db = new DB();
		$stmt = $db->pdo->prepare('select f.* 
		 								   from File f,
		 								        Application_File af
		 								  where af.application_id = ?
		 								    and af.file_id = f.file_id');
		$stmt->bindParam(1,$application_id,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}
    public static function getAllFileTypes(){
        $db = new DB();
        $stmt = $db->pdo->prepare('
            SELECT *
            FROM Filetype
        ');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}