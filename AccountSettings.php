<?php

session_start();
require 'Controller/UserController.php';
$userController = new UserController();

// An Array to store all error messages
$errors = array();
$emailOfUserLoggedIn = "";
$title = "Account Settings";
$content = "hello";
$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = $userController->CreateUserAccSettingsProfileSidebar();
if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
   
   // Calling the CheckUser() method of the UserController Class to get the user
   $userObject = $userController->CheckUser($loginStatus);
   $content = $userController->CreateUserUpdateForm($userObject->firstName, $userObject->lastName, $userObject->username, $userObject->password, $userObject->email, $userObject->phone);
   $emailOfUserLoggedIn = $userObject->email;
}

// Delete If user confirms in Dialog.
if(isset($_GET["delete"]))
{
    //Delete a User
    $userObject = $userController->CheckUser($_SESSION['username']);
    $loginStatus = $userObject->id;
    $userController->deleteUser($userObject->id);
    session_start();
    session_destroy();
    header('Location: index.php');
}

//Code to save User
//First Check to ensure all fields are not empty
if (isset($_POST['save']) && !empty($_POST['firstName']) && !empty($_POST['lastName'])
        && !empty($_POST['usernameRegister']) && !empty($_POST['password']) && !empty($_POST['email'])
        && !empty($_POST['phone'])) 
{
    // Calling the CheckUser() method of the RegisterController Class to check using the username if the user already exist 
    $userObject = $userController->CheckUser($_POST['usernameRegister']);

    //Here we are ensuring that the value entered by the user retains even in the event of a validation / other errors    
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $usernameRegister = $_POST['usernameRegister'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    if($userObject != NULL && $_SESSION['username'] != $usernameRegister)
    {  
        //If the User exist, Create the error message
        $errorMessage= '* Error!! An account with this Username already exist';
        $errors['usernameRegister'] = "Please enter a different Username.";
        $content = $userController->CreateUserUpdateFormInvalidUsername($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone);
    }else
    {
        //Go Here If This Is A New User
        
        $userObject = $userController->CheckEmail($_POST['email']); // Checking if the email already exist with an account
        if($userObject != NULL && $emailOfUserLoggedIn != $_POST['email'])
        {  
            // If Email exist, Create error messages.
            $errorMessage= '* Error!! This email is already associated with an Account.';
            $errors['email'] = "Please enter a different Email Address.";
            $content = $userController->CreateUserUpdateFormInvalidEmail($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone);
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
                $content =  $userController->CreateUserUpdateFormInvalidEmail($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone);
            }else
            {
                //If Email is in correct Format, Go here
                //eliminate every char except 0-9 for phone number
                if(!is_numeric($phone))
                {
                    // Create Error Messages if phone is not in correct format
                    $errorMessage = "* Error!! Phone Numbers Must only be numbers.";
                    $errors['phone'] = "Please enter a Phone Number.";
                
                    $content = $userController->CreateUserUpdateFormInvalidPhone($errors,$firstName,$lastName,$usernameRegister,$password,$email,$phone);
                }else
                {
                    //If Phone Number is in correct Format. Validation is now complete. 
                    //Creating a new session for the user
                    $_SESSION['valid'] = true;
                    $_SESSION['timeout'] = time();
                    $_SESSION['username'] = $_POST['usernameRegister'];
                    $_SESSION['log'] = "UserAccount.php";
                    $loginStatus= $_POST['usernameRegister'];
                    
                    $id = $_SESSION['id'];

                    // Update User Details in the Database
                    $userController->updateUser($id, $firstName,$lastName,$usernameRegister,$password,$email,$phone);
                    
                    //Go to Home Page
                    header('Location: Home.php');
                }
            }
        }    
    }
}
include 'Template.php'
 ?>

