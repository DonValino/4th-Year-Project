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

$content = $userController->AddEditAdminUsersContent();

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

if($epr=='admin')
{
    $id =$_GET['id'];
    $user = $userController->GetUserById($id);
    
    $userController->updateAccountType(1, $id);
    header('Location: AddEditAdminUser.php?epr=adminized');
}

if($epr=='adminized')
{
    $errorMessage = "<p style='color:green;font-size:16px;'>Account is now admin type.</p>";
}

if($epr=='user')
{
    $id =$_GET['id'];
    $userController->updateAccountType(0, $id);
    
    //Go to Search Result Page
    header('Location: AddEditAdminUser.php?epr=usernized');
}

if($epr=='usernized')
{
    $errorMessage = "<p style='color:green;font-size:16px;'>Account is now user type.</p>";
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

