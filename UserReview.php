<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/UserController.php';
require 'Controller/UserReviewController.php';
$userController = new UserController();
$userReviewController = new UserReviewController();

$epr='';
$title = "User Review";
$content = "";
$id = 0;
$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = "";
if(isset($_SESSION['username']))
{
   $loginStatus= "Home";
   $log = "Home.php";
}else
{
    header('Location: index.php');
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='review')
{
    $id =$_GET['id'];
    $content = $userReviewController->UserReviewContent($id);
    $content.= $userController->AddAUserReviewModal($id);
    $content.= $userController->SendMessageModal($id);
    if($_SESSION['id'] == $id)
    {
        $sidebar = $userController->CreateUserReviewSidebar();
    }else
    {
        $sidebar = $userController->ViewUserReviewSideBar($id);
    }
    
}

if (isset($_POST['sendMessage']) && !empty($_POST['messages'])) 
{
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        require 'Model/MessagesModel.php';
	$MessagesModel = new MessagesModel();
        // Store the message in the database
        $MessagesModel->SendAMessage($_SESSION['username'], $_SESSION['SendUsername'], $_POST['messages'], $dateTime);
        
        $errorMessage = "Message Sent :)";

}

if($epr=='reviewAdded')
{
    $errorMessage="Review Added";
    
    $id =$_GET['id'];
    $content = $userReviewController->UserReviewContent($id);
    $content.= $userController->AddAUserReviewModal($id);
    if($_SESSION['id'] == $id)
    {
        $sidebar = $userController->CreateUserReviewSidebar();
    }else
    {
        $sidebar = $userController->ViewUserReviewSideBar($id);
    }
}

if(isset($_POST['addUserReview']) && !empty($_POST['descriptionreview']) && !empty($_POST['punctionalityreview']) && !empty($_POST['worksatisfactionreview']) && !empty($_POST['skillreview']))
{
    //Today's date
    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');
    $userReviewController->InsertANewReview($_SESSION['username'], $id, $_POST['descriptionreview'], $_POST['punctionalityreview'],$_POST['worksatisfactionreview'],$_POST['skillreview'], $dateTime);
    header('Location: UserReview.php?epr=reviewAdded&id='.$id);
}
 
 include 'Template.php'
 ?>