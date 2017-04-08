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
        // Go Back To Home Page
         header('Location: Home.php');
    }
}

$epr='';
$title = "home";
$content = $cancelRequestController->CancelRequestInfoContent();
$errorMessage = "";
$sidebar = $cancelRequestController->CancelRequestSideBar();

$userIdd = 0;
$jobIdd = 0;
if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='accept')
{
    require_once 'Model/UserModel.php';
    require_once 'Model/PlacedOffersModel.php';
    
    $userIdd =$_GET['userId'];
    $jobIdd =$_GET['jobId'];
    
    $userModel = new UserModel();
    $placedModel = new PlacedOffersModel();
    
    $tousername = $userModel->GetUserById($userIdd)->username;
    
    $cancelRequestController->updateCancelSeen(1, $userIdd, $_SESSION['id'], $jobIdd);
    $cancelRequestController->updateCancelRequestStatus(2, $userIdd, $_SESSION['id'], $jobIdd);
    
    $placedModel->deleteAnOffer($jobIdd, $_SESSION['id']);
    
    header('Location: Notification.php?epr=CancellationOfferAccepted&tousername='.$tousername.'&jobId='.$jobIdd);
    
}

if($epr=='NotificationSentAccepted')
{
    $errorMessage = "Cancellation Request Accepted. Your offer is now cancelled :)";
}

if($epr=='denied')
{
    require_once 'Model/UserModel.php';
    require_once 'Model/PlacedOffersModel.php';
    
    $userIdd =$_GET['userId'];
    $jobIdd =$_GET['jobId'];
    
    $userModel = new UserModel();
    $placedModel = new PlacedOffersModel();
    
    $_SESSION['tousername'] = $tousername = $userModel->GetUserById($userIdd)->username;
    $_SESSION['tagetuserId'] = $userIdd;
    $cancelRequestController->updateCancelSeen(1, $userIdd, $_SESSION['id'], $jobIdd);
    $cancelRequestController->updateCancelRequestStatus(0, $userIdd, $_SESSION['id'], $jobIdd);
    
    header('Location: Notification.php?epr=CancellationOfferDenied&tousername='.$tousername.'&jobId='.$jobIdd);
}

if($epr=='NotificationSentDenied')
{
    $content = $cancelRequestController->CancelRequestInfoContent();
    $content.= $cancelRequestController->SendMessageModal($_SESSION['tagetuserId']);
    $errorMessage = "<p style='color:blue'>You Have Denied <strong style='color:green;'>".$_SESSION['tousername']."'s</strong> Request To Cancel Your Offer.</p><p style='color:blue'> Send Him A Message To State The Reason.</p>"
            . "<a href='#' data-toggle='modal' class='btn btn-success btn-sm' data-target='#sendMessageModal' onclick='$(#sendMessageModal).modal({backdrop: static});'>
                    Message </a>";
}

if (isset($_POST['sendMessage']) && !empty($_POST['messages'])) 
{
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        require_once 'Model/MessagesModel.php';
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

