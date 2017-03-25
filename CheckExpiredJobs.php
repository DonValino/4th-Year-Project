<?php
session_start();

require 'Controller/JobController.php';

$jobController = new JobController();


if(!isset($_SESSION['username']))
{
    header('Location: index.php');
}

$userJobs = $jobController->GetJobsByUserID($_SESSION['id']);
if($userJobs != NULL)
{
            require_once 'Model/NotificationModel.php';
            $notificationModel = new NotificationModel();
            
            require_once 'Model/UserModel.php';
            $userModel= new UserModel();
            
            //Today's date
            $date = new DateTime();
            $dateTime = $date->format('Y-m-d H:i:s');
            
            $userName = $userModel->GetUserById($_SESSION['id'])->username;
            
    foreach($userJobs as $row)
    {
        $jobDate = $row->date;
         
        if((time() - ((60 * 60 * 24) * 30) >= strtotime($jobDate)) && ($row->adtype == 0) && ($row->isActive == 1))
        {
            $jobController->updateJobActiveStatus($row->jobid, 0);

            $notificationModel->InsertNotification("System", $userName, 8, 0, $dateTime, $row->jobid);
            
        }
        
        if((time() - ((60 * 60 * 24) * 5) >= strtotime($jobDate)) && ($row->adtype == 1) && ($row->isActive == 1))
        {
            $jobController->updateJobAdType($row->jobid, 0);

            $notificationModel->InsertNotification("System", $userName, 7, 0, $dateTime, $row->jobid);
           
        }
    }
}
require_once 'Model/UserModel.php';
$userModel = new UserModel();require_once 'Model/UserModel.php';

        if($userModel->GetUserById($_SESSION['id'])->admin == 0)
        {
            $_SESSION['admin'] = 0;
            // Go To Home Page
            header('Location: Home.php');
        }else
        {
            $_SESSION['admin'] = 1;
            // Go To Home Page
            header('Location: Home.php'); 
        }

