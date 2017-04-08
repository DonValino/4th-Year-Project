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

$content = $reportController->InsertANewReportForm();

$errorMessage = "";
$sidebar = $reportController->CreateUserProfileSidebar();

if(isset($_POST['submitReport']) && !empty($_POST['description']) && !empty($_POST['typeId']))
{
    //Today's date
    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');
        
    $reportController->InsertANewReport($_SESSION['id'], $_POST['description'], $_POST['typeId'], $dateTime, 0, 1);
   
    header('Location: SubmitAReport.php?epr=submitted');
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='submitted')
{
    $errorMessage="<p style='color:green;font-size:22px;'>Report Submitted :)</p>";
}

if($epr=='AdminCat')
{
    $id =$_GET['id'];
    $_SESSION['search'] = $id;
    
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=AdminCat');
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

