<?php

require_once('Stripe/Config.php');
require 'Controller/UserController.php';
session_start();

$userController = new UserController();

if(!isset($_SESSION['username']))
{
    header('Location: index.php');
}

$epr='';

if(isset($_GET['epr']))
{
    $epr=$_GET['epr'];
}

    if(isset($_POST['stripeToken']))
    {
        $token = $_POST['stripeToken'];

        try
        {
            \Stripe\Charge::create(array(
              "amount" => 100,
              "currency" => "eur",
              "source" => $token,
              "description" => "Charging user: ".$userController->GetUserById($_SESSION['id'])->firstName.' '.$userController->GetUserById($_SESSION['id'])->lastName. ' - Standard Job Ad Renewal Posting'
            ));
        } catch (Stripe_CardError $ex) {

        }
        
        require_once 'Model/RevenueModel.php';
        
        $revenueModel = new RevenueModel();
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $revenueModel->InsertANewRevenue(1, $dateTime, $_SESSION['id'], 0);

       header('Location: ViewJob.php?epr=renewedStandardAndview&jobid='.$_SESSION['jobId']);
        exit();
    } 



