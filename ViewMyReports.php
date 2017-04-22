<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/ReportController.php';
$reportController = new ReportController();

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
$title = "View Reports";

$content = $reportController->ViewMyReportsContent();
$errorMessage = "";
$sidebar = $reportController->CreateUserProfileSidebar();

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


if($epr=='AdminCat')
{
    $id =$_GET['id'];
    $_SESSION['search'] = $id;
    
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=AdminCat');
}

// Close A report
if($epr=='close')
{
    $id = $_GET['id'];
    $reportController->updateReportStatus(2, $id);
    
    header('Location: ViewAdminReports.php?epr=closed');
}

// Report Closed
if($epr=='closed')
{
    $errorMessage = "<p style='font-size:22px; color:green;'> Report Closed </p>";
}

// Reopen A Report
if($epr=='reopen')
{
    $id = $_GET['id'];
    $reportController->updateReportStatus(1, $id);
    
    header('Location: ViewAdminReports.php?epr=reopened');
}

// Report Reopened
if($epr=='reopened')
{
    $errorMessage = "<p style='font-size:22px; color:green;'> Report Reopned </p>";
}

// Change Year
if(isset($_POST['searchAdminDashboard']) && !empty($_POST['year']))
{
    $_SESSION['yearDate'] = $_POST['year'];
    //Go to Search Result Page
    header('Location: ViewAdminReports.php');
}

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        $content = $reportController->ViewAdminReportsContent();
        $sidebar = $reportController->CreateAdminViewReportsSideBar();
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

