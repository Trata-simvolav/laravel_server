<?php

$IAM_TOKEN = '';
$folder_id = 'b1g0uc9vf7f8d2lakhi7';
$target_language = 'ru';
$texts = ["Hello", "World"];

$url = 'https://translate.api.cloud.yandex.net/translate/v2/translate';

$headers = [
    'Content-Type: application/json',
    "Authorization: Bearer $IAM_TOKEN"
];

$post_data = [
    "targetLanguageCode" => $target_language,
    "texts" => $texts,
    "folderId" => $folder_id,
];

$data_json = json_encode($post_data);

$curl = curl_init();
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($curl, CURLOPT_VERBOSE, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);

$result = curl_exec($curl);

curl_close($curl);

var_dump($result);

?>
