<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();

require 'Controller/UserController.php';
$userController = new UserController();

 
$title = "My Account";
$loginStatus= "Login";
$log = "";
$errorMessage = "";
$epr= '';
        
if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
}else
{
    header('Location: index.php');
}

$loginStatus="Home";
$log = "index.php";

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'requestseen')
{
    // Update user seen the request
    header('Location: RequestSeen.php?epr=updateSeen');
}
$sidebar = $userController->CreateUserProfileSidebar();
$content = $userController->CreateOverviewContent($_SESSION['id']);
 $content .= $userController->JobAlreadyStartedModal();
 include 'Template.php'

?>
