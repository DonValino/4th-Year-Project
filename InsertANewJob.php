<?php
session_start();
 
require 'Controller/JobController.php';
$jobController = new JobController();

$loginStatus= "";
$log = "";
if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
}else
{
    header('Location: index.php');
}

// An Array to store all error messages
$errors = array();

$title = "Upload Job";
$content = $jobController->InsertANewJobForm();

$errorMessage = "";
$sidebar = $jobController->CreateJobOverviewSidebar();

$epr='';
if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'paymentCompleted')
{
        $jobid =$_GET['jobid'];
        $name =$_GET['name'];
        $description =$_GET['description'];
        $typeId =$_GET['typeId'];
        $qualificationId =$_GET['qualificationId'];
        $address =$_GET['address'];
        $county =$_GET['county'];
        $numberOfDays =$_GET['numberOfDays'];
        $numberOfPeopleRequired =$_GET['numberOfPeopleRequired'];
        $startDate =$_GET['startDate'];
        $price =$_GET['price'];
        $userid =$_GET['userid'];
        $adType = $_SESSION['adType'];
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $jobController->InsertANewJobPaymentCompleted($name, $description, $typeId, $qualificationId, $address, $county, $numberOfDays, $numberOfPeopleRequired, $price, 1, $userid, $dateTime, $startDate, $adType);
        
        // Add a timeline event
        header('Location: AddTimelineEvent.php?epr=add&jobid='.$jobid);
}

//Code to Insert a new job
//First Check to ensure all fields are not empty
if (isset($_POST['insertANewJob']) && !empty($_POST['name']) && !empty($_POST['description'])
        && !empty($_POST['typeId']) && !empty($_POST['qualificationId']) && !empty($_POST['address']) && !empty($_POST['county'])
        && !empty($_POST['numberOfDays']) && !empty($_POST['numberOfPeopleRequired']) && !empty($_POST['startDate']) && !empty($_POST['price'])) 
{
    if(!is_numeric($_POST['price']))
    {
        // Create Error Messages if phone is not in correct format
        $errorMessage = "* Error!! Phone Numbers Must only be numbers.";
    }else
    {
        // Insert new User to the Database
        //$jobController->InsertAJob($_SESSION['id']);
        $jobid = $jobController->GetLastpostedJobs()->jobid;
        $userId = $jobController->GetLastpostedJobs()->id;
        // Add a timeline event
        //header('Location: AddTimelineEvent.php?epr=add&jobid='.$jobid);
        
        if($_POST['adType'] == 0)
        {
            // Standard Job Advertisement
            header('Location: StandardAdPayment.php?epr=pay&jobid='.$jobid.'&name='.$_POST['name'].'&description='.$_POST['description'].'&typeId='.$_POST['typeId'].'&qualificationId='.$_POST['qualificationId'].'&address='.$_POST['address']
                .'&county='.$_POST['county'].'&numberOfDays='.$_POST['numberOfDays'].'&numberOfPeopleRequired='.$_POST['numberOfPeopleRequired'].'&startDate='.$_POST['startDate'].'&price='.$_POST['price'].'&userid='.$userId);
            $_SESSION['adType'] = 0;
        }else if($_POST['adType'] == 1)
        {
            $_SESSION['adType'] = 1;
            // Featured Job Advertisement
            header('Location: FeaturedAdPayment.php?epr=pay&jobid='.$jobid.'&name='.$_POST['name'].'&description='.$_POST['description'].'&typeId='.$_POST['typeId'].'&qualificationId='.$_POST['qualificationId'].'&address='.$_POST['address']
                .'&county='.$_POST['county'].'&numberOfDays='.$_POST['numberOfDays'].'&numberOfPeopleRequired='.$_POST['numberOfPeopleRequired'].'&startDate='.$_POST['startDate'].'&price='.$_POST['price'].'&userid='.$userId);
        }

    }
}
 
 include 'Template.php'
 ?>