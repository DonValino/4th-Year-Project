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

$loginStatus= "Login";
$log = "";

if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log = "Home.php";
}else
{
    header('Location: index.php');
}

// User Is Admin
if(isset($_SESSION['admin']))
{
    if($_SESSION['admin'] == 1)
    {
        // Go Back To Home Page
         header('Location: Home.php');
    }
}

$epr='';
$title = "Favorite Jobs";
$content = $favoriteJobsController->FavoriteJobContent($_SESSION['id']);

$errorMessage = "";
$sidebar = $favoriteJobsController->FavoriteJobsSideBar();

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
 

if(isset($_SESSION['active']))
{
    if ($_SESSION['active'] == 0)
    {
        require_once 'Model/UserModel.php';
        $userModel = new UserModel();
        $adminusers = $userModel->GetActiveUsers();
        $content = "<p style='color:blue;font-size:18px;text-align:center;'>Your account has been deactivated. Please Contact one of the listed administrator: </p>";
        
        if ($adminusers != null)
        {
            foreach($adminusers as $row)
            {
                if($row->admin == 1)
                {
                    $log = "Logout.php";
                    $loginStatus = "Logout";
                    $sidebar = "";
                    $content .= "<p style='color:green;font-size:18px;text-align:center;'>$row->email</p>";
                }
            }
        }
        
    }
}
 include 'Template.php'
 ?>

