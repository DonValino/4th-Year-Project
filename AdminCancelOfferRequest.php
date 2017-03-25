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
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
}else
{
    header('Location: index.php');
}

$epr='';
$title = "Offer Cancellation Request";

$content = $cancelRequestController->AdminAllCancellationRequest();

$errorMessage = "";
$sidebar = $cancelRequestController->CreateAdminJobSideBar();

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

if($epr=='cat')
{
    $id =$_GET['id'];
}

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        $sidebar = $cancelRequestController->CreateAdminJobSideBar();
        $log = "AccountSettings.php";
    }else
    {
        header("location: Home.php");
    }
}
 
 include 'Template.php'
 ?>

