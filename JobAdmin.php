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

$loginStatus= "Login";
$log = "";

if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = "Home.php";
}else
{
    header('Location: index.php');
}

$epr='';
$title = "Jobs";
$sidebar = $jobController->CreateAdminJobSideBar();
$content = $jobController->AdminJobContent();
$content .= $jobController->AdminPriceModal();
$content .= $jobController->AdminCategoryModal();
$errorMessage = "";


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

if(isset($_POST['AdminSearchByPrice']))
{
    $min =$_POST['min'];
    $max =$_POST['max'];
    header('Location: SearchResult.php?epr=AdminSearchByPrice&min='.$min.'&max='.$max.'');
}
 
 include 'Template.php'
 ?>

