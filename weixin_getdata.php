<?php
function weixin_getdata($fundtitle)
{

    $url = "http://www.hkgbi.com/fund_value/api.php?fund=".$fundtitle;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $res = curl_exec($ch);
    $output = json_decode($res, true);
    curl_close($ch);

    switch($fundtitle) {
        case "ziben":
            $fundname = "巨牛-资本①号";
            $fundCreateDate = "2015-06-25";
            break;
        case "zhixuan":
            $fundname = "巨牛-智选①号";
            $fundCreateDate = "2015-06-01";
            break;
        case "baoying":
            $fundname = "巨牛-保盈①号";
            $fundCreateDate = "2015-04-30";
            break;
        case "tianzi":
            $fundname = "巨牛-天字①号";
            $fundCreateDate = "2015-01-05";
            break;
        case "huanan":
            $fundname = "巨牛-华南①号";
            $fundCreateDate = "2015-03-24";
    }

    $latestDate = $output[0]['title'];
    $fundvalue = $output[0]['val'];

    //预计年化收益率
    $startDate = strtotime($fundCreateDate);
    $endDate = strtotime($latestDate);
    $days=round(($endDate-$startDate)/86400)+1;
    $yr=($fundvalue-1)*12/($days/30);   //预计年化收益率
    $yr=round($yr,4)*100;
    $yr<100?$yr=50:$yr;
    $yr=$yr.'%';

    $fundinfo=$fundname."\n"."成立日期:".$fundCreateDate."\n"."净值日期:".$latestDate."\n"."最新净值:".$fundvalue."\n"."预计年化收益率:".$yr;
    return $fundinfo;
}

