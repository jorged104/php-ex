<?php
$price = $_GET['price'];
$adress = $_GET['address'];
$preuser_id  = $_GET['preuser_id'];
$packag_id  = $_GET['packag_id'];
if($adress == "")
{
  return "";
}
use Firebase\JWT\JWT;

  require_once './php-jwt-master/src/JWT.php';
  $time = time();
  $key = "bixm5jDymWNdg6Oj";
  $keylog = array(
      'iat' => $time,
      'exp' => $time + ( 60*40),
      'price' => $price,
      'address' => $adress,
      'preuser_id' => $preuser_id,
      'packag_id'  => $packag_id,
      'success' => true
  );
  $jwt = JWT::encode($keylog,$key);

  $cURLConnection = curl_init();

    $url = "https://orionblackinternationalcapital.com/payments/confirmation?token=".$jwt;

    curl_setopt($cURLConnection, CURLOPT_URL, $url);
    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
    $phoneList = curl_exec($cURLConnection);
    curl_close($cURLConnection);

    $jsonArrayResponse = json_decode($phoneList);
    
?>