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

if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
}

$sidebar = $userController->CreateUserProfileSidebar();
$content = $userController->CreateOverviewContent();
 
 include 'Template.php'

?>
