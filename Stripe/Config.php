<?php
require_once('vendor/autoload.php');

$stripe = array(
 "secret_key"      => "sk_test_QitEyu042XrP2Nns3CPM3m8K",
 "publishable_key" => "pk_test_QXuvpuMLJNfzyDs5w8BbVoqI"
);
\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
