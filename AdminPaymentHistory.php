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
$title = "home";

$content = $paymentController->ViewPaymentHistory();

$errorMessage = "";
$sidebar = $paymentController->CreateAdminJobSideBar();

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        $sidebar = $paymentController->CreateAdminJobSideBar();
        $log = "AccountSettings.php";
    }else
    {
        header("location: Home.php");
    }
}
 
 include 'Template.php'
 ?>

