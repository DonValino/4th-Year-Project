<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/UserController.php';
require 'Model/MessagesModel.php';
require 'Model/RequestModel.php';
$userController = new UserController();

$MessagesModel = new MessagesModel();

$epr='';
$title = "Profile";
$content = "";


$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = "";
if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log ="home.php";
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='view')
{
    $userId =$_GET['id'];
    $content = $userController->ViewUserProfile($userId);
    $content.= $userController->SendMessageModal($userId);
    $sidebar = $userController->ViewUserProfileSideBar($userId);
}

if($epr=='cancelRequest')
{
    $userId =$_GET['id'];
    
    $requestModel = new RequestModel();
    $exist = $requestModel->GetCVCoverLetterRequestsByUserIdANDTargetUserId($_SESSION['id'], $userId);
    
    if($exist != NULL)
    {
        $requestModel->cancelRequest($_SESSION['id'], $userId);
    }

    $content = $userController->ViewUserProfile($userId);
    $content.= $userController->SendMessageModal($userId);
    $sidebar = $userController->ViewUserProfileSideBar($userId);
}

if($epr=='request')
{
    $userId =$_GET['id'];
    $requestModel = new RequestModel();
    $exist = $requestModel->GetCVCoverLetterRequestsByUserIdANDTargetUserId($_SESSION['id'], $userId);
    if($exist == NULL)
    {
        //Today's date
        $date = new DateTime();
        $dateFormated = $date->format('Y-m-d H:i:s.u');
        
        $requestModel = new RequestModel();
        $requestModel->InsertANewRequest($_SESSION['id'], $userId, 1, $dateFormated, 1); 
    }
    
    $content = $userController->ViewUserProfile($userId);
    $content.= $userController->SendMessageModal($userId);
    $sidebar = $userController->ViewUserProfileSideBar($userId);
}

if (isset($_POST['sendMessage']) && !empty($_POST['messages'])) 
{
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        // Store the message in the database
        $MessagesModel->SendAMessage($_SESSION['username'], $_SESSION['SendUsername'], $_POST['messages'], $dateTime);
        
        $errorMessage = "Message Sent :)";

}
 
 include 'Template.php'
 ?>

