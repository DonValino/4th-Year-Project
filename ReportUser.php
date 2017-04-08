<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/ReportController.php';
$reportController = new ReportController();

$loginStatus= "Login";
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
$title = "Submit A Report";

$content = "";

$errorMessage = "";
$sidebar = $reportController->CreateUserProfileSidebar();

if(isset($_POST['submitReport']) && !empty($_POST['description']))
{
    //Today's date
    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');
    require_once 'Model/UserModel.php';
    $userModel = new UserModel();
    $user = $userModel->GetUserById($_SESSION['userReportUserId']);
    $description = "User: ".$user->firstName.", ".$user->lastName." ".$_POST['description'];
        
    $reportController->InsertANewReport($_SESSION['id'], $description, 2, $dateTime, 0, 1);
   
    header('Location: ReportUser.php?epr=submitted');
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='submitted')
{
    $errorMessage="<p style='color:green;font-size:22px;'>Report Submitted :)</p>";
    $content = $reportController->InsertANewUserReportForm($_SESSION['userReportUserId']);
}

if($epr=='reportuser')
{
    $_SESSION['userReportUserId'] =$_GET['id'];
    $content = $reportController->InsertANewUserReportForm($_SESSION['userReportUserId']);
}

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        $log = "AccountSettings.php";
    }
}
 
 include 'Template.php'
 ?>

