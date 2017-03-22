<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/PaymentController.php';

$paymentController = new PaymentController();

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
$title = "Payment Confirmation";
$content = $paymentController->PaymentConfirmationContent();

$errorMessage = "";
$sidebar = $paymentController->CreatePaymentSidebar();


if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='confirm')
{
    $userId=$_GET['userId'];
    $jobId=$_GET['jobId'];
    
    // User Has Confirmed They Have Recieved The Payment
    $paymentController->updatePaymentConfirmation(2, $_SESSION['id'], $userId, $jobId);
    
    require_once 'Model/NotificationModel.php';
    $notificationModel = new NotificationModel();
    
    require_once 'Model/UserModel.php';
    $userModel = new UserModel();
    
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
    
    // Send Notification that the user has received their payments
    $fromusername = $userModel->GetUserById($_SESSION['id'])->username;
    $tousername = $userModel->GetUserById($userId)->username;
    $notificationModel->InsertNotification($fromusername, $tousername, 11, 0, $dateTime, $jobId);
    
    header("Location: PaymentConfirmation.php");
}

 
 include 'Template.php'
 ?>

