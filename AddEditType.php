<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
require 'Controller/TypeController.php';
$typeController = new TypeController();

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

$title = "Add / Edit Type";
$content = $typeController->AddDisplaytypeForm();

$errorMessage = "";
$sidebar = $typeController->CreateJobOverviewSidebar();

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
         $sidebar = $typeController->CreateAdminJobSideBar();
    }else 
    {
        header("location: Home.php");
    }
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if (isset($_POST['addType']) && !empty($_POST['typeName'])) 
{
    $typeController->InsertANewType();
    header('Location: AddEditType.php?epr=added');
}

if($epr=='added')
{
    $errorMessage = "<p style='color:green; text-align:center; font-size:18px;'>Category Added</p>";
}

if($epr=='delete')
{
    $id =$_GET['id'];
    $typeController->DeleteType($id);
    header('Location: AddEditType.php?epr=deleted');
}

if($epr=='deleted')
{
    $errorMessage = "<p style='color:green; text-align:center; font-size:18px;'>Category Deleted</p>";
}

if($epr=='update')
{
    $id =$_GET['id'];
    $content = $typeController->EditypeForm($id);
}

if (isset($_POST['updateType']) && !empty($_POST['typeName'])) 
{
    $id =$_GET['id'];
    $typeController->UpdateType($id);
    header('Location: AddEditType.php?epr=update');
}

if($epr=='updated')
{
    $errorMessage = "<p style='color:green; text-align:center; font-size:18px;'>Category Updated</p>";
}
    
 include 'Template.php'
 ?>