<?php
session_start();

require 'Controller/UserController.php';
$userController = new UserController();

if(isset($_FILES['file']))
{
    $file = $_FILES['file'];
    
    // File properties
    $file_name = $file['name'];
    // Temporary location
    $file_tmp = $file['tmp_name'];
    // File Size
    $file_size = $file['size'];
    // Error MEssages
    $file_error = $file['error'];
    
    // Work out the file extension
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));
    
    // Specify the file type allowed
    $allowed = array('txt', 'jpg', 'png','gif');
    
    // Check if file selected is allowed
    if(in_array($file_ext, $allowed)) {
        if ($file_error === 0)
        {
            // Check if file size is less than or euql to 10mb
            if($file_size <= 10000000)
            {
                // Create a new name for the file ( We do this so that if another user uploads a file with the same name, it won't override other user's file)
                $file_name_new = uniqid('',true). '.' . $file_ext;
                
                // Set the destination where the picture will be stored in your project folder
                $file_destination = 'ProfilePicture/' . $file_name_new;
                
                // Move the file from the temporary location, to your project folder
                if(move_uploaded_file($file_tmp, $file_destination))
                {
                    // Um shane, this is a query to insert the url to the database the path of your file. You can connet to DB using your way :)
                    $userController->uploadProfilePicture($_SESSION['id'], $file_destination);
                    // If all success, redirect user to this page (can specify any page you want :) )
                    header('Location: AccountSettings.php?epr=profilepicture');
                }
            }
        }
    }
}
