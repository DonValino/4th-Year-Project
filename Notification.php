<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/NotificationController.php';
$notificationController = new NotificationController();

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
$title = "Notification";
$content = $notificationController->NotificationContent();
$content .= $notificationController->CategoryModal();
$content .= $notificationController->PriceModal();

$errorMessage = "";
$sidebar = $notificationController->CreateNotificationSideBar();

if(isset($_POST['search']) && !empty($_POST['keyword']))
{
    $_SESSION['search'] = $_POST['keyword'];
    //Go to Search Result Page
    header('Location: SearchResult.php');
}

if(isset($_POST['searchByPrice']))
{
    $min =$_POST['min'];
    $max =$_POST['max'];
    header('Location: SearchResult.php?epr=price&min='.$min.'&max='.$max.'');
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='cat')
{
    $id =$_GET['id'];
    $_SESSION['search'] = $id;
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=cat');
}
 
include 'Template.php'
?>

