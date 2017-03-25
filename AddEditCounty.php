<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/CountyController.php';
$countyController = new CountyController();

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
$title = "Add / Edit County";

$content = $countyController->AddDisplayCountyForm();

$errorMessage = "";
$sidebar = $countyController->CreateAdminJobSideBar();

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if (isset($_POST['addCounty']) && !empty($_POST['countyName'])) 
{
    $countyController->InsertANewCounty($_POST['countyName']);
    header('Location: AddEditCounty.php?epr=added');
}

if($epr=='added')
{
    $errorMessage = "<p style='color:green; text-align:center; font-size:18px;'>County Added</p>";
}

if($epr=='delete')
{
    $id =$_GET['id'];
    $countyController->deleteACountyByID($id);
    header('Location: AddEditCounty.php?epr=deleted');
}

if($epr=='deleted')
{
    $errorMessage = "<p style='color:green; text-align:center; font-size:18px;'>County Deleted</p>";
}

if($epr=='update')
{
    $id =$_GET['id'];
    $content = $countyController->EditCountyForm($id);
}

if (isset($_POST['updateCounty']) && !empty($_POST['countyName'])) 
{
    $id =$_GET['id'];
    $countyController->updateACountyById($_POST['countyName'], $id);
    header('Location: AddEditCounty.php?epr=updated'); 
}

if($epr=='updated')
{
    $errorMessage = "<p style='color:green; text-align:center; font-size:18px;'>County Updated</p>";
}

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        $sidebar = $countyController->CreateAdminJobSideBar();
        $log = "AccountSettings.php";
        
    }else
    {
        header("location: Home.php");
    }
}
 
 include 'Template.php'
 ?>

