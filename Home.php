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

$epr='';
$title = "home";
$content = $jobController->CreateSearchBar();
$content .= $jobController->CategoryModal();
$content .= $jobController->PriceModal();

$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = $jobController->CreateHomeSideBar();
if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
}

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
    $_SESSION['search'] = $id;
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=cat');
}

    if(isset($_POST['searchByPrice']))
    {
        $min =$_POST['min'];
        $max =$_POST['max'];
        header('Location: SearchResult.php?epr=price&min='.$min.'&max='.$max.'');
    }
 
 include 'Template.php'
 ?>

