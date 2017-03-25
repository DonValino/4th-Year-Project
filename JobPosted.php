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
 
 include 'Template.php'
 ?>