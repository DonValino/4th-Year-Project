<?php
session_start();

require 'Controller/UserController.php';
$userController = new UserController();

if(isset($_FILES['file']))
{
    $file = $_FILES['file'];
    
    // File properties
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    
    // Work out the file extension
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));
    
    $allowed = array('txt', 'docx');
    
    if(in_array($file_ext, $allowed)) {
        if ($file_error === 0)
        {
            if($file_size <= 10000000)
            {
                $file_name_new = uniqid('',true). '.' . $file_ext;
                $file_destination = 'CoverLetter/' . $file_name_new;
                
                if(move_uploaded_file($file_tmp, $file_destination))
                {
                    $userController->uploadCoverLetter($_SESSION['id'], $file_destination);
                    header('Location: AccountSettings.php?epr=coverletteruploaded');
                }
            }
        }
    }
}
