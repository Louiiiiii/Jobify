<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
    <link rel="stylesheet" href="../../source/css/bulma.css">
    <link rel="stylesheet" href="../../source/css/applicant.css">
    <link rel="stylesheet" href="/website/source/css/alert.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
    <script src="../../source/js/favourites.js"></script>
</head>
<body>
<?php
include $_SERVER['DOCUMENT_ROOT'] .'/website/classes/getClasses.php';

session_start();
$skipfilter = true;

include '../parts/applicant_navbar.php';

if (isset($_SESSION['current_user_id'])){
    $user_id = $_SESSION['current_user_id'];
}
else{
    $user_id = 9;
}

if (isset($_SESSION['current_user_email'])){
    $email = $_SESSION['current_user_email'];
}
else{
    $email = 'testuser@gmail.com';
}

if (isset($_SESSION['currjob_id'])){
    $currjob_id = $_SESSION['currjob_id'];
}
else{
    $currjob_id = 1;
}

if (isset($_SESSION['alreadyapplied'])){
	$alreadyapplied = $_SESSION['alreadyapplied'];
}
else{
    $alreadyapplied = null;
}

if (isset($_POST["file_submit"])) {

    $filetype_name = $_POST["filetype_name"];

    File::uploadFile($_FILES["fileToUpload"], $filetype_name, $user_id, $email);

    //Unset and delete file from server
    unset($_POST);

    $fileToUpload = $_FILES['fileToUpload']['tmp_name'];

    unset($_FILES);
}

if (isset($_POST['apply']))
{
    $applicant = Applicant::getApplicantByUserId($user_id);
    if(isset($_POST['files'])){
		$applicant->applyForJob($currjob_id,$_POST['text'],$_POST['files']);

		$fileids = str_repeat('?,', count($_POST['files']) - 1) . '?';

		$db = new DB();
		$stmt = $db->pdo->prepare('select name 
                                       from File
                                      where file_id in('.$fileids.')');
		$stmt->execute($_POST['files']);
		echo '        
        <div class="modal is-active">
            <div class="modal-background is-active"></div>
            <div class="modal-content">
                <div class="box">
                    <div class="row">
                        <h2 class="title is-4">Succesfully sent Application with Files:</h2>
                    </div>';
		while ($res =$stmt->fetch()){
			echo '<div class="row">';
			echo '<p class="content">'.$res[0].'</p>';
			echo '</div>';
		}
		echo '
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close"></button>
        </div>';
    }
    else{
		$applicant->applyForJob($currjob_id,$_POST['text']);
		echo '        
        <div class="modal is-active">
            <div class="modal-background is-active"></div>
            <div class="modal-content">
                <div class="box">
                    <div class="row">
                        <h2 class="title is-4">Succesfully sent Application wthout any additional Files</h2>
                    </div>
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close"></button>
        </div>';
	}
}

$job = Job::getDatabyId($currjob_id);
$additionaldata = Job::getAdditionalData($job->job_id);
$company = Company::getDatabyId($job->company_id);
?>
    <div class="row">
        <div class="column">
            <div class="card">
            <header class="card-header">
                    <p class="card-header-title" style="font-size: xx-large">
                        <?php echo $job->title;?>
                    </p>
                    <div class="header__tag">
                        <?php
                        if ($alreadyapplied == null) { null; } else {
                        ?>
                            <span class="tag is-medium is-light
                                    <?php
							switch ($alreadyapplied){
								case 'New';
									echo 'is-info';
									break;
								case 'In Progress';
									echo 'is-warning';
									break;
								case 'Rejected';
									echo 'is-danger';
									break;
								case 'Accepted';
									echo 'is-success';
									break;
							}
							?>">
                                <?php echo $alreadyapplied;?>
                                </span>
                        <?php
                        }
                        ?>
                    </div>
                </header>
                <div class="card-content">
                    <div class="content">
                        <div class="header">
                            <b><h2><?php echo $company->name;?></h2></b>
                        </div>
                        <div class="body">
                            <?php echo $company->description;?>
                        </div>
                    </div>
                    <div class="content">
                        <div>
							<?php echo '<p>'.$job->description.'</p>';?>
                        </div>
                        <?php
                        if ($additionaldata['industry']){
                        ?>
                        <br>
                        <div>
							<?php echo '<p><b>Industry:</b> '.$additionaldata['industry'].'</p>'; ?>
                        </div>
                        <?php
                        }
                        if($job->salary != null) {
                            echo "<div>";
                            echo "<br><b>Salary:</b> ".$job->salary."€";
                            echo "</div>";
                        }
                        ?>

                    </div>
					<?php
					if ($additionaldata['address'] != null){
						?>
                        <br>
                        <div>
                            <address>
								<?php
								echo $additionaldata['address'].'<br>';
								echo $additionaldata['city'].'<br>';
								echo $additionaldata['state'].'<br>';
								echo $additionaldata['country'];
								?>
                            </address>
                        </div>
						<?php
					}
					?>
                    <br>
                    <div class="content">
                        <div class="content__button">
                        <?php
                            if ($alreadyapplied == null) {
                            ?>
                                <button class="button is-info js-modal-trigger" data-target="modal-js-example">Bewerben</button>
                                <span><?php $alreadyapplied ?></span>
                            <?php
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-js-example" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <form class="form" method="post">
                    <div class="row">
                        <label class="label">Choose upload files</label>
                    </div>
                    <?php
                    $files = File::getAllFilesByUser($user_id);
                    $cnthead = 3;
                    $cntbottom = 1;
                    foreach ($files as $file) {
                        if ($cnthead == 3){
                            echo '<div class="row">
';
                            $cnthead = 1;
                        }
                        else{
                            $cnthead++;
                        }
                        ?>
                        <div class="column">
                            <input type="checkbox" name="files[]" id=<?php echo $file[0].$file[1]; ?> value=<?php echo $file[0];?>>
                            <label class="checkbox" for=<?php echo $file[0].$file[1]; ?>>
                                <?php echo $file[1]; ?>
                            </label>
                        </div>
                        <?php
                        if ($cntbottom == 3){
                            echo '</div>';
                            $cntbottom = 1;
                        }
                        else{
                            $cntbottom++;
                        }
                    }
                    if ($cntbottom != 1){
                        echo '</div>';
                    }
                    ?>
                    <br>
                    <div class="row">
                        <label class="label" for="textid">Send optional text to Company</label>
                    </div>
                    <div class="row">
                        <textarea class="textarea has-fixed-size" name="text" id="textid" rows="7" style="min-width: 100%"></textarea>
                    </div>
                    <br>
                    <div class="buttons is-right row">
                        <button class="button is-info" type="submit" name="apply">Bewerbung Absenden</button>
                    </div>
                    <hr>
                </form>
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <label class="label">Choose upload files</label>
                    </div>
                    <div id="file-js-example" class="file has-name row">
                        <label class="file-label">
                            <input class="file-input" type="file" name="fileToUpload">
                            <span class="file-cta">
                              <span class="file-icon">
                                <i class="fas fa-upload"></i>
                              </span>
                              <span class="file-label">
                                Choose a file…
                              </span>
                            </span>
                            <span class="file-name">
                              -nothing selected-
                            </span>
                        </label>
                    </div>
                    <br>
                    <div class="row">
                        <label class="label">File Type:</label>
                    </div>
                    <div class="row">
                        <div class="select">
                            <select name="filetype_name" required>
                                <?php
                                $allFileTypes = File::getAllFilesByUser($user_id);

                                foreach ($allFileTypes as $row) {
                                    echo '<option value="' . $row["type"] . '">' . $row["type"] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <button class="button" type="submit" name="file_submit">Upload File</button>
                    </div>
                </form>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
</body>
</html>

<script src="/website/source/js/modal.js"></script>
<script>
    const fileInput = document.querySelector('#file-js-example input[type=file]');
    fileInput.onchange = () => {
        if (fileInput.files.length > 0) {
            const fileName = document.querySelector('#file-js-example .file-name');
            fileName.textContent = fileInput.files[0].name;
        }
    }
</script>