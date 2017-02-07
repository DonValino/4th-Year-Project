<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();

require 'Controller/FavoriteJobsController.php';
require 'Controller/RecommenderController.php';

$favoriteJobsController = new FavoriteJobsController();

$recommenderController = new RecommenderController();

$epr='';
$title = "Favorite Jobs";
$content = $favoriteJobsController->FavoriteJobContent($_SESSION['id']);


$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = $favoriteJobsController->FavoriteJobsSideBar();

if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log = "home.php";
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr=='add')
{
    $jobid =$_GET['jobId'];
    $typeId =$_GET['typeId'];
    //Today's date
    $date = new DateTime();
    $dateTime = $date->format('d-m-Y H:i:s');
    
    // Check if a record already exist
    $exist = $favoriteJobsController->GetFavoriteJobsByJobIdANDUserId($jobid, $_SESSION['id']);
    
    if(!$exist != NULL)
    {
        $favoriteJobsController->InsertANewFavoriteJob($jobid, $_SESSION['id'], $dateTime);
    }

    //Go to Search Result Page
    header('Location: SearchResult.php?epr=view&id='.$jobid.'&typeId='.$typeId);
}

if($epr=='remove')
{
    $jobid =$_GET['jobId'];
    $typeId =$_GET['typeId'];
    $favoriteJobsController->deleteAFavoriteJob($jobid, $_SESSION['id']);
    
    $qty = $recommenderController->GetRecordByCatIdAndUserId($typeId, $_SESSION['id'])->qty;
    $qty = $qty - 1;
    $recommenderController->updateQtyByCatIdAndUserId($qty, $typeId, $_SESSION['id']);
    
    //Go to Search Result Page
    header('Location: SearchResult.php?epr=viewremove&id='.$jobid.'&typeId='.$typeId);
}

if($epr=='removefromfavoritejobcontent')
{
    $jobid =$_GET['jobId'];
    $typeId =$_GET['typeId'];
    $favoriteJobsController->deleteAFavoriteJob($jobid, $_SESSION['id']);
    $qty = $recommenderController->GetRecordByCatIdAndUserId($typeId, $_SESSION['id'])->qty;
    $qty = $qty - 1;
    $recommenderController->updateQtyByCatIdAndUserId($qty, $typeId, $_SESSION['id']);
    //Go to Search Result Page
    header('Location: FavoriteJobs.php');
}
 
 include 'Template.php'
 ?>

