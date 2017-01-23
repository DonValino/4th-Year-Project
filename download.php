<?php
session_start();

require 'Controller/UserController.php';
$userController = new UserController();
$epr='';

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'cv')
{
    $path =$_GET['path'];
    header("Content-disposition: attachment; filename=$path");
    
    header("Content-type: application/docx");
    
    readfile($path);
}


    
?>

