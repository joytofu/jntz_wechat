<?php
$jsonmenu = '{
      "articles": [
        {
            "thumb_media_id":"qI6_Ze_6PtV7svjolgs-rN6stStuHIjs9_DidOHaj0Q-mwvBelOXCFZiq2OsIU-p",
            "author":"xxx",
            "title":"Happy Day",
            "content_source_url":"http://viewer.maka.im/k/QK8RH4YH?DSCKID=c72f4b6a-08e3-41d1-addc-8745a56ab38c&DSTIMESTAMP=1442121473506",
            "content":"content"
        }
    ]

 }';

$access_token = get_access_token();
$url = "https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=".$access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);

function https_request($url,$data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
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