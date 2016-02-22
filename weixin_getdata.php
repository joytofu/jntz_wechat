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
            $fundname = "��ţ-�ʱ��ٺ�";
            $fundCreateDate = "2015-06-25";
            break;
        case "zhixuan":
            $fundname = "��ţ-��ѡ�ٺ�";
            $fundCreateDate = "2015-06-01";
            break;
        case "baoying":
            $fundname = "��ţ-��ӯ�ٺ�";
            $fundCreateDate = "2015-04-30";
            break;
        case "tianzi":
            $fundname = "��ţ-���֢ٺ�";
            $fundCreateDate = "2015-01-05";
            break;
        case "huanan":
            $fundname = "��ţ-���Ϣٺ�";
            $fundCreateDate = "2015-03-24";
    }

    $latestDate = $output[0]['title'];
    $fundvalue = $output[0]['val'];

    //Ԥ���껯������
    $startDate = strtotime($fundCreateDate);
    $endDate = strtotime($latestDate);
    $days=round(($endDate-$startDate)/86400)+1;
    $yr=($fundvalue-1)*12/($days/30);   //Ԥ���껯������
    $yr=round($yr,4)*100;
    $yr<100?$yr=50:$yr;
    $yr=$yr.'%';

    $fundinfo=$fundname."\n"."��������:".$fundCreateDate."\n"."��ֵ����:".$latestDate."\n"."���¾�ֵ:".$fundvalue."\n"."Ԥ���껯������:".$yr;
    return $fundinfo;
}

