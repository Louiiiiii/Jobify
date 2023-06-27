<?php
if (isset($_POST['jobinfo'])){
    session_start();
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
    <title>Overview</title>
    <link rel="stylesheet" href="/website/source/css/bulma.css">
    <link rel="stylesheet" href="/website/source/css/applicant.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
    <script src="../../source/js/favourites.js"></script>
</head>
<body>
<?php
include '../parts/applicant_navbar.php';
include $_SERVER['DOCUMENT_ROOT'] .'/website/classes/getClasses.php';

if (!isset($_SESSION["current_user_id"]))
{
	$userid = 6;
}
else{
	$userid = $_SESSION["current_user_id"];
}

if (isset($_POST['favorite'])){
    $applicant = Applicant::getApplicantByUserId($userid);
    $applicant->changeFavoriteStatus($_POST['favorite']);
}

$applicant = Applicant::getApplicantByUserId($userid);
$db = new DB();
$filter = $db->pdo->prepare('select   j.title title,
                                            j.description description,
                                            j.job_id job_id,
                                            case when 1 = (select 1 
                                                             from Favorite 
                                                            where applicant_id = :applicant
                                                              and job_id = j.job_id)
                                                 then 1
                                                 else 0 end favorite,
                                            h.text text
                                      from Job j,
                                           Headhunt h
                                     where j.job_id = h.job_id
                                       and h.applicant_id = :applicant');
$filter->bindParam('applicant', $applicant->applicant_id,PDO::PARAM_INT);
$filter->execute();
?>
<div class="row">
    <div class="column">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
					<?php
					echo $filter->rowCount().' Jobs currently offered';
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
                                        <i class="fas fa-heart <?php if($res['favorite'] == 1){echo 'liked';}?>"></i>
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
									echo $res['text']
									?>
                                </div>
                                <div>
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