<?php
$appid="wxf48fcdeb3010abaa";
$appsecret="549abc38346419339be909b96893acfa";
$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output=curl_exec($ch);
curl_close($ch);
$jsoninfo=json_decode($output, true);
$access_token=$jsoninfo["access_token"];
echo $access_token;
?>