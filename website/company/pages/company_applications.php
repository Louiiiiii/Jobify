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
		$place = '%'.$_POST['place'].'%';
	}

	if ($_POST['industry'] != "--Alle--")
	{
		$industry = '%'.$_POST['industry'].'%';
	}

	if ($_POST['education'] != "--Alle--")
	{
		$education = '%'.$_POST['education'].'%';
	}
}

$modal = '';
if (isset($_POST['applicationstatus'])){
    if ($_POST['applicationstatus'] == 3) {
		$modal= '        
            <div class="modal is-active">
                <div class="modal-background is-active"></div>
                <div class="modal-content">
                    <div class="box">
                            <h1 class="title is-">Do you realy want to Reject the Applicant</h1>
                            <h2 class="subtitle">The Applicant will Disappear from the View!</h2>
                        <form method="post">
                            <button class="button is-danger" name="reject">Reject and Remove</button>
                            <button class="button is-Info" name="cancel">Cancel</button>
                            <input type="text" name="application_id" hidden value='.$_POST['application_id'].'>
                            <input type="text" name="job_id" hidden value='.$_POST['job_id'].'>
                            <input type="text" name="curr_status" hidden value='.$_POST['curr_status'].'>
                            <input type="text" name="new_status" hidden value='.$_POST['applicationstatus'].'>
                        </form>
                    </div>
                </div>
                <button class="modal-close is-large" aria-label="close"></button>
            </div>';
	}
    else{
        $db = new DB();
        $stmt = $db->pdo->prepare('update Application set applicationstatus_id = ? where application_id = ?');
        $stmt->bindParam(1,$_POST['applicationstatus'],PDO::PARAM_INT);
        $stmt->bindParam(2,$_POST['application_id'],PDO::PARAM_INT);
        $stmt->execute();
    }
}

if (isset($_POST['reject'])){
	$db = new DB();
	$stmt = $db->pdo->prepare('update Application set applicationstatus_id = ? where application_id = ?');
	$stmt->bindParam(1,$_POST['new_status'],PDO::PARAM_INT);
	$stmt->bindParam(2,$_POST['application_id'],PDO::PARAM_INT);
	$stmt->execute();
}
?>

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
<div class="search-row">
    <div class="field">
        <p class="control has-icons-left">
            <input type="text" class="input" id="searchbar" onkeyup="myFunction()" placeholder="Search Job">
            <span class="icon is-small is-left">
                <i class="fas fa-search"></i>
            </span>
        </p>
    </div>
</div>
<?php

echo $modal;

$company = Company::getCompanyByUserId($userid);
$jobs = Job::getAllJobsByCompany($company->company_id);
foreach ($jobs as $job) {
	$applicants = Job::getAllAplicantsforJobNotRejected($job[0]);
	$cnttop = 2;
	$cntbot = 1;
	?>
    <ul class="row" id="treeView">
        <li class="parent">
            <div class="column caret">
                <div class="card">
                    <header class="card-header">
                            <p class="card-header-title">
                                <span class="triangle"></span><?php echo $job[1] ?>
                            </p>
                            <div class="like">
                                <?php echo  count($applicants).' Applicants'?>
                            </div>
                    </header>
                </div>
            </div>
			<?php
			foreach ($applicants as $applicant) {

				$profile_pic = File::getFile($applicant['user_id'], "Profile Picture");
				if (is_null($profile_pic)) {
					$profile_pic_path = "/website/source/img/user-icon.png";
				} else {
					$profile_pic_path = '/website/uplfiles/' . $applicant['user_id'] . "/" . $profile_pic["name"];
				}

			$address = Address::getAddressbyUserId($applicant['user_id']);
			$modal_applicant = Applicant::getApplicantByUserId($applicant['user_id']);
			$applicant_education = $modal_applicant->getEducation();
			$files = File::getAllFilesByApplication($applicant['application_id']);
			?>
            <div id=<?php echo 'modal-js-example-info'.$applicant['application_id']; ?> class="modal">
                <div class="modal-background"></div>
                <div class="modal-content">
                    <div class="box">
                        <div class="header">
                            <div class="row">
                                <div class="column">
                                    <figure class="image is-64x64">
                                        <img class="is-rounded" src=<?php echo $profile_pic_path;?>>
                                    </figure>
                                </div>
                            </div>
                            <b><h6><b>Name: </b><?php echo $modal_applicant->firstname.' '.$modal_applicant->lastname; ?></h6></b>
                        </div>
                        <div>
                            <b>State: </b><?php echo $address['state']; ?>
                        </div>
                        <div>
                            <b>City: </b><?php echo $address['city']; ?>
                        </div>
                        <div>
                            <b>Birthday: </b><?php echo $modal_applicant->birthdate; ?>
                        </div>
						<?php
						if (!is_null($applicant_education)){
							?>
                            <div>
                                <b>Highest Degree: </b><?php echo $applicant_education['name']; ?>
                            </div>
							<?php
						}
                        if (!is_null($applicant['applicationtext'])){
						?>
                        <hr>
                        <div class="content">
                            <p><?php echo $applicant['applicationtext']; ?></p>
                        </div>
                        <?php } ?>
                        <hr>
                        <div class="columns">
                            <div class="column is-one-fifth">
                                <b>Files:</b>
                            </div>
                            <div class="column">
                                <ul>
									<?php foreach ($files as $file) {
										echo '<li><a href='.$profile_pic_path.' download>'.$file['name'].'</a></li>';
									}
									?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="modal-close is-large" aria-label="close"></button>
            </div>

            <?php
				if ($cnttop < 2){
					$cnttop++;
				}
				else{
					$cnttop = 1;
					?>
                    <ul class="row nested <?php echo isset($_POST['job_id']) ? 'active' : '';?>">
					<?php
				}
				?>
                <div class="column">
                    <div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <figure class="image is-48x48">
                                        <img class="is-rounded" src="<?php echo $profile_pic_path;?>" alt="Placeholder image">
                                    </figure>
                                </div>
                                <div class="media-content">
                                    <p class="title is-4"><?php echo $applicant['firstname'].' '.$applicant['lastname']; ?></p>
                                    <p class="subtitle is-6"><?php echo $applicant_education['name']; ?></p>
                                </div>
                            </div>
                            <div class="content" style="float: right">
                                <form method="post">
                                    <div class="select is-rounded">
                                        <select name="applicationstatus"  <?php
                                        switch ($applicant['status']){
                                            case 1:
                                                echo 'style="background-color: #6699cc"';
                                                break;
                                            case 2:
                                                echo 'style="background-color: #ffcc66"';
                                                break;
                                            case 3:
                                                echo 'style="background-color: #cc9999"';
                                                break;
                                            case 4:
                                                echo 'style="background-color: #99cc99"';
                                                break;
                                        }
                                        ?>  onchange="this.form.submit()">
                                            <option value="1" style="background-color: #6699cc" <?php echo $applicant['status'] == 1 ? 'selected': '';?>>New</option>
                                            <option value="2" style="background-color: #ffcc66" <?php echo $applicant['status'] == 2 ? 'selected': '';?>>In Progress</option>
                                            <option value="3" style="background-color: #cc9999" <?php echo $applicant['status'] == 3 ? 'selected': '';?>>Rejected</option>
                                            <option value="4" style="background-color: #99cc99" <?php echo $applicant['status'] == 4 ? 'selected': '';?>>Accepted</option>
                                        </select>
                                        <input type="text" name="application_id" hidden value=<?php echo $applicant['application_id'];?>>
                                        <input type="text" name="job_id" hidden value=<?php echo $job['job_id'];?>>
                                        <input type="text" name="curr_status" hidden value=<?php echo $applicant['status'];?>>
                                    </div>
                                    <button type="button" class="button is-outlined-light is-rounded js-modal-trigger" data-target=<?php echo 'modal-js-example-info'.$applicant['application_id']; ?>>
                                        <span class="icon is-small">
                                            <i class="fas fa-info"></i>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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

<script src="../../source/js/searchbar.js"></script>
<script src="../../source/js/treeView.js"></script>
<script src="../../source/js/modal.js"></script>