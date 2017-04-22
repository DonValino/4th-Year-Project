<?php
require_once('vendor/autoload.php');

$stripe = array(
 "secret_key"      => "sk_test_BQMidAwbBDkSTqPchPj7WtoF",
 "publishable_key" => "pk_test_FxZ331dkFUGuAQ9k1wqVZsO9"
);
\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
