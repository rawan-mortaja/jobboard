<?php
require "../includes/header.php";
require "../config/config.php";



if (!isset($_SESSION['type']) and $_SESSION['type'] !== 'Worker') {

    header("location: " . APPURL . "");
}


if (isset($_GET['id'])) {

    $id = $_GET['id'];


    if ($_SESSION['id'] !== $id) {

        header("location: " . APPURL . "");
    }


    $select = $conn->query("SELECT * FROM users WHERE id = '$id'");
    $select->execute();
    $profile = $select->fetch(PDO::FETCH_OBJ);

    $applied_jobs = $conn->prepare("SELECT jobs.id AS id , jobs.company_image AS company_image , jobs.company_name 
    AS company_name , jobs.job_region As job_region , jobs.job_type AS job_type ,jobs.job_title AS job_title
     FROM jobs JOIN job_applications ON jobs.id = job_applications.job_id WHERE worker_id ='$id'");
    $applied_jobs->execute();

    $jobs = $applied_jobs->fetchAll(PDO::FETCH_OBJ);
}










?>
<!-- HOME -->
<section class="section-hero overlay inner-page bg-image" style="background-image: url('<?php echo APPURL; ?>/images/hero_1.jpg');" id="home-section">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1 class="text-white font-weight-bold"><?PHP echo $profile->username;  ?></h1>
                <div class="custom-breadcrumbs">
                    <a href="<?php echo APPURL; ?>">Home</a> <span class="mx-2 slash">/</span>
                    <span class="text-white"><strong><?PHP echo $profile->username;  ?></strong></span>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="site-section">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-7 text-center">
                <h2 class="section-title mb-2">Applied Jobs </h2>
            </div>
        </div>

        <ul class="job-listings mb-5">
            <?PHP foreach ($jobs as $oneJob) : ?>
                <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center">
                    <a href="<?PHP echo APPURL; ?>/jobs/job-single.php?id=<?PHP echo $oneJob->id; ?>"></a>
                    <div class="job-listing-logo">
                        <img src="../users/user-images/<?PHP echo $oneJob->company_image; ?>" alt="Free Website Template by Free-Template.co" class="img-fluid">
                    </div>

                    <div class="job-listing-about d-sm-flex custom-width w-100 justify-content-between mx-4">
                        <div class="job-listing-position custom-width w-50 mb-3 mb-sm-0">
                            <h2><?PHP echo $oneJob->job_title; ?></h2>
                            <strong><?PHP echo $oneJob->company_name; ?></strong>
                        </div>
                        <div class="job-listing-location mb-3 mb-sm-0 custom-width w-25">
                            <span class="icon-room"></span> <?PHP echo $oneJob->job_region ?>
                        </div>
                        <div class="job-listing-meta">
                            <span class="badge badge-<?PHP if ($oneJob->job_type == 'Part Time') {
                                                            echo 'danger';
                                                        } else {
                                                            echo 'success';
                                                        } ?>"><?PHP echo $oneJob->job_type; ?></span>
                        </div>
                    </div>

                </li>
                <br>
            <?PHP endforeach; ?>
        </ul>
    </div>
</section>
<?PHP
require "../includes/footer.php";

?>