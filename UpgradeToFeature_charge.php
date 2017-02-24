<?php
require_once('Stripe/config.php');
require 'Controller/UserController.php';

session_start();

if(!isset($_SESSION['username']))
{
    header('Location: index.php');
}

$userController = new UserController();

if(isset($_POST['stripeToken']))
{
    $token = $_POST['stripeToken'];
    
    try
    {
        \Stripe\Charge::create(array(
          "amount" => 300,
          "currency" => "eur",
          "source" => $token,
          "description" => "Charging user".$userController->GetUserById($_SESSION['id'])->firstName.' '.$userController->GetUserById($_SESSION['id'])->lastName. ' - Job Featured Upgrade'
        ));
    } catch (Stripe_CardError $ex) {

    }
    
    header('Location: ViewJob.php?epr=viewAndUpgrade&jobid='.$_SESSION['jobId']);
    exit();
}

