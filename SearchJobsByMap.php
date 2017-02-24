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
$title = "Map Search";
$content = $jobController->MapSearchContent();


$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = $jobController->CreateHomeSideBar();
if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log = "home.php";
}else
{
    header('Location: index.php');
}
 
 include 'Template.php'
 ?>

