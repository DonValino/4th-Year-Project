<?php
session_start();

require_once('Stripe/Config.php');

if(!isset($_SESSION['username']))
{
    header('Location: index.php');
}

if(isset($_POST['stripeToken']))
{
    $token = $_POST['stripeToken'];
    
    try
    {
        \Stripe\Charge::create(array(
          "amount" => 1000,
          "currency" => "eur",
          "source" => $token,
          "description" => "Charging user"
        ));
    } catch (Stripe_CardError $ex) {

    }
    
    header('Location: home.php');
    exit();
}

