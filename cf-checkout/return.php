<?php

echo "<pre>";
print_r($_POST);


$orderId = $_POST["orderId"];
$orderAmount = $_POST["orderAmount"];
$referenceId = $_POST["referenceId"];
$txStatus = $_POST["txStatus"];
$paymentMode = $_POST["paymentMode"];
$txMsg = $_POST["txMsg"];
$txTime = $_POST["txTime"];
$signature = $_POST["signature"];
$data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
$secretKey = "<secret_key>";
$hash_hmac = hash_hmac('sha256', $data, $secretKey, true);
$computedSignature = base64_encode($hash_hmac);

if ($signature == $computedSignature) {
    echo "Payment SuccessFull";
}
else{
    echo "Please try again Later";
}