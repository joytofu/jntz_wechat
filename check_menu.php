<?php
$access_token="Q5CsXIKTfzsp3rG8O8ChXl69TXX1h_xvWNJpq4k3iUrEW8EFtLBl5PFUc_qZMF8SSmCcicHhcZytD6KrKV9BdpNrew3gDk55cqz7QN2DPVg";
$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$access_token;
$result = https_request($url);
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
?>