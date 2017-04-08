<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/DeactivatedUsersController.php';
$deactivatedUsersController = new DeactivatedUsersController();

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
$title = "Reason For User Deactivation";

$content = $deactivatedUsersController->ViewDeactivatedUserReasons();

$errorMessage = "";
$sidebar = $deactivatedUsersController->CreateAdminJobSideBar();

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        $sidebar = $deactivatedUsersController->CreateAdminJobSideBar();
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

