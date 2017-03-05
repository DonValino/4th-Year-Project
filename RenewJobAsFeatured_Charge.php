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
              "amount" => 300,
              "currency" => "eur",
              "source" => $token,
              "description" => "Charging user: ".$userController->GetUserById($_SESSION['id'])->firstName.' '.$userController->GetUserById($_SESSION['id'])->lastName. ' - Featured Job Ad Renewal Posting'.' - Job Id: '.$_SESSION['jobId']
            ));
        } catch (Stripe_CardError $ex) {

        }

       header('Location: ViewJob.php?epr=renewedFeaturedAndview&jobid='.$_SESSION['jobId']);
        exit();
    } 



