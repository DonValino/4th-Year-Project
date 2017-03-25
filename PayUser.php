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
$title = "Payment Option";
$content = "";

$errorMessage = "";
$sidebar = $jobController->ViewJobDetailsOfYourJobSideBar();

if(isset($_POST['confirmAmounToPay']))
{
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
    // Insert A New Payment Confirmation Request For The Target User
    require_once 'Model/PaymentModel.php';
    $paymentModel = new PaymentModel();
    
    $paymentExist = $paymentModel->GetPayPalMeAccountByUserIdAndJobId($_SESSION['payPalUserId'], $_SESSION['jobId']);
    if($paymentExist == NULL)
    {
         $paymentModel->InsertANewPayment($_SESSION['id'], $_SESSION['payPalUserId'], $_SESSION['jobId'], $_SESSION['paymentTotal'], $dateTime, 0, 1,0);
    }else if($paymentExist != NULL && $paymentExist->status == 0)
    {
        //$paymentModel->updatePaymentConfirmation($_SESSION['payPalUserId'], $_SESSION['jobId']);
    }

    
    require_once 'Model/PayPalMeModel.php';
    $payPalMeModel = new PayPalMeModel();
    
    $url = $payPalMeModel->GetPayPalMeAccountByUserId($_SESSION['payPalUserId'])->payPalMeUrl;

    //Go to Search Result Page"
   header('Location: https://'.$url.'/send?amount='.$_SESSION[paymentTotal].'&currencyCode=EUR&locale.x=en_US&country.x=IE');
}

if(isset($_POST['confirmCashAmounToPay']))
{

        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
    // Insert A New Payment Confirmation Request For The Target User
    require_once 'Model/PaymentModel.php';
    $paymentModel = new PaymentModel();
    
    $paymentExist = $paymentModel->GetPayPalMeAccountByUserIdAndJobId($_SESSION['payPalUserId'], $_SESSION['jobId']);
    if($paymentExist == NULL)
    {
         $paymentModel->InsertANewPayment($_SESSION['id'], $_SESSION['payPalUserId'], $_SESSION['jobId'], $_SESSION['paymentTotal'], $dateTime, 1, 1,0);
    }

    //Go to Search Result Page"
   header('Location: ViewJob.php?epr=cashpaymentnotification');
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='pay')
{
    require_once 'Controller/PayPalMeController.php';
    $payPalMeController = new PayPalMeController();
    $userId=$_GET['userId'];
    $_SESSION['payPalUserId'] = $userId;
    $content = $payPalMeController->CreatePaymentContent($userId);
    $content .= $payPalMeController->PaymentConfirmationModal($userId);
    $content .= $payPalMeController->PaymentConfirmationModalCash($userId);
}

 
 include 'Template.php'
 ?>

