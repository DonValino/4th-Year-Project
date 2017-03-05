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

if(!isset($_SESSION['username']))
{
    header('Location: index.php');
}

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
    $content .= $jobController->JobSubscriptionStatusModal();
    $content .= $jobController->RenewJobSubscriptionModal();
}

if($epr == 'viewJobAcceptedOffer')
{
    $errorMessage = "Offer Accepted :)";
    
    $_SESSION['jobId'] = $_GET['jobid'];
    $content = $jobController->ViewJobDetails($_SESSION['jobId']);
    $content .= $jobController->PlaceAnOfferModal();
    $content .= $jobController->UpdateAnOfferModal();
    $content .= $jobController->JobSubscriptionStatusModal();
    $content .= $jobController->RenewJobSubscriptionModal();
}

if($epr == 'viewDeclineOffer')
{
    $errorMessage = "Offer Declined :(";
    
    $_SESSION['jobId'] = $_GET['jobid'];
    $content = $jobController->ViewJobDetails($_SESSION['jobId']);
    $content .= $jobController->PlaceAnOfferModal();
    $content .= $jobController->UpdateAnOfferModal();
    $content .= $jobController->JobSubscriptionStatusModal();
    $content .= $jobController->RenewJobSubscriptionModal();
}

if($epr == 'viewJobCancellationOffer')
{
    $errorMessage = "Offer Cancellation Request Submitted -_-";
    
    $_SESSION['jobId'] = $_GET['jobid'];
    $content = $jobController->ViewJobDetails($_SESSION['jobId']);
    $content .= $jobController->PlaceAnOfferModal();
    $content .= $jobController->UpdateAnOfferModal();
    $content .= $jobController->JobSubscriptionStatusModal();
    $content .= $jobController->RenewJobSubscriptionModal();
}

if($epr == 'renewedStandardAndview')
{
    $_SESSION['jobId'] = $_GET['jobid'];
    $content = $jobController->ViewJobDetails($_SESSION['jobId']);
    $content .= $jobController->PlaceAnOfferModal();
    $content .= $jobController->UpdateAnOfferModal();
    $content .= $jobController->JobSubscriptionStatusModal();
    $content .= $jobController->RenewJobSubscriptionModal();
    
    $jobController->updateJobActiveStatus($_SESSION['jobId'], 1);
    $jobController->updateJobAdType($_SESSION['jobId'], 0);
    
    // Set A New Date For The Job

        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
    $jobController->updateJobDate($_SESSION['jobId'], $dateTime);
}

if($epr == 'renewedFeaturedAndview')
{
    $_SESSION['jobId'] = $_GET['jobid'];
    $content = $jobController->ViewJobDetails($_SESSION['jobId']);
    $content .= $jobController->PlaceAnOfferModal();
    $content .= $jobController->UpdateAnOfferModal();
    $content .= $jobController->JobSubscriptionStatusModal();
    $content .= $jobController->RenewJobSubscriptionModal();
    
    $jobController->updateJobActiveStatus($_SESSION['jobId'], 1);
    $jobController->updateJobAdType($_SESSION['jobId'], 1);
    
    // Set A New Date For The Job

        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
    $jobController->updateJobDate($_SESSION['jobId'], $dateTime);
}

if($epr == 'viewAndUpgrade')
{
    $_SESSION['jobId'] = $_GET['jobid'];
    
    $jobController->updateStandardJobToFeaturedJob($_SESSION['jobId'], 1);
    
    //Today's date
    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');
        
    $jobController->updateJobPostedDate($_SESSION['jobId'], $dateTime);
    
    $jobController->updateJobActiveStatus($_SESSION['jobId'], 1);
    
    $content = $jobController->ViewJobDetails($_SESSION['jobId']);
    $content .= $jobController->PlaceAnOfferModal();
    $content .= $jobController->UpdateAnOfferModal();
    $content .= $jobController->JobSubscriptionStatusModal();
    $content .= $jobController->RenewJobSubscriptionModal();
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
   $log ="Home.php";
   $content = $jobController->ViewJobDetails($_SESSION['jobId']);
   $content .= $jobController->PlaceAnOfferModal();
   $content .= $jobController->UpdateAnOfferModal();
   $content .= $jobController->JobSubscriptionStatusModal();
   $content .= $jobController->RenewJobSubscriptionModal();
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

// Offer Accepted
if($epr == 'offerAccepted')
{
    $userId = $_GET['userId'];
    $tousername = $jobController->GetUserById($userId)->username;
    header('Location: PlaceOffer.php?epr=offerAccepted&userId='.$userId.'&tousername='.$tousername);
}

// Offer Declined
if($epr == 'declineOffer')
{
    $userId = $_GET['userId'];
    $tousername = $jobController->GetUserById($userId)->username;
    header('Location: PlaceOffer.php?epr=declineOffer&userId='.$userId.'&tousername='.$tousername);
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
        header('Location: PlaceOffer.php?epr=placedFB&userId='.$userId.'&comment='.$_POST['comment'].'&offerprice='.$_POST['offerPrice'].'&tousername='.$tousername.'&startDate='.$jobController->GetJobsByID($_SESSION['jobId'])->startDate);
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

        // Last Day of User
        $time = strtotime($prefferedCommenceDate);
        $dateFinished = new DateTime(date('Y-m-d',$time));
        $dateFinished->modify('+'.$_POST['numberOfDays'].' day');
        

        // Start Of Job
        $dateOfJob = $jobController->GetJobsByID($_SESSION['jobId'])->startDate;
        
        // End Of Job
        $endJobTime = strtotime($jobController->GetJobsByID($_SESSION['jobId'])->startDate);
        $dateEnd = new DateTime(date('Y-m-d',$endJobTime));
        $dateEnd->modify('+'.$jobController->GetJobsByID($_SESSION['jobId'])->numberOfDays.' day');

        if(strtotime($prefferedCommenceDate) <= strtotime($dateEnd->format("Y-m-d H:i:s")) && strtotime($prefferedCommenceDate) >= strtotime($dateOfJob) && (strtotime($dateFinished->format('Y-m-d H:i:s'))) <= (strtotime($dateEnd->format("Y-m-d H:i:s"))))
        {
            $tousername = $jobController->GetUserByJobId($_SESSION['jobId'])->username;
            header('Location: PlaceOffer.php?epr=placedPB&userId='.$userId.'&comment='.$_POST['comment'].'&offerprice='.$_POST['offerPrice'].'&tousername='.$tousername.'&numberOfDays='.$_POST['numberOfDays'].'&prefferedCommenceDate='.$prefferedCommenceDate);
        }else if(strtotime($prefferedCommenceDate) <= strtotime($dateEnd->format("Y-m-d H:i:s")) && strtotime($prefferedCommenceDate) < strtotime($dateOfJob) && (strtotime($dateFinished->format('Y-m-d H:i:s'))) <= (strtotime($dateEnd->format("Y-m-d H:i:s"))))
        {
            $errorMessage= 'Error: Preferred Commence Date is before the start date of the job';
        }else
        {
            $errorMessage= 'Error: You must allow enough days between your preferred commence date and the number of days you want to work';
        }

    }
}

if (isset($_POST['subscribeButton']))
{
    if($_POST['subscType'] == 0)
    {
        header('Location: RenewJobAsStandardAd.php');
    }else if($_POST['subscType'] == 1)
    {
        header('Location: RenewJobAsFeaturedAd.php');
    }
}

//Code Full Time update an offer
//First Check to ensure all fields are not empty
if (isset($_POST['updateOfferFB']) && !empty($_POST['updateOfferPrice']) && !empty($_POST['updateComment'])) 
{
    $userId = $_SESSION['id'];
    
    $tousername = $jobController->GetUserByJobId($_SESSION['jobId'])->username;
    header('Location: UpdateOffer.php?epr=placedFB&userId='.$userId.'&comment='.$_POST['updateComment'].'&offerprice='.$_POST['updateOfferPrice'].'&tousername='.$tousername."&numberOfDays=".$jobController->GetJobsByID($_SESSION['jobId'])->numberOfDays."&startDate=".$jobController->GetJobsByID($_SESSION['jobId'])->startDate);
}

//Code Part Time update an offer
//First Check to ensure all fields are not empty
if (isset($_POST['updateOfferPB']) && !empty($_POST['updateOfferPrice']) && !empty($_POST['updateComment']) && !empty($_POST['prefferedCommenceDateUpdate']) && !empty($_POST['numberOfDaysUpdate'])) 
{
    $userId = $_SESSION['id'];
    
    $tousername = $jobController->GetUserByJobId($_SESSION['jobId'])->username;
    header('Location: UpdateOffer.php?epr=placedPB&userId='.$userId.'&comment='.$_POST['updateComment'].'&offerprice='.$_POST['updateOfferPrice'].'&tousername='.$tousername."&prefferedCommenceDateUpdate=".$_POST['prefferedCommenceDateUpdate']."&numberOfDaysUpdate=".$_POST['numberOfDaysUpdate']);
}

if($epr == 'delete')
{
    $userId = $_GET['userId'];
    
    header('Location: placeOffer.php?epr=delete&userId='.$userId);
}

 include 'Template.php'
 ?>

