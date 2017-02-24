<?php
require_once('vendor/autoload.php');

$stripe = array(
 "secret_key"      => "sk_test_lhfFVZRDNoMK49TpykKqBAD8",
 "publishable_key" => "pk_test_d1SP3R3MBcXX8i8E0OyvvNdU"
);
\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
