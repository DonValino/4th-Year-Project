<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

require 'Controller/FollowingTimelineController.php';
$followingTimelineController = new FollowingTimelineController();

$epr='';

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='add')
{
    //Today's date
    $date = new DateTime();
    $dateoffollowed = $date->format('Y-m-d H:i:s.u');
    $jobid = $_GET['jobid'];
    $jobid = $jobid + 1;
    $followingTimelineController->InsertTimeline($_SESSION['id'], 6, $dateoffollowed, $_GET['jobid']);
    header('Location: Home.php');
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
    
?>