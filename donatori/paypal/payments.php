<?php
include '../../config/config.php';
$enableSandbox = true;

$dbConfig = GetDBConfig();

$paypalConfig = [
	'email' => 'sb-w6lvy4772730@business.example.com',
	'return_url' => 'http://localhost:8000/Crowdfounding/donatori/paypal/payment-successful.html',
	'cancel_url' => 'http://localhost:8000/Crowdfounding/donatori/paypal/payment-cancelled.html',
	'notify_url' => 'http://localhost:8000/Crowdfounding/donatori/paypal/payments.php'
];

$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

require 'functions.php';

if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {
	$itemName = $_POST["progetto"];
	$itemAmount = $_POST["donazione"];
	
	$data = [];
	foreach ($_POST as $key => $value) {
		$data[$key] = stripslashes($value);
	}

	$data['business'] = $paypalConfig['email'];
	$data['return'] = stripslashes($paypalConfig['return_url']);
	$data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
	$data['notify_url'] = stripslashes($paypalConfig['notify_url']);
	$data['item_name'] = $itemName;
	$data['amount'] = $itemAmount;
	$data['currency_code'] = 'EUR';
	$data['custom'] = $_POST["userid"] . " " . $_POST["prjid"];

	$queryString = http_build_query($data);
	
	header('location:' . $paypalUrl . '?' . $queryString);
	exit();

} else {
	$db = new mysqli($dbConfig['hostname'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

	$data = [
		'item_name' => $_POST['item_name'],
		'item_number' => 1,
		'payment_status' => $_POST['payment_status'],
		'payment_amount' => $_POST['mc_gross'],
		'payment_currency' => $_POST['mc_currency'],
		'txn_id' => $_POST['txn_id'],
		'receiver_email' => $_POST['receiver_email'],
		'payer_email' => $_POST['payer_email'],
		'custom' => $_POST['custom'],
	];

	if (verifyTransaction($_POST) && checkTxnid($data['txn_id'])) {
		if (addPayment($data) !== false) {
			echo "Payment successfully added.";
		} else {
			echo "add fallito";
		}
	}
}
