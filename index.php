<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
ob_start();
session_start();
try
{
    if(isset($_SESSION['valid']) == true)
    {
      header('Location: Home.php');
    }
}  catch (Exception $e)
{
   $e->getMessage();
}
require 'Controller/LoginController.php';
$loginController = new LoginController();
$loginStatus = "Login";
$log = "";
$errorMessage = "";
$sidebar = '<div id="aboutFreelanceMe">'
        . '<h4 style="text-align:center;"> About Freelance Me:</h4>'
        . '<p style="text-align:center;">This is a website that will serve as an instrument to allow people locate jobs advertised in the website and work as a freelancer.'
        . ' Users can post jobs on the website and vice versa, can also look for existing jobs posted by other users of the website. </p>'
        . '</div>';
//Login Code - Query DB to see if user exist and if exist, allow user to login
 if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
     
    $userObject = $loginController->CheckUser($_POST['username']);
    
    if($userObject != NULL)
    {  
        if($userObject->username == $_POST['username'] && $userObject->password == $_POST['password'])
        {
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = $userObject->username;
            $_SESSION['id'] = $userObject->id;
            $_SESSION['log'] = "UserAccount.php";
            header('Location: CheckExpiredJobs.php');
        }else
        {
            $_SESSION['valid'] = false;
            $errorMessage= '* Error!! Username / Password is incorrect. Please try again :)';
        }
    }else
    {
        $errorMessage= '* Error!! Username / Password is incorrect. Please try again :)';
    }
}
$title = "home";
$content = $loginController->CreateLoginForm();
include 'Template.php'
?>