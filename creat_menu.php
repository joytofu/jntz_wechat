<?php
$jsonmenu = '{
      "button":[
      
      {
            "type":"view",
            "name":"微官网",
            "url":"http://338030.m.weimob.com/weisite/home?pid=338030&bid=567722&wechatid=fromUsername"
       },
       
       
       {
           "name":"联系我们",
           "sub_button":[
            {
               "type":"click",
               "name":"香港总部",
               "key":"香港总部"
            },
            
            {
               "type":"click",
               "name":"广州分部",
               "key":"广州分部"
            },
            
            {
                "type":"click",
                "name":"南海分部",
                "key":"南海分部"
            },
            
            {
                "type":"click",
                "name":"顺德分部",
                "key":"顺德分部"
            },
            
            {
                "type":"click",
                "name":"成都分部",
                "key":"成都分部"
            }]
       },
       
       
       {
           "name":"私募基金",
           "sub_button":[
            {
               "type":"click",
               "name":"巨牛天字一号",
               "key":"巨牛天字一号"
            },
           
            {
                "type":"click",
                "name":"巨牛天子期货1号",
                "key":"巨牛天子期货1号"
            },
            {
                "type":"click",
                "name":"巨牛天子期货2号",
                "key":"巨牛天子期货2号"
            },
            {
                "type":"click",
                "name":"巨牛汇聪期货1号",
                "key":"巨牛汇聪期货1号"
            },
            {
                "type":"click",
                "name":"巨牛汇聪期货2号",
                "key":"巨牛汇聪期货2号"
            },
            ]
       }
       ]
 }';
$access_token="eB_KtnAGolFYXb9cxSWHdvws_7QvZXx_gq3v-HxpItpBiHvbjg2nzjpZJZKSfNC90ZLb_LJkRa81RpLOGTkqgrVhXL92CngMLjpuTbXTtnA";
$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
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

?>