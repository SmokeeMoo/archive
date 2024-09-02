<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$shopid = $_POST['shopid'];
	$secretkey = $_POST['secretkey'];
	$amount = $_POST['amount'];
	$currency = $_POST['currency'];
	$description = $_POST['description'];

    // Теперь у вас есть доступ к значениям shopid_block и secretkey_block, переданным из другого файла
require 'vendor/autoload.php';
use YooKassa\Client;
use YooKassa\Model\Payment;
use YooKassa\Request\Payments\CreatePaymentRequest;
$client = new Client();
//$client->setAuth($shopid, $secretkey);

$paymentData = array(
    'amount' => array(
        'value' => $amount,
        'currency' => $currency,
    ),
    'confirmation' => array(
        'type' => 'embedded',
        'locale'=> 'ru_RU'
    ),
    'capture' => true,
    'description' => $description
);
try {
//$payment = $client->createPayment($paymentData);
//$confirmation_token = $payment->confirmation->confirmation_token;
echo json_encode(["confirmation_tokent" => $confirmation_token]);
} catch (Exception $e) { }

}

?>
