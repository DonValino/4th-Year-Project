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

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        // Go Back To Home Page
         header('Location: Home.php');
    }
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
        $name = htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8");
        $description = htmlspecialchars($_POST['description'], ENT_QUOTES, "UTF-8");
        $address = htmlspecialchars($_POST['address'], ENT_QUOTES, "UTF-8");
            
        // Edit Job to the Database
        $jobController->updateJob($name, $description, $_POST['typeId'], $_POST['qualificationId'], $address,$_POST['county'], $_POST['numberOfDays'], $_POST['numberOfPeopleRequired'], $_POST['price'], $id,$_POST['startDateUpdate']);
        header('Location: Home.php');
    }
}
 

if(isset($_SESSION['active']))
{
    if ($_SESSION['active'] == 0)
    {
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        $adminusers = $userModel->GetActiveUsers();
        $content = "<p style='color:blue;font-size:18px;text-align:center;'>Your account has been deactivated. Please Contact one of the listed administrator: </p>";
        
        if ($adminusers != null)
        {
            foreach($adminusers as $row)
            {
                if($row->admin == 1)
                {
                    $log = "Logout.php";
                    $loginStatus = "Logout";
                    $sidebar = "";
                    $content .= "<p style='color:green;font-size:18px;text-align:center;'>$row->email</p>";
                }
            }
        }
        
    }
}
 include 'Template.php'
 ?>

