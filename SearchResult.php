<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

session_start();
require 'Controller/UserSearchesController.php';
require 'Controller/JobController.php';
require 'Controller/RecommenderController.php';
$userSearchesController = new UserSearchesController();
$jobController = new JobController();
$recommenderController = new RecommenderController();

$epr = "";

$title = "Search Result";
$content = "";

$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = $jobController->CreateMyJobsSideBar();
if(isset($_SESSION['username']))
{
   $loginStatus="Home";
   $log = "index.php";
}

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

if($epr == 'price')
{
    $min =$_GET['min'];
    $max =$_GET['max'];
    $content = $jobController->SearchResultPrice($min,$max);
}else if($epr == 'myJobs')
{
    $content = $jobController->SearchUserJob($_SESSION['id']);
}else if($epr == 'view')
{
    $id =$_GET['id'];
    $_SESSION['jobId'] = $id;
    $typeId = $_GET['typeId'];
    
    //Today's date
    $date = new DateTime();
    $dateTime = $date->format('d-m-Y H:i:s');
    
    // Check if a record already exist
    $exist = $recommenderController->GetRecordByCatIdAndUserId($typeId, $_SESSION['id']);
    
    if($exist != NULL)
    {
        $qty = $exist->qty;
        $qty = $qty + 1;
        $recommenderController->updateQtyByCatIdAndUserId($qty, $typeId, $_SESSION['id']);
    }else
    {
        // Add a new record to recommender table database
        $recommenderController->InsertANewRecord($typeId, $_SESSION['id'],1, $dateTime);  
    }
    
    //Go to Search Result Page
    header('Location: ViewJob.php');
}else if($epr == 'cat')
{
    $content = $jobController->SearchByCategoryResult($_SESSION['search']);
}else if ($epr == 'qua')
{
    $content = $jobController->SearchByQualificationResult($_SESSION['search']);
}else if ($epr == 'previouskeyword')
{
    $keyword =$_GET['keyword'];
    $content = $jobController->SearchResult($keyword);
}else if ($epr == 'recommendedJob')
{
    $cat1 =$_GET['cat1'];
    $cat2 =$_GET['cat2'];
    $cat3 =$_GET['cat3'];
    $cat4 =$_GET['cat4'];
    $content = $jobController->RecommendedJobsResult($cat1, $cat2, $cat3, $cat4);
}
else
{
    $content = $jobController->SearchResult($_SESSION['search']);
    // Store User Search / Check for new jobs
    $numResult= $jobController->CountJobsByName($_SESSION['search']);
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('d-m-Y H:i:s');
        $userSearches = $userSearchesController->GetUserSearhesById($_SESSION['id']);
        $isSame = false;
        if ($userSearches != NULL)
        {
            foreach ($userSearches as $row)
            {
                if($row->keyword == $_SESSION['search'])
                {
                    $isSame = true;
                } 
            } 
        }

    if($userSearchesController->CountNumberOfUserSearhesById($_SESSION['id']) < 6 && $isSame == false)
    {
        $userSearchesController->InsertANewReview($_SESSION['id'], $_SESSION['search'], $dateTime, $numResult);
    }else
    {
       $userSearches = $userSearchesController->GetUserSearhesById($_SESSION['id']);
       $_SESSION['numnewresult'] = 0;
        if ($userSearches != NULL)
        {
            foreach ($userSearches as $row)
            {
                if($row->keyword == $_SESSION['search'])
                {
                    $userSearchesController->updateDateOfSearch($row->id, $dateTime);

                    if($numResult > $row->numResult)
                    {
                        $userSearchesController->updateNumResult($row->id, $numResult);
                    }
                }
            }
        }

    }
}
$content .= $jobController->CategoryModal();
$content .= $jobController->PriceModal();
 include 'Template.php'
 ?>

