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

$content = $userController->AdminUserContent();

$errorMessage = "";
$sidebar = $userController->CreateAdminUserSideBar();

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

if($epr=='AdminCat')
{
    $id =$_GET['id'];
    $_SESSION['search'] = $id;
    
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=AdminCat');
}

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        $sidebar = $userController->CreateAdminUserSideBar();
        $log = "AccountSettings.php";
        
    }
}
 
 include 'Template.php'
 ?>

