<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
    <link rel="stylesheet" href="../../source/css/company.css">
    <link rel="stylesheet" href="../../source/css/bulma.css">
    <link rel="stylesheet" href="../../source/css/applicant.css">
    <link rel="stylesheet" href="../../source/css/treeView.css">
    <link rel="stylesheet" href="../../source/css/person_card.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
</head>
<body>
<?php require_once '../parts/company_navbar.php';
include $_SERVER['DOCUMENT_ROOT'] .'/website/classes/getClasses.php';

$name = null;
$place = null;
$industry = null;
$education = null;

if (!isset($_SESSION["current_user_id"]))
{
	$userid = 1;
}
else{
	$userid = $_SESSION['current_user_id'];
}

if (isset($_POST['filters']))
{
	if ($_POST['employee'] != "")
	{
		$name = '%'.$_POST['employee'].'%';
	}

	if ($_POST['place'] != "")
	{
		$name = '%'.$_POST['place'].'%';
	}

	if ($_POST['industry'] != "--Alle--")
	{
		$industry = '%'.$_POST['industry'].'%';
	}

	if ($_POST['education'] != "--Alle--")
	{
		$industry = '%'.$_POST['education'].'%';
	}
}

$company = Company::getCompanyByUserId($userid);
$jobs = Job::getAllJobsByCompany($company->company_id);
foreach ($jobs as $job) {
	$applicants = Job::getAllAplicantsforJob($job[0]);
	$cnttop = 2;
	$cntbot = 1;
	?>
    <ul class="row" id="treeView">
        <li class="parent">
            <div class="column caret">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            <span class="triangle"></span>
							<?php echo $job[1] ?>
                        </p>
                    </header>
                </div>
            </div>
			<?php
			foreach ($applicants as $applicant) {

				$profile_pic = File::getFile($applicant['user_id'], "Profile Picture");
				if (is_null($profile_pic)) {
					$profile_pic_path = "/website/source/img/user-icon.png";
				} else {
					$profile_pic_path = $_SERVER['DOCUMENT_ROOT'] .'/website/uplfiles/' . $applicant['user_id'] . "/" . $profile_pic["name"];
				}

				if ($cnttop < 2){
					$cnttop++;
				}
				else{
					$cnttop = 1;
					?>
                    <ul class="row nested">
					<?php
				}
				?>
                <li class="child">
                    <div class="column">
                        <div class="card">
                            <div class="card-content">
                                <div class="content">
                                    <div class="left-content">
                                        <div><?php echo $applicant['firstname'].' '.$applicant['lastname']; ?></div>
                                        <figure class="image is-64x64 is-rounded">
                                            <img class="is-rounded" src=<?php echo $profile_pic_path;?>>
                                        </figure>
                                    </div>
                                    <div class="content__button">
                                        <button class="button is-info is-rounded">
                                            <span class="icon is-small">
                                                <i class="fas fa-envelope-open-text"></i>
                                            </span>
                                        </button>
                                        <button class="button is-info is-rounded">
                                            <span class="icon is-small">
                                                <i class="fas fa-info"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
				<?php
				if ($cntbot < 2){
					$cntbot++;
				}
				else{
					$cntbot = 1;
					?>
                    </ul>
					<?php
				}
			}
			?>
        </li>
    </ul>
	<?php
}
?>

</body>
</html>

<script src="../../source/js/treeView.js"></script>