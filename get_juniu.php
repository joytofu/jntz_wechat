<?php
// var_dump(getStockAnalysis("000063"));
header("Content-type: text/html; charset=utf-8");


function getFundInfo()
{
	
$resultArray = array();
    
    include_once('simple_html_dom.php');

	try {
		$url = "http://dc.simuwang.com/product/HF00000EEB.html";
		$html_analysis = file_get_html($url);
		if (!isset($html_analysis)){
			$html_analysis->clear();
		}else{
            $fundtitle="巨牛天字一号";
            $fundCreateTime="成立日期:2015年1月5日";
            $fundvalue=$html_analysis->find('div[class="padding10"]', 1)->plaintext;
            $fundvalue=str_replace(chr(32),'',$fundvalue);
            $fundvalue=str_replace(chr(13),'',$fundvalue);
            $fundvalue=trim($fundvalue);
            //$funday="年化收益:".$html_analysis->find('table tbody tr td span', 1)->plaintext;
            //$fundmy="近一个月收益:".$html_analysis->find('table tbody tr td span', 9)->plaintext;
            $fundinfo=$fundtitle."\n".$fundCreateTime."\n".$fundvalue;
            /*$stock = "巨牛天字一号"; //$html_analysis->find('table tbody tr td h1[class="fyh f18"]', 0)->plaintext;
            $resultArray[] = array("Title" =>trim($stock));
            //基金净值
            $fundamentals = $html_analysis->find('table tbody tr td div[class="padding10"]', 0);
            $resultArray[] = array("Title" =>str_replace("%", "%%", "【单位净值】\n".$fundamentals->plaintext));
                        
            //年化收益
            $technical = $html_analysis->find('table tbody tr td span', 1);
            $resultArray[] = array("Title" =>str_replace("%","%", "【年化收益率】\n".$technical->plaintext));
                        
            //近一月收益
            $technical = $html_analysis->find('table tbody tr td span', 9);
            $resultArray[] = array("Title" =>str_replace("%", "%", "【近一个月收益率】\n".$technical->plaintext));*/
            $html_analysis->clear();
        }
	}catch (Exception $e){

	}
	//return $resultArray;
    return $fundinfo;
}
$fund=getFundInfo();
echo $fund;
?>
