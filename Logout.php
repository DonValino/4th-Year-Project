<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
     // put your code here
    session_start();
    session_destroy();
 
    $title = "Logout";
    $content = "You have oficially logged out.";
    $loginStatus= "Login";
    $log = "index.php";
    $errorMessage = "";
    $sidebar = "";

    header('Location: index.php');
 
    include 'Template.php'
?>
