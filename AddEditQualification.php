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

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
         $sidebar = $qualificationController->CreateAdminJobSideBar();
    }else 
    {
        header("location: Home.php");
    }
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if (isset($_POST['addQualification']) && !empty($_POST['qualificationName']) && !empty($_POST['description'])) 
{
    $qualificationController->InsertANewQualification();
    header('Location: AddEditQualification.php?epr=added');
}

if($epr=='added')
{
    $errorMessage = "<p style='color:green; text-align:center; font-size:18px;'>Qualification Added</p>";
}

if($epr=='delete')
{
    $id =$_GET['id'];
    $qualificationController->DeleteQualification($id);
    header('Location: AddEditQualification.php?epr=deleted');
}

if($epr=='deleted')
{
    $errorMessage = "<p style='color:green; text-align:center; font-size:18px;'>Qualification Deleted</p>";
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
    header('Location: AddEditQualification.php?epr=updated');
}

if($epr=='updated')
{
    $errorMessage = "<p style='color:green; text-align:center; font-size:18px;'>Qualification Updated</p>";
}

if(isset($_SESSION['active']))
{
    if ($_SESSION['active'] == 0)
    {
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        $adminusers = $userModel->GetActiveUsers();
        $content = "<p style='color:blue;font-size:18px;text-align:center;'>Your account has been deactivated. Please Contact one of the listed administrator: </p>";
        
        if ($adminusers != null)
        {
            foreach($adminusers as $row)
            {
                if($row->admin == 1)
                {
                    $log = "Logout.php";
                    $loginStatus = "Logout";
                    $sidebar = "";
                    $content .= "<p style='color:green;font-size:18px;text-align:center;'>$row->email</p>";
                }
            }
        }
        
    }
}
 
 include 'Template.php'
 ?>