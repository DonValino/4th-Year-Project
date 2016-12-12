<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require 'Controller/JobController.php';
session_start();

$jobController = new JobController();

$epr='';
$title = "View Job";
$content = "";

$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = $jobController->ViewJobDetailsSideBar();
if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
   $content = $jobController->ViewJobDetails($_SESSION['jobId']);
}


if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}
    

 
 include 'Template.php'
 ?>

