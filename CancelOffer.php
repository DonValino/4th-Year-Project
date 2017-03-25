<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/CancelRequestController.php';

$cancelRequestController = new CancelRequestController();


$loginStatus= "Login";
$log = "";

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
         header('Location: Home.php');
    }
}

$epr='';
$title = "home";
$content = $cancelRequestController->CancelRequestForm();

$errorMessage = "";
$sidebar = $cancelRequestController->CancelRequestSideBarForm();

$userIdd = 0;
$jobIdd = 0;
if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='cancelOffer')
{
    $userIdd =$_GET['userId'];
    $jobIdd =$_GET['jobId'];
}

if(isset($_POST['submitCancellationRequest']) && !empty($_POST['reason']))
{
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
    $cancelRequestController->InsertANewCancelRequest($_SESSION['id'], $userIdd, $jobIdd, $_POST['reason'], $dateTime, 0);
    
   //Go to ViewJob Page
    header('Location: ViewJob.php?epr=viewJobCancellationOffer&jobid='.$_SESSION['jobId']);
}


 
 include 'Template.php'
 ?>

