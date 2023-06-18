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

$jobtitle = null;
$salaryfrom = null;
$salaryto = null;
$companyname = null;
$cityname = null;

if (!isset($_SESSION["current_user_id"]))
{
    $userid = 1;
}

if (isset($_POST['favorite'])){

}

if (isset($_POST['filter'])){
    if (isset($_POST['jobtitle'])){
        $jobtitle = '%'.$_POST['jobtitle'].'%';
    }
    if (isset($_POST['salaryfrom'])){
        $salaryfrom = '%'.$_POST['salaryfrom'].'%';
    }
    if (isset($_POST['salaryto'])){
        $salaryto = '%'.$_POST['salaryto'].'%';
    }
    if (isset($_POST['companyname'])){
        $companyname = '%'.$_POST['companyname'].'%';
    }
    if (isset($_POST['cityname'])){
        $cityname = '%'.$_POST['cityname'].'%';
    }
}

$db = new DB();
$filter = $db->pdo->prepare('select   j.title title,
                                            j.description description,
                                            j.job_id job_id,
                                            case when 1 = (select 1 
                                                             from Favorite 
                                                            where applicant_id = :userid 
                                                              and job_id = j.job_id)
                                                 then 1
                                                 else 0 end favorite
                                       from Job j,
                                            Job_Industry ji,
                                            Company c,
                                            Address a,
                                            City_Postalcode cp,
                                            City ci,
                                            Industry i
                                      where j.job_id = ji.job_id
                                        and ji.industry_id = i.industry_id
                                        and j.company_id = c.company_id
                                        and c.address_id = a.address_id
                                        and a.city_postalcode_id = cp.city_postalcode_id
                                        and cp.city_id = ci.city_id
                                        and (lower(j.title) like :jobtitle or :jobtitle is null)
                                        and (j.salary between :salaryfrom and :salaryfrom or :salaryfrom is null)
                                        and (lower(c.name) like :companyname or :companyname is null)
                                        and (lower(ci.city) like :cityname or :cityname is null)');
$filter->bindParam('userid', $userid,PDO::PARAM_INT);
$filter->bindParam('jobtitle', $jobtitle);
$filter->bindParam('salaryfrom', $salaryfrom, PDO::PARAM_INT);
$filter->bindParam('salaryto', $salaryto,PDO::PARAM_INT);
$filter->bindParam('companyname', $companyname);
$filter->bindParam('cityname', $cityname);
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
                                    <button type="submit" name="favorite" value=1 style="background: transparent; border: transparent">
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