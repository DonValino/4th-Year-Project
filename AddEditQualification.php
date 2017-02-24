<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

session_start();
require 'Controller/QualificationController.php';
$qualificationController = new QualificationController();

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
$content = $qualificationController->AddDisplayQualificationForm();

$errorMessage = "";
$sidebar = $qualificationController->CreateJobOverviewSidebar();

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if (isset($_POST['addQualification']) && !empty($_POST['qualificationName']) && !empty($_POST['description'])) 
{
    $qualificationController->InsertANewQualification();
    header('Location: AddEditQualification.php');
}

if($epr=='delete')
{
    $id =$_GET['id'];
    $qualificationController->DeleteQualification($id);
    header('Location: AddEditQualification.php');
}

if($epr=='update')
{
    $id =$_GET['id'];
    $content = $qualificationController->EditQualificationForm($id);
}

if (isset($_POST['updateQualification']) && !empty($_POST['qualificationName']) && !empty($_POST['description'])) 
{
    $id =$_GET['id'];
    $qualificationController->updateQualification($id);
    header('Location: AddEditQualification.php');
}
 
 include 'Template.php'
 ?>