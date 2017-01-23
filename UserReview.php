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
   $log = "home.php";
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
    $sidebar = $userController->ViewUserReviewSideBar($id);
}

if($epr=='reviewAdded')
{
    $errorMessage="Review Added";
    
    $id =$_GET['id'];
    $content = $userReviewController->UserReviewContent($id);
    $content.= $userController->AddAUserReviewModal($id);
    $sidebar = $userController->ViewUserReviewSideBar($id);
}

if(isset($_POST['addUserReview']) && !empty($_POST['descriptionreview']) && !empty($_POST['ratingreview']))
{
    //Today's date
    $date = new DateTime();
    $dateTime = $date->format('Y-m-d H:i:s');
    $userReviewController->InsertANewReview($_SESSION['username'], $id, $_POST['descriptionreview'], $_POST['ratingreview'], $dateTime);
    header('Location: UserReview.php?epr=reviewAdded&id='.$id);
}
 
 include 'Template.php'
 ?>