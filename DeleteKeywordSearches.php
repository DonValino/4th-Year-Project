<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

require 'Controller/UserSearchesController.php';
$userSearchesController = new UserSearchesController();

$epr='';

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='delete')
{
    $userSearchesController->deleteKeywordSearches($_SESSION['id']);
    // Go To Home Page
    header('Location: home.php');
}

    
?>