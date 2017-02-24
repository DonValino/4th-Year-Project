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

$epr='';

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

// An Array to store all error messages
$errors = array();

$title = "Edit Job";
$content = "";

$errorMessage = "";
$sidebar = $jobController->CreateJobOverviewSidebar();


$id = 0;
if($epr == 'update')
{
    $id = $min =$_GET['id'];
    $content = $jobController->EditANewJobForm($id);
}
else if($epr == 'delete')
{
    $id = $min =$_GET['id'];
    $content = $jobController->EditANewJobForm($id);
}

//Code to Insert a new job
//First Check to ensure all fields are not empty
if (isset($_POST['EditJobSubmit']) && !empty($_POST['name']) && !empty($_POST['description'])
        && !empty($_POST['typeId']) && !empty($_POST['qualificationId']) && !empty($_POST['address']) && !empty($_POST['county'])
        && !empty($_POST['numberOfDays']) && !empty($_POST['numberOfPeopleRequired']) && !empty($_POST['startDateUpdate']) && !empty($_POST['price'])) 
{
    if(!is_numeric($_POST['price']))
    {
        // Create Error Messages if phone is not in correct format
        $errorMessage = "* Error!! Phone Numbers Must only be numbers.";
    }else
    {
        // Edit Job to the Database
        $jobController->updateJob($_POST['name'], $_POST['description'], $_POST['typeId'], $_POST['qualificationId'], $_POST['address'],$_POST['county'], $_POST['numberOfDays'], $_POST['numberOfPeopleRequired'], $_POST['price'], $id,$_POST['startDateUpdate']);
        header('Location: Home.php');
    }
}
 
 include 'Template.php'
 ?>

