<?php
require_once('DB.php');
require_once('module.php');
$connect = DB::getInstance()->connect();
$sql = new Sql();
$fund = $_GET['fund'];
switch ($fund) {
    case "巨牛-智选①号":
        $cate_id = 183;
        break;
    case "巨牛-保盈①号":
        $cate_id = 180;
        break;
    case "巨牛-资本①号":
        $cate_id = 187;
        break;
    case "巨牛-华南①号":
        $cate_id = 182;
        break;
    case "巨牛-天字①号":
        $cate_id = 181;
        break;
    case "巨牛-天子国际期货①号":
        $cate_id = 185;
        break;
    case "巨牛-好运来①号":
        $cate_id = 184;
        break;
}
$res = $sql->getValue($cate_id,$connect);
echo $res;

$fund = $_GET['fund'];
switch ($fund) {
    case "巨牛-智选①号":
        $cate_id = 183;
        break;
    case "巨牛-保盈①号":
        $cate_id = 180;
        break;
    case "巨牛-资本①号":
        $cate_id = 187;
        break;
    case "巨牛-华南①号":
        $cate_id = 182;
        break;
    case "巨牛-天字①号":
        $cate_id = 181;
        break;
    case "巨牛-天子国际期货①号":
        $cate_id = 185;
        break;
    case "巨牛-好运来①号":
        $cate_id = 184;
        break;
}