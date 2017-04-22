<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();
require 'Controller/MessageController.php';
require 'Controller/RegisterController.php';

//Creating an instance of Register Controller
$registerController = new RegisterController();

//Creating an instance of Message Controller
$messageController = new MessageController();

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
$title = "Messages";
$content = $messageController->MessageContent();
$content .= $messageController->CategoryModal();
$content .= $messageController->PriceModal();

$errorMessage = "";
$sidebar = $messageController->CreateMessengerSideBar();

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        $sidebar = $messageController->CreateAdminSideBar();
    }
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if(isset($_SESSION['fromusername']) && $epr != "MessageSent")
{
    $_SESSION['fromusername'] = NULL;
}

if(isset($_POST['searchByPrice']))
{
    $min =$_POST['min'];
    $max =$_POST['max'];
    header('Location: SearchResult.php?epr=price&min='.$min.'&max='.$max.'');
}

if (isset($_POST['sendMessage']) && !empty($_POST['messages']) && !empty($_POST['tousername'])) 
{
    // Calling the CheckUser() method of the RegisterController Class to check using the username if the user exist 
    $userObject = $registerController->CheckUser($_POST['tousername']);
    
    if($userObject != NULL)
    {
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $_SESSION['sentTo'] = $_POST['tousername'];
        
        // Store the message in the database
        $messageController->SendAMessage($_SESSION['username'], $_POST['tousername'], $_POST['messages'], $dateTime);
        
        $location = 'Location: Messages.php?epr=MessageSent&fromusername='.$_POST['tousername'];
        header($location);
        
    }else
    {
        $errorMessage= "Error, User Does not exist. Please enter a valid username!!";
        $errors['tousername'] = "Please enter a valid username.";
        $content = $messageController->MessageInvalidUsernameContent($errors, $_POST['tousername'], $_POST['messages']);
    }

}

if($epr == "MessageSent")
{
    $_SESSION['fromusername'] = $_GET['fromusername'];
    $fromUsername = $_GET['fromusername'];
    $content = $messageController->MessageContentPerPerson($_SESSION['sentTo']);
}

if($epr == "view")
{
   $messageController->SetMessagesSeen($_GET['fromusername'],$_SESSION['username']);
   $_SESSION['fromusername'] = $_GET['fromusername'];
   $fromUsername = $_GET['fromusername'];
   $content = $messageController->MessageContentPerPerson($fromUsername);
}
    
    
$content.= $messageController->UpdatePage();
$content.= $messageController->KeepScrollBarAtTheBottom();

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

