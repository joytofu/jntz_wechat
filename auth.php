<?php
if($code = $_GET['code']){
    $json_info = getJsonInfo($code);
    $access_token = $json_info['access_token'];
    $openid = $json_info['openid'];
    $userinfo = getUserInfo($access_token,$openid);
    print_r($userinfo);
}

//通过code获取access_token所在的数据包
function getJsonInfo($code){
    $appid="wxf48fcdeb3010abaa";
    $appsecret="549abc38346419339be909b96893acfa";
    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
    $jsoninfo = curl($url);
    return $jsoninfo;
}

//通过access_token和openid获取用户信息
function getUserInfo($access_token,$openid){
    $url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
    $userinfo = curl($url);
    return $userinfo;
}

function curl($url){
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output=curl_exec($ch);
    curl_close($ch);
    $jsoninfo=json_decode($output, true);
    return $jsoninfo;
}
