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

if($epr == 'pay')
{
    if(isset($_POST['stripeToken']))
    {
        $jobid =$_GET['jobid'];
        $name =$_GET['name'];
        $description =$_GET['description'];
        $typeId =$_GET['typeId'];
        $qualificationId =$_GET['qualificationId'];
        $address =$_GET['address'];
        $county =$_GET['county'];
        $numberOfDays =$_GET['numberOfDays'];
        $numberOfPeopleRequired =$_GET['numberOfPeopleRequired'];
        $startDate =$_GET['startDate'];
        $price =$_GET['price'];
        $userid =$_GET['userid'];

        $token = $_POST['stripeToken'];

        try
        {
            \Stripe\Charge::create(array(
              "amount" => 100,
              "currency" => "eur",
              "source" => $token,
              "description" => "Charging user: ".$userController->GetUserById($userid)->firstName.' '.$userController->GetUserById($userid)->lastName. ' - Standard Job Ad Posting'
            ));
        } catch (Stripe_CardError $ex) {

        }
        
        require_once 'Model/RevenueModel.php';
        
        $revenueModel = new RevenueModel();
        
        //Today's date
        $date = new DateTime();
        $dateTime = $date->format('Y-m-d H:i:s');
        
        $revenueModel->InsertANewRevenue(1, $dateTime, $_SESSION['id'], 0);

        header('Location: InsertANewJob.php?epr=paymentCompleted&jobid='.$jobid.'&name='.$name.'&description='.$description.'&typeId='.$typeId.'&qualificationId='.$qualificationId.'&address='.$address
                .'&county='.$county.'&numberOfDays='.$numberOfDays.'&numberOfPeopleRequired='.$numberOfPeopleRequired.'&startDate='.$startDate.'&price='.$price.'&userid='.$userid);
        exit();
    } 
}


