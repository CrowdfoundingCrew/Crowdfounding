<?php

function verifyTransaction($data) {
	global $paypalUrl;

	$req = 'cmd=_notify-validate';
	foreach ($data as $key => $value) {
		$value = urlencode(stripslashes($value));
		$value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); 
		$req .= "&$key=$value";
	}

	$ch = curl_init($paypalUrl);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
	curl_setopt($ch, CURLOPT_SSLVERSION, 6);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
	$res = curl_exec($ch);

	if (!$res) {
		$errno = curl_errno($ch);
		$errstr = curl_error($ch);
		curl_close($ch);
		throw new Exception("cURL error: [$errno] $errstr");
	}

	$info = curl_getinfo($ch);

	// Check the http response
	$httpCode = $info['http_code'];
	if ($httpCode != 200) {
		throw new Exception("PayPal responded with http code $httpCode");
	}

	curl_close($ch);

	return $res === 'VERIFIED';
}

function checkTxnid($txnid) {
    $dbConfig = GetDBConfig();

    $txnid = $db->real_escape_string($txnid);
    $results = $db->query('SELECT * FROM `payments` WHERE txnid = \'' . $txnid . '\'');

    return ! $results->num_rows;
}

function addPayment($data) {
	$dbConfig = GetDBConfig();
	$db = new mysqli($dbConfig['hostname'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);

	if (is_array($data)) {
		$stmt = $db->prepare('INSERT INTO donazioni (txnid, Importo, Status, IDProgetto, Data, IDUtente, `E-mail`) VALUES(?, ?, ?, ?, ?, ?, ?)');
		$arr = explode(" ", $data['custom']);
		$date = date('Y-m-d H:i:s');
		$stmt->bind_param(
			'sdsssis',
			$data['txn_id'],
			$data['payment_amount'],
			$data['payment_status'],
			$arr[1],
			$date,
			$arr[0],
			$data['payer_email']
		);
		$res = $stmt->execute();
		file_put_contents('../../assets/request.txt', $stmt->error);
		$stmt->close();

		return $res;
	}

	return false;
}
