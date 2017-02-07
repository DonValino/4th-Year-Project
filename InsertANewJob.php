<?php
session_start();
 
require 'Controller/JobController.php';
$jobController = new JobController();

// An Array to store all error messages
$errors = array();

$title = "Upload Job";
$content = $jobController->InsertANewJobForm();

$loginStatus= "";
$log = "";
$errorMessage = "";
$sidebar = $jobController->CreateJobOverviewSidebar();
if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
}

//Code to Insert a new job
//First Check to ensure all fields are not empty
if (isset($_POST['insertANewJob']) && !empty($_POST['name']) && !empty($_POST['description'])
        && !empty($_POST['typeId']) && !empty($_POST['qualificationId']) && !empty($_POST['address']) && !empty($_POST['county'])
        && !empty($_POST['numberOfDays']) && !empty($_POST['numberOfPeopleRequired']) && !empty($_POST['price'])) 
{
    if(!is_numeric($_POST['price']))
    {
        // Create Error Messages if phone is not in correct format
        $errorMessage = "* Error!! Phone Numbers Must only be numbers.";
    }else
    {
        // Insert new User to the Database
        $jobController->InsertAJob($_SESSION['id']);
        $jobid = $jobController->GetLastpostedJobs()->jobid;
        // Add a timeline event
        header('Location: AddTimelineEvent.php?epr=add&jobid='.$jobid);
    }
}
 
 include 'Template.php'
 ?>