<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
 <?php
session_start();

require 'Controller/RegisterController.php';

// An Array to store all error messages
$errors = array();

//Creating an instance of Register Controller
$registerController = new RegisterController();

//Basic House Keeping Variables
$loginStatus= "Login";
$log = "index.php";
$errorMessage = "";
$sidebar = '<div id="aboutFreelanceMe">'
        . '<h4> About Freelance Me:</h4>'
        . '<p>This is a website that will serve as an instrument to allow people locate jobs advertised in the website and work as a freelancer.'
        . ' Users can post jobs on the website and vice versa, can also look for existing jobs posted by other users of the website. </p>'
        . '</div>';
$title = "home";

//Creating the Register Form
$content = $registerController->CreateRegisterForm();

 
//Code to register a new user
//First Check to ensure all fields are not empty
if (isset($_POST['register']) && !empty($_POST['firstName']) && !empty($_POST['lastName'])
        && !empty($_POST['usernameRegister']) && !empty($_POST['password']) && !empty($_POST['email'])
        && !empty($_POST['phone'])) 
{
    // Calling the CheckUser() method of the RegisterController Class to check using the username if the user already exist 
    $userObject = $registerController->CheckUser($_POST['usernameRegister']);

    //Here we are ensuring that the value entered by the user retains even in the event of a validation / other errors    
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $usernameRegister = $_POST['usernameRegister'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
        
    if($userObject != NULL)
    {  
        //If the User exist, Create the error message
        $errorMessage= '* Error!! An account with this Username already exist';
        $errors['usernameRegister'] = "Please enter a different Username.";
        $content = $registerController->CreateRegisterFormInvalidUsername($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone);
    }else
    {
        //Go Here If This Is A New User
        
        $userObject = $registerController->CheckEmail($_POST['email']); // Checking if the email already exist with an account
        if($userObject != NULL)
        {  
            // If Email exist, Create error messages.
            $errorMessage= '* Error!! This email is already associated with an Account.';
            $errors['email'] = "Please enter a different Email Address.";
            $content = $registerController->CreateRegisterFormInvalidEmail($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone);
        }else
        {
            //Go Here If Email Doesn't Exist
            //Validate the email to ensure it is in the correct format
            $email = $_POST['email'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Create Error Messages if the email isn't in correct format
                //Creating Error Messages
                $errorMessage = "* Error!! Invalid email format.";
                $errors['email'] = "Please enter a valid Email Address.";
                $content = null;
                $content =  $registerController->CreateRegisterFormInvalidEmail($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone);
            }else
            {
                //If Email is in correct Format, Go here
                //eliminate every char except 0-9 for phone number
                if(!is_numeric($phone))
                {
                    // Create Error Messages if phone is not in correct format
                    $errorMessage = "* Error!! Phone Numbers Must only be numbers.";
                    $errors['phone'] = "Please enter a Phone Number.";
                
                    $content = $registerController->CreateRegisterFormInvalidPhone($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone);
                }else
                {
                    //If Phone Number is in correct Format. Validation is now complete. 
                    //Creating a new session for the user
                    $_SESSION['valid'] = true;
                    $_SESSION['timeout'] = time();
                    $_SESSION['username'] = $_POST['usernameRegister'];
                    $_SESSION['log'] = "UserAccount.php";
                    $loginStatus= $_POST['usernameRegister'];
                    
                    // Insert new User to the Database
                    $registerController->InsertANewUser();
                    
                   
                    $_SESSION['id'] =  $registerController->CheckUser($_POST['usernameRegister'])->id;
                    
                    //Go to Home Page
                    header('Location: Home.php');
                }
            }
        }    
    }
}


 include 'Template.php'
?>
