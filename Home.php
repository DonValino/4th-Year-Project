<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/JobController.php';
require 'Controller/RecommenderController.php';
$jobController = new JobController();
$recommenderController = new RecommenderController();

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
$content = $jobController->CreateSearchBar();
$content .= $jobController->CreateHomeContent($_SESSION['id']);
$content .= $jobController->CategoryModal();
$content .= $jobController->PriceModal();


$errorMessage = "";
$sidebar = $jobController->CreateHomeSideBar();

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
    
    //Today's date
    $date = new DateTime();
    $dateTime = $date->format('d-m-Y H:i:s');
    
    // Check if a record already exist
    $exist = $recommenderController->GetRecordByCatIdAndUserId($id, $_SESSION['id']);
    
    if($exist != NULL)
    {
        $qty = $exist->qty;
        $qty = $qty + 1;
        $recommenderController->updateQtyByCatIdAndUserId($qty, $id, $_SESSION['id']);
    }else
    {
        // Add a new record to recommender table database
        $recommenderController->InsertANewRecord($id, $_SESSION['id'],1, $dateTime);  
    }

    //Go to Search Result Page
    header('Location: SearchResult.php?epr=cat');
}

if($epr=='clear')
{
    // Go to DeleteKeywordSearches.php
    header('Location: DeleteKeywordSearches.php?epr=delete');
}

if($epr=='qua')
{
    $id =$_GET['id'];
    $_SESSION['search'] = $id;
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=qua');
}

if($epr=='location')
{
    $id =$_GET['id'];
    $_SESSION['search'] = $id;
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=location');
}

    if(isset($_POST['searchByPrice']))
    {
        $min =$_POST['min'];
        $max =$_POST['max'];
        header('Location: SearchResult.php?epr=price&min='.$min.'&max='.$max.'');
    }
 
 include 'Template.php'
 ?>

