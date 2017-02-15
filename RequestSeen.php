<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/RequestController.php';

$requestController = new RequestController();

$epr='';

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'updateSeen')
{
    $requestController->updateRequestSeen($_SESSION['id']);
    // Go Back To User Account Page
    header('Location: UserAccount.php');
}

if($epr == 'accept')
{
    $id = $_GET['id'];

    $requestController->updateRequestStatus(2, $id, $_SESSION['id']);
    
    $requestController->updateRequestSeen($_SESSION['id']);
    
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
    $requestController->InsertANewRequest($_SESSION['id'], $id, 2, $dateTime, 2);
    
    header('Location: Request.php');
}

if($epr == 'denied')
{
    $id = $_GET['id'];

    $requestController->updateRequestStatus(0, $id, $_SESSION['id']);
    
    $requestController->updateRequestSeen($_SESSION['id']);
    
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
    $requestController->InsertANewRequest($_SESSION['id'], $id, 3, $dateTime, 0);
    
    header('Location: Request.php'); 
}
 

 ?>