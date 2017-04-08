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

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        // Go Back To Home Page
         header('Location: Home.php');
    }
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
