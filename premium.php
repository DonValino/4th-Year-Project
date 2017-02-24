<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once 'Stripe/Config.php'; 
session_start();

$epr='';
$title = "home";

$content = '<form action="premium_charge.php" method="POST">
<script
  src="https://checkout.stripe.com/checkout.js" class="stripe-button"
  data-key="'.$stripe['publishable_key'].'"
  data-amount="1000"
  data-name="FreelanceMe"
  data-description="Primium membership"
  data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
  data-locale="auto"
  data-zip-code="true"
  data-currency="eur">
</script>
</form>';

$loginStatus= "Login";
$log = "";
$errorMessage = "";
$sidebar = "";

if(isset($_SESSION['username']))
{
   $loginStatus=$_SESSION['username'];
   $log = $_SESSION['log'];
}else
{
    header('Location: index.php');
}

 include 'Template.php'
 ?>

