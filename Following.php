<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/FollowingController.php';
$followingController = new FollowingController();

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
$title = "Following";
$content = $followingController->FollowingContent();

$errorMessage = "";
$sidebar = $followingController->FollowingSidebar();

if(isset($_POST['search']) && !empty($_POST['keyword']))
{
    $_SESSION['search'] = $_POST['keyword'];
    //Go to Search Result Page
    header('Location: SearchResult.php');
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='followfromusereview')
{
        //Today's date
        $date = new DateTime();
        $dateoffollowed = $date->format('d-m-Y');
        
        $followinguserId =$_GET['followinguserId'];
        
        $followed = $followingController->CheckIfUserAlreadyFollowedAnotherUser($_SESSION['id'], $followinguserId);
        if($followed != NULL)
        {  
            // Error, User already followed.
            $errorMessage= '* Error!! this user is already followed!!';
            header('Location: UserReview.php?epr=review&id='.$followinguserId.'&errorMessage='.$errorMessage);
        }else
        {
            $followingController->FollowAUser($_SESSION['id'], $followinguserId, $dateoffollowed);
            header('Location: UserReview.php?epr=review&id='.$followinguserId);
        }
}

if($epr=='followfromjobposted')
{
        //Today's date
        $date = new DateTime();
        $dateoffollowed = $date->format('d-m-Y');
        
        $followinguserId =$_GET['followinguserId'];
        
        $followed = $followingController->CheckIfUserAlreadyFollowedAnotherUser($_SESSION['id'], $followinguserId);
        if($followed != NULL)
        {  
            // Error, User already followed.
            $errorMessage= '* Error!! this user is already followed!!';
            header('Location: JobPosted.php?epr=view&id='.$followinguserId.'&errorMessage='.$errorMessage);
        }else
        {
            $followingController->FollowAUser($_SESSION['id'], $followinguserId, $dateoffollowed);
            header('Location: JobPosted.php?epr=view&id='.$followinguserId);
        }
}


if($epr=='followfromuserprofile')
{
        //Today's date
        $date = new DateTime();
        $dateoffollowed = $date->format('d-m-Y');
        
        $followinguserId =$_GET['followinguserId'];
        
        $followed = $followingController->CheckIfUserAlreadyFollowedAnotherUser($_SESSION['id'], $followinguserId);
        if($followed != NULL)
        {  
            // Error, User already followed.
            $errorMessage= '* Error!! this user is already followed!!';
            header('Location: ViewUserProfile.php?epr=view&id='.$followinguserId.'&errorMessage='.$errorMessage);
        }else
        {
            $followingController->FollowAUser($_SESSION['id'], $followinguserId, $dateoffollowed);
            header('Location: ViewUserProfile.php?epr=view&id='.$followinguserId);
        }
}


if($epr=='followfromviewjob')
{
        //Today's date
        $date = new DateTime();
        $dateoffollowed = $date->format('d-m-Y');
        
        $followinguserId =$_GET['followinguserId'];
        
        $followed = $followingController->CheckIfUserAlreadyFollowedAnotherUser($_SESSION['id'], $followinguserId);
        if($followed != NULL)
        {  
            // Error, User already followed.
            $errorMessage= '* Error!! this user is already followed!!';
            header('Location: ViewJob.php?epr=view&jobid='.$_SESSION['jobId'].'&errorMessage='.$errorMessage);
        }else
        {
            $followingController->FollowAUser($_SESSION['id'], $followinguserId, $dateoffollowed);
            header('Location: ViewJob.php?epr=view&jobid='.$_SESSION['jobId']);
        }
}

if($epr=='unfollowfromusereview')
{
        
        $followinguserId =$_GET['followinguserId'];
        
        $followed = $followingController->CheckIfUserAlreadyFollowedAnotherUser($_SESSION['id'], $followinguserId);
        if($followed != NULL)
        {  
            $followingController->unfollowAUser($_SESSION['id'], $followinguserId);
            header('Location: UserReview.php?epr=review&id='.$followinguserId);
        }else
        {
            // Error, User already followed.
            $errorMessage= '* Error!! this user is already followed!!';
            header('Location: UserReview.php?epr=review&id='.$followinguserId.'&errorMessage='.$errorMessage);
        }
}
if($epr=='unfollowfromjobposted')
{
        $followinguserId =$_GET['followinguserId'];
        
        $followed = $followingController->CheckIfUserAlreadyFollowedAnotherUser($_SESSION['id'], $followinguserId);
        if($followed != NULL)
        {  
            $followingController->unfollowAUser($_SESSION['id'], $followinguserId);
            header('Location: JobPosted.php?epr=view&id='.$followinguserId);
        }else
        {
            // Error, User already followed.
            $errorMessage= '* Error!! this user is already followed!!';
            header('Location: JobPosted.php?epr=view&id='.$followinguserId.'&errorMessage='.$errorMessage);
        }
}

if($epr=='unfollowfromuserprofile')
{
        $followinguserId =$_GET['followinguserId'];
        
        $followed = $followingController->CheckIfUserAlreadyFollowedAnotherUser($_SESSION['id'], $followinguserId);
        if($followed != NULL)
        {  
            $followingController->unfollowAUser($_SESSION['id'], $followinguserId);
            header('Location: ViewUserProfile.php?epr=view&id='.$followinguserId);
        }else
        {
            // Error, User already followed.
            $errorMessage= '* Error!! this user is already followed!!';
            header('Location: ViewUserProfile.php?epr=view&id='.$followinguserId.'&errorMessage='.$errorMessage);
        }
}

if($epr=='unfollowfromViewJob')
{
        $followinguserId =$_GET['followinguserId'];
        
        $followed = $followingController->CheckIfUserAlreadyFollowedAnotherUser($_SESSION['id'], $followinguserId);
        if($followed != NULL)
        {  
            $followingController->unfollowAUser($_SESSION['id'], $followinguserId);
            header('Location: ViewJob.php?epr=view&jobid='.$_SESSION['jobId']);
        }else
        {
            // Error, User already followed.
            $errorMessage= '* Error!! this user is already followed!!';
            header('Location: ViewJob.php?epr=view&jobid='.$_SESSION['jobId'].'&errorMessage='.$errorMessage);
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

