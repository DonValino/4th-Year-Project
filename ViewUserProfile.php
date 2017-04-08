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
   $log ="Home.php";
}else
{
    header('Location: index.php');
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

if($epr=='viewAndSetBidSeen')
{
    $userId =$_GET['id'];
    $jobId =$_GET['jobId'];
    
    header('Location: PlaceOffer.php?epr=update&userId='.$userId.'&jobId='.$jobId);
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

