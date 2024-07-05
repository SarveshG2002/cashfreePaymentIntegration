<?php
$orderId = "001001";
$orderAmount ="10";
// echo $order

$host  = "http://cashfree_integration.test";
$notifyUrl = $host."/cf-checkout/notify.php";
$returnUrl = $host."/cf-checkout/return.php";

$orderDetails =[];
$orderDetails["notifyUrl"] = $notifyUrl;
$orderDetails["returnUrl"] = $returnUrl;

$userDetails = getUserDetail($orderId);
// print_r($userDetails);
$order = getOrderDetails($orderId);

$orderDetails["customerName"]=$userDetails["customerName"];
$orderDetails["customerEmail"]=$userDetails["customerEmail"];
$orderDetails["customerPhone"]=$userDetails["customerPhone"];

$orderDetails["orderId"]=$order["orderId"];
$orderDetails["orderAmount"]=$order["orderAmount"];
$orderDetails["orderNote"]=$order["orderNote"];
$orderDetails["orderCurrency"]=$order["orderCurrency"];

$orderDetails["appId"]="<app_key>";
$orderDetails["signature"] = generateSignature($orderDetails);

echo "<pre>";
print_r($orderDetails);

function generateSignature($postData){
    $secretKey = "<secrete_key>";
    ksort($postData);
    $signatureData = "";
    foreach($postData as $key=>$value){
        $signatureData.=$key.$value;
    }
    $signature = hash_hmac("sha256",$signatureData,$secretKey,true);
    $signature = base64_encode($signature);
    return $signature;
}


function getUserDetail($orderId){
    return [
        "customerName" => "rohit",
        "customerEmail" => "rohit@cashfree.com",
        "customerPhone" => "9876543210"
    ];
}

function getOrderDetails($orderId){
    return [
        "orderId"=>time(),
        "orderAmount" => "10",
        "orderNote" => "test Order",
        "orderCurrency" => "INR"
    ];
}
?>

<form id="redirectForm" method="post" action="https://test.cashfree.com/billpay/checkout/post/submit">
    <input type="hidden" name="appId" value="<?=$orderDetails["appId"]?>"/>
    <input type="hidden" name="orderId" value="<?=$orderDetails["orderId"]?>"/>
    <input type="hidden" name="orderAmount" value="<?=$orderDetails["orderAmount"]?>"/>
    <input type="hidden" name="orderCurrency" value="<?=$orderDetails["orderCurrency"]?>"/>
    <input type="hidden" name="orderNote" value="<?=$orderDetails["orderNote"]?>"/>
    <input type="hidden" name="customerName" value="<?=$orderDetails["customerName"]?>"/>
    <input type="hidden" name="customerEmail" value="<?=$orderDetails["customerEmail"]?>"/>
    <input type="hidden" name="customerPhone" value="<?=$orderDetails["customerPhone"]?>"/>
    <input type="hidden" name="returnUrl" value="<?=$orderDetails["returnUrl"]?>"/>
    <input type="hidden" name="notifyUrl" value="<?=$orderDetails["notifyUrl"]?>"/>
    <input type="hidden" name="signature" value="<?=$orderDetails["signature"]?>"/>
    <button>Submit</button>
</form>

<!-- <script>document.getElementById("redirectForm").submit();</script> -->
