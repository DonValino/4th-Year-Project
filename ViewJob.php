<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require 'Controller/JobController.php';
require 'Model/MessagesModel.php';

session_start();

$jobController = new JobController();

$MessagesModel = new MessagesModel();
$epr='';
$title = "View Job";
$content = "";

$loginStatus= "Login";
$log = "";
$errorMessage = "";

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'view')
{
    $_SESSION['jobId'] = $_GET['jobid'];
    $content = $jobController->ViewJobDetails($_SESSION['jobId']);
    $content .= $jobController->PlaceAnOfferModal();
    $content .= $jobController->UpdateAnOfferModal();
}

if($epr == 'viewfromnotification')
{
    header('Location: updateNotification.php?epr=updateNofication&jobid='.$_GET['jobid'].'&date='.$_GET['date']); 
}

$userobjectForChecking = $jobController->GetUserByJobId($_SESSION['jobId']);

if($userobjectForChecking->username != $_SESSION['username'])
{
    $sidebar = $jobController->ViewJobDetailsSideBar($_SESSION['jobId']);
}  else {
    $sidebar= $jobController->ViewJobDetailsOfYourJobSideBar();
}


if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log ="home.php";
   $content = $jobController->ViewJobDetails($_SESSION['jobId']);
   $content .= $jobController->PlaceAnOfferModal();
   $content .= $jobController->UpdateAnOfferModal();
}

$content .= $jobController->SendMessageModal($_SESSION['jobId']);

if (isset($_POST['sendMessage']) && !empty($_POST['messages'])) 
{
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        // Store the message in the database
        $MessagesModel->SendAMessage($_SESSION['username'], $_SESSION['SendUsername'], $_POST['messages'], $dateTime);
        
        $errorMessage = "Message Sent :)";

}

if($epr == 'offerPlaced')
{
    $errorMessage="Thanks, Offer Placed!!";
}

if($epr == 'offerUpdated')
{
    $errorMessage="Thanks, Offer Updated!!";
}
    
//Code to place an offer
//First Check to ensure all fields are not empty
if (isset($_POST['placeOfferFB']) && !empty($_POST['offerPrice']) && !empty($_POST['comment'])) 
{
    if(!is_numeric($_POST['offerPrice']))
    {
        $errorMessage="Error: Price Must Be Numberic!!";
    }else
    {
        $userId = $_SESSION['id'];

        $tousername = $jobController->GetUserByJobId($_SESSION['jobId'])->username;
        header('Location: placeOffer.php?epr=placedFB&userId='.$userId.'&comment='.$_POST['comment'].'&offerprice='.$_POST['offerPrice'].'&tousername='.$tousername);
    }

}

if (isset($_POST['placeOfferPB']) && !empty($_POST['offerPrice']) && !empty($_POST['comment']) && !empty($_POST['numberOfDays']) && !empty($_POST['prefferedCommenceDate'])) 
{
    if(!is_numeric($_POST['offerPrice']))
    {
        $errorMessage="Error: Price Must Be Numberic!!";
    }else
    {
        $userId = $_SESSION['id'];

        $prefferedCommenceDate = $_POST['prefferedCommenceDate'];

        // Last Dat of User
        $time = strtotime($prefferedCommenceDate);
        $dateFinished = new DateTime(date('Y-m-d',$time));
        $dateFinished->modify('+'.$_POST['numberOfDays'].' day');

        // Start Of Job
        $dateOfJob = "2017-02-1";
        // End Of Job
        $dateEnd ="2017-02-3";


        if(strtotime($prefferedCommenceDate) <= strtotime($dateEnd) && strtotime($prefferedCommenceDate) >= strtotime($dateOfJob) && (strtotime($dateFinished->format('Y-m-d H:i:s'))) <= (strtotime($dateEnd)))
        {
            $tousername = $jobController->GetUserByJobId($_SESSION['jobId'])->username;
            header('Location: placeOffer.php?epr=placedPB&userId='.$userId.'&comment='.$_POST['comment'].'&offerprice='.$_POST['offerPrice'].'&tousername='.$tousername.'&numberOfDays='.$_POST['numberOfDays'].'&prefferedCommenceDate='.$prefferedCommenceDate);
        }else if(strtotime($prefferedCommenceDate) <= strtotime($dateEnd) && strtotime($prefferedCommenceDate) < strtotime($dateOfJob) && (strtotime($dateFinished->format('Y-m-d H:i:s'))) <= (strtotime($dateEnd)))
        {
            $errorMessage= 'Error: Preferred Commence Date is before the start date of the job';
        }else
        {
            $errorMessage= 'Error: You must allow enough days between your preferred commence date and the number of days you want to work';
        }

    }
}
    

//Code to update an offer
//First Check to ensure all fields are not empty
if (isset($_POST['updateOffer']) && !empty($_POST['updateOfferPrice']) && !empty($_POST['updateComment'])) 
{
    $userId = $_SESSION['id'];
    
    $tousername = $jobController->GetUserByJobId($_SESSION['jobId'])->username;
    header('Location: UpdateOffer.php?epr=placed&userId='.$userId.'&comment='.$_POST['updateComment'].'&offerprice='.$_POST['updateOfferPrice'].'&tousername='.$tousername);
}

 
 include 'Template.php'
 ?>

