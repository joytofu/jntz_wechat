<?php
$jsonmenu = '{
      "button":[
      
      {
            "type":"view",
            "name":"微官网",
            "url":"http://338030.m.weimob.com/weisite/home?pid=338030&bid=567722&wechatid=fromUsername"
       },
       
       
       {
           "type":"click",
           "name":"联系我们",
           "key":"联系我们"
       },
       
       {
           "type":"view",
           "name":"参赛与开户",
           "url":"http://1.jntz.applinzi.com/reg.html"
       }

       ]
 }';

$access_token = getAccessToken();
$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
$result = https_request($url, $jsonmenu);
echo $access_token;
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

function getAccessToken(){
    $appid="wx1cb861ec85faaf16";
    $appsecret="108066d356e97386ad53c63be2e6a077";
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