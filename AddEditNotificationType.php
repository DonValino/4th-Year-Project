<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/NotificationTypeController.php';
$notificationTypeController = new NotificationTypeController();

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
$title = "Add / Edit Notification Type";

$content = $notificationTypeController->AddDisplayNotificationTypeForm();

$errorMessage = "";
$sidebar = $notificationTypeController->CreateAdminJobSideBar();

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if (isset($_POST['addNotificationType']) && !empty($_POST['name'])) 
{
    $notificationTypeController->InsertNotificationType();
    header('Location: AddEditNotificationType.php?epr=added');
}

if($epr=='added')
{
    $errorMessage = "<p style='color:green; text-align:center; font-size:18px;'>Notification Added</p>";
}

if($epr=='delete')
{
    $id =$_GET['id'];
    $notificationTypeController->deleteANotificationType($id);
    header('Location: AddEditNotificationType.php?epr=deleted');
}

if($epr=='deleted')
{
    $errorMessage = "<p style='color:green; text-align:center; font-size:18px;'>Notification Deleted</p>";
}

if($epr=='update')
{
    $id =$_GET['id'];
    $content = $notificationTypeController->EditDisplayNotificationTypeForm($id);
}

if (isset($_POST['updateNotificationType']) && !empty($_POST['name'])) 
{
    $id =$_GET['id'];
    $notificationTypeController->updateACountyById($id, $_POST['name']);
    header('Location: AddEditNotificationType.php?epr=updated'); 
}

if($epr=='updated')
{
    $errorMessage = "<p style='color:green; text-align:center; font-size:18px;'>Notification Type Updated</p>";
}

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        $sidebar = $notificationTypeController->CreateAdminJobSideBar();
        $log = "AccountSettings.php";
        
    }else
    {
        header("location: Home.php");
    }
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

