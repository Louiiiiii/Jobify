<?php
session_start();
if (isset($_POST['jobinfo'])){
    $_SESSION['currjob_id'] = $_POST['jobinfo'];
	unset($_SESSION['alreadyapplied']);
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
    <link rel="stylesheet" href="/website/source/css/alert.css">
    <link rel="stylesheet" href="https://bulma.io/vendor/fontawesome-free-5.15.2-web/css/all.min.css">
    <script src="../../source/js/favourites.js"></script>
</head>
<body>
<?php
include '../parts/applicant_navbar.php';
require_once '../parts/applicant_filters.php';
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

    if ($_POST['companyname'] != "--All--"){
        $companyname = '%'.$_POST['companyname'].'%';
    }

    if ($_POST['cityname'] != null){
        $cityname = '%'.$_POST['cityname'].'%';
    }

    if ($_POST['industry'] != "--All--"){
        $industry = '%'.$_POST['industry'].'%';
    }
}
$applicant = Applicant::getApplicantByUserId($userid);
$db = new DB();
$filter = $db->pdo->prepare('select  distinct(j.job_id),
                                            j.title title,
                                            j.description description,
                                            j.job_id job_id,
                                            case when 1 = (select 1 
                                                             from Favorite 
                                                            where applicant_id = :applicant
                                                              and job_id = j.job_id)
                                                 then 1
                                                 else 0 end favorite 
                                      from Job j,
                                           Company c,
                                           Address ad,
                                           City_Postalcode cp,
                                           City ci,
                                           Job_Industry ji,
                                           Industry i
                                     where j.company_id = c.company_id
                                       and c.address_id = ad.address_id
                                       and ad.city_postalcode_id = cp.city_postalcode_id
                                       and cp.city_id = ci.city_id
                                       and j.job_id = ji.job_id
                                       and i.industry_id = ji.industry_id
                                       and not exists(select * 
                                                        from Application a 
                                                       where j.job_id = a.job_id 
                                                         and a.applicant_id = :applicant)
                                       and (lower(j.title) like lower(:jobtitle) or :jobtitle is null)
                                       and (j.salary >= :salaryfrom or :salaryfrom is null or :salaryfrom = 0)
                                       and (j.salary <= :salaryto or :salaryto is null or :salaryto = 0)
                                       and (lower(c.name) like lower(:companyname) or :companyname is null)
                                       and (lower(ci.city) like lower(:cityname) or :cityname is null)
                                       and (lower(i.name) like lower(:industry) or :industry is null)');
$filter->bindParam('applicant', $applicant->applicant_id,PDO::PARAM_INT);
$filter->bindParam('jobtitle', $jobtitle);
$filter->bindParam('salaryfrom', $salaryfrom, PDO::PARAM_INT);
$filter->bindParam('salaryto', $salaryto,PDO::PARAM_INT);
$filter->bindParam('companyname', $companyname);
$filter->bindParam('cityname', $cityname);
$filter->bindParam('industry', $industry);
$filter->execute();
?>
<div class="row">
    <div class="column">
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <?php
                    echo $filter->rowCount().' jobs currently available';
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
                                    <button type="submit" name="favorite" value=<?php echo $res['job_id'] ?> style="background:transparent;border:transparent">
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
                                    echo $res['description']
                                    ?>
                                </div>
                                <div class="info-row">
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