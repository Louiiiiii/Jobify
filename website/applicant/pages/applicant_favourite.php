<?php
session_start();
if (isset($_POST['jobinfo'])){
    $_SESSION['currjob_id'] = $_POST['jobinfo'];
    header("Location: applicant_job.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favourited</title>
    <link rel="stylesheet" href="../../source/css/bulma.css">
    <link rel="stylesheet" href="../../source/css/applicant.css">
    <link rel="stylesheet" href="/website/source/css/alert.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
    <script src="../../source/js/favourites.js"></script>
</head>
<body>
<?php
include '../parts/applicant_navbar.php';
include $_SERVER['DOCUMENT_ROOT'] .'/website/classes/getClasses.php';

if (!isset($_SESSION["current_user_id"]))
{
	$userid = 9;
}
else{
    $userid = $_SESSION["current_user_id"];
}

if (isset($_POST['favorite'])){
    $applicant = Applicant::getApplicantByUserId($userid);
    $applicant->changeFavoriteStatus($_POST['favorite']);
}

$jobtitle = null;
$salaryfrom = null;
$salaryto = null;
$companyname = null;
$cityname = null;
$industry = null;

if (isset($_POST['filter'])){

    if ($_POST['jobtitle'] != ""){
        $jobtitle = '%'.$_POST['jobtitle'].'%';
    }

    if ($_POST['salaryfrom'] != null){
        $salaryfrom = $_POST['salaryfrom'];
    }

    $salaryto = $_POST['salaryto'];

    if ($_POST['companyname'] != "--Alle--"){
        $companyname = '%'.$_POST['companyname'].'%';
    }

    if ($_POST['cityname'] != null){
        $cityname = '%'.$_POST['cityname'].'%';
    }

    if ($_POST['industry'] != "--Alle--"){
        $industry = '%'.$_POST['industry'].'%';
    }
}
$applicant = Applicant::getApplicantByUserId($userid);
$db = new DB();
$filter = $db->pdo->prepare('select  distinct (j.job_id),
                                            j.title title,
												j.description description,
												j.job_id job_id
										 from Job j,
                                              Favorite f
										where j.job_id = f.job_id
                                          and not exists(select * 
                                                           from Application a 
                                                          where j.job_id = a.job_id 
                                                            and a.applicant_id = :applicant)
                                          and f.applicant_id = :applicant');
$filter->bindParam('applicant', $applicant->applicant_id,PDO::PARAM_INT);
$filter->execute();
?>
    <div class="row">
        <div class="column">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        <?php
						echo $filter->rowCount().' favourited Jobs';
						?>
                    </p>
                </header>
            </div>
        </div>
    </div>
<?php
for ($i = 1; $i <= ceil($filter->rowCount()/2); $i++){
	?>
    <div class="row">
		<?php
		for($j = 0; $j < 2; $j++){
			if ($res = $filter->fetch()){
				?>
                <div class="column">
                    <div class="card">
                        <header class="card-header">
                            <p class="card-header-title">
								<?php
								echo $res['title'];
								?>
                            <div class="like">
                                <form method="post">
                                    <button type="submit" name="favorite" value=<?php echo $res['job_id'] ?> style="background: transparent; border: transparent">
                                    <span class="icon is-small">
                                        <i class="fas fa-heart liked"></i>
                                    </span>
                                    </button>
                                </form>
                            </div>
                            </p>
                        </header>
                        <div class="card-content">
                            <div class="content">
                                <div>
									<?php
									echo $res['description']
									?>
                                </div>
                                <div class="content__button">
                                    <form method="post">
                                        <button class="button is-info is-rounded" type="submit" value=<?php echo $res['job_id']?> name="jobinfo">
                                    <span class="icon is-small">
                                        <i class="fas fa-info"></i>
                                    </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
			}
		}
		?>
    </div>
	<?php
}
?>
</body>
</html>