<?php
require_once('vendor/autoload.php');

$stripe = array(
 "secret_key"      => "sk_test_JiEwzsArBJ2H6JXzN7HlatXa",
 "publishable_key" => "pk_test_hklY9besHcEU8Mmu7kX0snhQ"
);
\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
