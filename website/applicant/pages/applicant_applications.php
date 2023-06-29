<?php
if (isset($_POST['jobinfo'])){
    session_start();
    $_SESSION['currjob_id'] = $_POST['jobinfo'];
    $_SESSION['alreadyapplied'] = $_POST['applicationstatus'];
    header("Location: applicant_job.php");
    die();
}

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

$modal = '';
if (isset($_POST['delete-application-btn'])){
	$modal= '<div class="modal is-active">
                <div class="modal-background is-active"></div>
                <div class="modal-content">
                    <div class="box">
                            <h1 class="title is-">Do you really want to delete this Application?</h1>
                            <h2 class="subtitle">This will also delete it for the Company!</h2>
                        <form method="post">
                            <button class="button is-danger" name="reject">Remove</button>
                            <button class="button is-Info" name="cancel">Cancel</button>
                            <input type="text" hidden name="application_id" value="'.$_POST['application_id'].'">
                        </form>
                    </div>
                </div>
                <button class="modal-close is-large" aria-label="close"></button>
             </div>';
}
if (isset($_POST['reject'])){
    $db = new DB();
	$stmt = $db->pdo->prepare('delete from Application_File where application_id = ?');
	$stmt->bindParam(1,$_POST['application_id'],PDO::PARAM_INT);
	$stmt->execute();
    $stmt = $db->pdo->prepare('delete from Application where application_id = ?');
    $stmt->bindParam(1,$_POST['application_id'],PDO::PARAM_INT);
    $stmt->execute();
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
	}elseif($_POST['industryname'] != null){
		$industry = '%'.$_POST['industryname'].'%';
	}
}
$applicant = Applicant::getApplicantByUserId($userid);
$db = new DB();
$filter = $db->pdo->prepare('select j.title,
                                           j.description,
                                           j.job_id,
                                           ap.text,
                                           aps.status,
                                           ap.application_id
                                      from Application ap,
                                           Applicant a,
                                           Job j,
                                           ApplicationStatus aps,
                                           Company c,
                                           Address ad,
                                           City_Postalcode cp,
                                           City ci,
                                           Industry i,
                                           Job_Industry ji
                                     where ap.applicant_id = a.applicant_id
                                       and ap.job_id = j.job_id
                                       and ap.applicationstatus_id = aps.applicationstatus_id
                                       and j.company_id = c.company_id
                                       and c.address_id = ad.address_id
                                       and ad.city_postalcode_id = cp.city_postalcode_id
                                       and cp.city_id = ci.city_id
                                       and j.job_id = ji.job_id
                                       and ji.industry_id = i.industry_id
                                       and a.user_id = :userid
                                       and (lower(j.title) like lower(:jobtitle) or :jobtitle is null)
                                       and (j.salary >= :salaryfrom or :salaryfrom is null or :salaryfrom = 0)
                                       and (j.salary <= :salaryto or :salaryto is null or :salaryto = 0)
                                       and (lower(c.name) like lower(:companyname) or :companyname is null)
                                       and (lower(ci.city) like lower(:cityname) or :cityname is null)
                                       and (lower(i.name) like lower(:industry) or :industry is null)');
$filter->bindParam('userid', $userid,PDO::PARAM_INT);
$filter->bindParam('jobtitle', $jobtitle);
$filter->bindParam('salaryfrom', $salaryfrom, PDO::PARAM_INT);
$filter->bindParam('salaryto', $salaryto,PDO::PARAM_INT);
$filter->bindParam('companyname', $companyname);
$filter->bindParam('cityname', $cityname);
$filter->bindParam('industry', $industry);
$filter->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications</title>
    <link rel="stylesheet" href="../../source/css/bulma.css">
    <link rel="stylesheet" href="../../source/css/applicant.css">
    <link rel="stylesheet" href="/website/source/css/alert.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
    <script src="../../source/js/favourites.js"></script>
</head>
<body>
<?php
    echo $modal;
?>
<div class="row">
    <div class="column">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
					<?php
					echo $filter->rowCount().' Application active';
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
                            </p>
                            <div class="like field is-grouped">
                                <span class="tag is-large
                                    <?php
                                    switch ($res['status']){
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
                                <?php echo $res['status'];?>
                                </span>
                            </div>
                        </header>
                        <div class="card-content">
                            <div class="content">
                                <div style="float: right">
                                    <div >
										<?php
										echo $res['description'];
										?>
                                    </div>
                                    <div>
                                        <form method="post">
                                            <input type="text" hidden name="application_id" value=<?php echo $res['application_id']; ?>>
                                            <input type="text" hidden name="applicationstatus" value=<?php echo $res['status']; ?>>
                                            <button class="button is-info " type="submit" value=<?php echo $res['job_id']?> name="jobinfo">
                                                <span class="icon is-small">
                                                    <i class="fas fa-info"></i>
                                                </span>
                                            </button>
                                            <button class="button is-danger is-outlined" type="submit" name="delete-application-btn" value=<?php echo $res['application_id']; ?>>
                                            <span class="icon is-small">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="spacer" style="clear: both;"></div>
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