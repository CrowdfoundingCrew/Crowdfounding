<?php
$url = "http://extra.isii.it:40081/donatori/paypal/payments.php";
$ch = curl_init( $url );
# Setup request to send json via POST.
file_put_contents("test.txt", json_encode($_POST));
$payload="";
foreach ($_POST as $key => $value):
  $payload = $payload . $key . "=" . $value . "&";
endforeach;

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
# Return response instead of printing.
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
# Send request.
$result = curl_exec($ch);
curl_close($ch);
# Print response.
echo "<pre>$result</pre>";
?>