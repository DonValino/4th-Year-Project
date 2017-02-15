<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/RequestController.php';


$requestController = new RequestController();


$epr='';
$title = "Requests";
$content = $requestController->RequestContent();

$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = $requestController->CreateRequestSideBar();
if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'].'?epr=requestseen';
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}
 
 include 'Template.php'
 ?>

