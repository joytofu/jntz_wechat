<?php

$access_token = get_access_token();
$url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=".$access_token;
$filepath = dirname(__FILE__)."\thumbnail.jpg";
$filedata = array("media"=>"@".$filepath);
$result = https_request($url, $filedata);
var_dump($result);

function https_request($url,$data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_FILE, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

function get_access_token(){
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
    return $access_token;
}

?>