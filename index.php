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
$sidebar = '<div id="aboutFreelanceMe" class="alert alert-info">'
            ."<div class='row' style='margin-bottom:20px;'>
              <div class='col-md-12 style='background-color:white;'>
                  <a href='AboutUs.php' target='_blank'><img src='Images/FreelanceMeLogo.png' class='col-md-12 col-sm-12 col-xs-12'/></a>
              </div>
            </div>"
        . '<h4 style="text-align:center;"> About Freelance Me:</h4>'
        . '<p style="text-align:center;font-size:13px;color:black;margin-bottom:15px;">This is a website that will serve as an instrument to allow people locate jobs advertised in the website and work as a freelancer.'
        . ' Users can post jobs on the website and vice versa, can also look for existing jobs posted by other users of the website. </p>'
            .'<div class="row">'
                . '<a class="btn btn-success col-md-6 col-md-offset-3 col-xs-offset-5" target="_blank" href="http://ec2-54-211-233-223.compute-1.amazonaws.com/Don_Valino_CA2/CV.php">Founder</a>'
            . '</div>'
        . '</div>';
//Login Code - Query DB to see if user exist and if exist, allow user to login
 if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
     
    $userObject = $loginController->CheckUser($_POST['username']);
    
    if($userObject != NULL)
    {
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y');
        $dateTimeLastLogedIn = $date->format('Y-m-d');
        
        // Used For The Admin Dashboard To Change The Year To Display data
        $_SESSION['yearDate'] = $dateTime;
       
        if($userObject->username == $_POST['username'] && password_verify($_POST['password'], $userObject->password))
        {
            // Password and User Is Correct
            if($loginController->CheckIfUserIsActive($_POST['username']) == true)
            {
                // User Is Still Active
                require_once 'Model/ActiveUsersModel.php';
                $activeUsersModel = new ActiveUsersModel();
                
                // Check Last Time He Loged In if its still this month.
                $lastLogedIn = $activeUsersModel->GetActiveUserByUserId($userObject->id);
                if($lastLogedIn == NULL)
                {
                    // He has never logged into the system before
                    $activeUsersModel->InsertANewActiveUser($userObject->id, $dateTimeLastLogedIn, 1);
                    $_SESSION['valid'] = true;
                    $_SESSION['timeout'] = time();
                    $_SESSION['username'] = $userObject->username;
                    $_SESSION['id'] = $userObject->id;
                    $_SESSION['active'] = 1;
                    $_SESSION['log'] = "UserAccount.php";
                    header('Location: CheckExpiredJobs.php');
                }else
                {
                    // He has loged Into Ths system before.
                    
                    // Last Logged In
                    $dateLastLogedIn = $lastLogedIn->date;
                    
                    $first_day_of_month = strtotime(date('Y-m-01'));
                    $last_day_of_month = strtotime(date('Y-m-t 23:59:59'));
                    
                    // Checking If the User Has already logged In This Month.
                    if ((strtotime($dateLastLogedIn) >= $first_day_of_month) && (strtotime($dateLastLogedIn) <= $last_day_of_month))
                    {
                        // User Has Already Logged In This Month. Do Nothing And Just Login
                        $_SESSION['valid'] = true;
                        $_SESSION['timeout'] = time();
                        $_SESSION['username'] = $userObject->username;
                        $_SESSION['id'] = $userObject->id;
                        $_SESSION['active'] = 1;
                        $_SESSION['log'] = "UserAccount.php";
                        header('Location: CheckExpiredJobs.php');

                    } 
                    else 
                    {
                        // This is a new month. Insert A New Login Record and makew that the latest.
                        $activeUsersModel->updateLatestActiveUserByUserId(0, $userObject->id);
                        $activeUsersModel->InsertANewActiveUser($userObject->id, $dateTimeLastLogedIn, 1);
                        $_SESSION['valid'] = true;
                        $_SESSION['timeout'] = time();
                        $_SESSION['username'] = $userObject->username;
                        $_SESSION['id'] = $userObject->id;
                        $_SESSION['active'] = 1;
                        $_SESSION['log'] = "UserAccount.php";
                        header('Location: CheckExpiredJobs.php');
                    }


                }
            }else
            {
                // User Is Not Active.
                $_SESSION['id'] = $userObject->id;
                $_SESSION['log'] = "UserAccount.php";
                $_SESSION['active'] = 0;
                $_SESSION['username'] = $userObject->username;
                header('Location: Home.php?inactiveaccount');
            }
        }else
        {
            // Incorrect username / password
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