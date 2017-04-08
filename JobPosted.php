<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/JobController.php';
$jobController = new JobController();

$epr='';
$title = "Job Posted";
$content = "";

$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = "";
if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log = "Home.php";
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

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='view')
{
    $userId = $_GET['id'];
    $content = $jobController->JobPostedContent($userId);
    $content.= $jobController->SendMessageFromUserJobPostedModal($userId);
    $sidebar = $jobController->ViewUserProfileSideBar($userId);
}

if (isset($_POST['sendMessage']) && !empty($_POST['messages'])) 
{   
    require 'Model/MessagesModel.php';
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        $MessagesModel = new MessagesModel();
        // Store the message in the database
        $MessagesModel->SendAMessage($_SESSION['username'], $_SESSION['SendUsername'], $_POST['messages'], $dateTime);
        
        $errorMessage = "Message Sent :)";

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