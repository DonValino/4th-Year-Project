<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();
require 'Controller/JobController.php';
$jobController = new JobController();
$epr = "";

$title = "Search Result";
$content = "";

$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = $jobController->CreateMyJobsSideBar();
if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log = "index.php";
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'price')
{
    $min =$_GET['min'];
    $max =$_GET['max'];
    $content = $jobController->SearchResultPrice($min,$max);
}else if($epr == 'myJobs')
{
    $content = $jobController->SearchUserJob($_SESSION['id']);
}else if($epr == 'view')
{
    $id =$_GET['id'];
    $_SESSION['jobId'] = $id;
    //Go to Search Result Page
    header('Location: ViewJob.php');
}else if($epr == 'cat')
{
    $content = $jobController->SearchByCategoryResult($_SESSION['search']);
}else
{
    $content = $jobController->SearchResult($_SESSION['search']);
}
$content .= $jobController->CategoryModal();
$content .= $jobController->PriceModal();
 include 'Template.php'
 ?>

