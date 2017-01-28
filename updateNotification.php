<?php

session_start();

require 'Controller/NotificationController.php';
$notificationController = new NotificationController();

$epr='';
if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'updateNofication')
{
    $notificationController->updateNotification($_SESSION['username'],$_GET['date']);
    header('Location: ViewJob.php?epr=view&jobid='.$_GET['jobid']); 
}
?>


