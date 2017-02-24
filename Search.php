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
$title = "Search";
$content = "";
$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = "";
if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
}else
{
    header('Location: index.php');
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


if($epr=='clear')
{
    // Go to DeleteKeywordSearches.php
    header('Location: DeleteKeywordSearches.php?epr=delete');
}

 
 include 'Template.php'
 ?>

