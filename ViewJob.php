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

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        // Go Back To Home Page
         header('Location: Home.php');
    }
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
    $content .= $jobController->SignInWorkerModal();
    $content .= $jobController->JobAlreadyStartedModal();
    $content .= $jobController->ViewAllWorkerAttendanceModal();
}

if($epr == 'cashpaymentnotification')
{
    $content = $jobController->ViewJobDetails($_SESSION['jobId']);
    $content .= $jobController->PlaceAnOfferModal();
    $content .= $jobController->UpdateAnOfferModal();
    $content .= $jobController->JobSubscriptionStatusModal();
    $content .= $jobController->RenewJobSubscriptionModal();
    $content .= $jobController->SignInWorkerModal();
    $content .= $jobController->JobAlreadyStartedModal();
    $content .= $jobController->ViewAllWorkerAttendanceModal();
    
    $errorMessage="<p style='color:green;text-align:center;font-size:18px;'>Cash Payment Notification sent :)</p>";
}

if($epr == 'viewJobAcceptedOffer')
{
    $errorMessage = "<p style='color:green;font-size:18px;'>Offer Accepted :)</p>";
    
    $_SESSION['jobId'] = $_GET['jobid'];
    $content = $jobController->ViewJobDetails($_SESSION['jobId']);
    $content .= $jobController->PlaceAnOfferModal();
    $content .= $jobController->UpdateAnOfferModal();
    $content .= $jobController->JobSubscriptionStatusModal();
    $content .= $jobController->RenewJobSubscriptionModal();
    $content .= $jobController->SignInWorkerModal();
    $content .= $jobController->JobAlreadyStartedModal();
    $content .= $jobController->ViewAllWorkerAttendanceModal();
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
    $content .= $jobController->SignInWorkerModal();
    $content .= $jobController->JobAlreadyStartedModal();
    $content .= $jobController->ViewAllWorkerAttendanceModal();
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
    $content .= $jobController->SignInWorkerModal();
    $content .= $jobController->JobAlreadyStartedModal();
    $content .= $jobController->ViewAllWorkerAttendanceModal();
}

if($epr == 'renewedStandardAndview')
{
    $_SESSION['jobId'] = $_GET['jobid'];
    $content = $jobController->ViewJobDetails($_SESSION['jobId']);
    $content .= $jobController->PlaceAnOfferModal();
    $content .= $jobController->UpdateAnOfferModal();
    $content .= $jobController->JobSubscriptionStatusModal();
    $content .= $jobController->RenewJobSubscriptionModal();
    $content .= $jobController->SignInWorkerModal();
    $content .= $jobController->JobAlreadyStartedModal();
    $content .= $jobController->ViewAllWorkerAttendanceModal();
    
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
    $content .= $jobController->SignInWorkerModal();
    $content .= $jobController->JobAlreadyStartedModal();
    $content .= $jobController->ViewAllWorkerAttendanceModal();
    
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
    $content .= $jobController->SignInWorkerModal();
    $content .= $jobController->JobAlreadyStartedModal();
    $content .= $jobController->ViewAllWorkerAttendanceModal();
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
   $content .= $jobController->SignInWorkerModal();
   $content .= $jobController->JobAlreadyStartedModal();
   $content .= $jobController->ViewAllWorkerAttendanceModal();
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
    $errorMessage="<p style='color:green;font-size:18px;'>Thanks, Offer Placed!!</p>";
}

if($epr == 'offerUpdated')
{
    $errorMessage="<p style='color:green;font-size:18px;'>Thanks, Offer Updated!!</p>";
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


//Login Code - Query DB to see if user exist and if exist, allow user worker to login To A Job
 if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
     
     require_once 'Controller/SignInController.php';
     require_once 'Model/PlacedOffersModel.php';
     require_once 'Model/UserModel.php';
     
    $userModel = new UserModel();
    $signInController = new SignInController();
    $PlacedOffersModel = new PlacedOffersModel();
             
    $userObject = $userModel->CheckUser($_POST['username']);
    
    if($userObject != NULL)
    {  
        if($userObject->username == $_POST['username'] && $userObject->password == $_POST['password'])
        {
            //Today's date
            $date = new DateTime();
            $dateTime = $date->format('Y-m-d H:i:s');
            
            $lastSignedIn = $signInController->GetSignInRecordsByUserIdAndJobId($userObject->id, $_SESSION['jobId']);
            
            $isUserOnceOfTheWorker = $PlacedOffersModel->GetUserlacedOffersByJobIdAndUserId($_SESSION['jobId'], $userObject->id);
            
            if($lastSignedIn != NULL && $isUserOnceOfTheWorker != NULL && $isUserOnceOfTheWorker->bidStatus == 1)
            {
                $lastSignInDate = $lastSignedIn->date;
                if((time() - ((60 * 60 * 24) * 1) >= strtotime($lastSignInDate)))
                {
                    // User Has Not signed in today
                    $signInController->updateLatestStatus(0, $userObject->id, $_SESSION['jobId']);
                    $signInController->InsertAUserSignIn($userObject->id, $_SESSION['jobId'], $dateTime,1);
                    $errorMessage= '<p style="color:green;font-size:18px;">Welcome Worker: <strong style="color:blue;">'.$userObject->firstName.' '.$userObject->lastName.'</strong> :)</p>';
                }else
                {
                    // User Has Already Signed In Today
                    $errorMessage= '<p style="color:green;font-size:18px;">This Worker Has Already Signed In Today</p>';
                }
            }else if($lastSignedIn == NULL && $isUserOnceOfTheWorker != NULL && $isUserOnceOfTheWorker->bidStatus == 1)
            {
                // User Has Never Signed Into This Job Yet
                $signInController->InsertAUserSignIn($userObject->id, $_SESSION['jobId'], $dateTime,1);
                $errorMessage= '<p style="color:green;font-size:18px;">Welcome Worker: <strong style="color:blue;">'.$userObject->firstName.' '.$userObject->lastName.'</strong> :)</p>'; 
            }else if($lastSignedIn == NULL && $isUserOnceOfTheWorker != NULL && $isUserOnceOfTheWorker->bidStatus == 0)
            {
               // User Is Not One Of The Accepted Worker
               $errorMessage= '* Error: You Are Not One Of The Accepted Workers For This Job *';
            }
            else
            {
                $errorMessage= '* Error: You Are Not One Of The Accepted Workers For This Job *';
            }
        }else
        {
            $_SESSION['valid'] = false;
            $errorMessage= '* Error!! Username / Password is incorrect. Please try again :)';
        }
    }else
    {
        $errorMessage= '* Error!! Username / Password is incorrect. Please try again :)';
    }
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

