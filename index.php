<?php
require_once('weixin_getdata.php');
define("TOKEN", "jntz");
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }


    //检查签名
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    //消息回复
    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            //用户发送的消息类型判断
            switch ($RX_TYPE)
            {
                case "text":
                    $result = $this->receiveText($postObj);
                    break;
                case "image":
                    $result = $this->receiveImage($postObj);
                    break;
                case "voice":
                    $result = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $result = $this->receiveVideo($postObj);
                    break;
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
                default:
                    $result = "unknow msg type: ".$RX_TYPE;
                    break;
            }
            echo $result;
        }else {
            echo "";
            exit;
        }
    }


    //接收文本
    private function receiveText($object)
    {
        /*$keyword = trim($object->Content);
        if($keyword == "时间" || $keyword == "测试"){
            $content = date("Y-m-d H:i:s",time());
            $result = $this->transmitText($object, $content);
        }
        //触发多客服模式
        else if (strstr($keyword, "您好") || strstr($keyword, "你好") || strstr($keyword, "在吗") || strstr($keyword, "有人吗")){
            $result = $this->transmitService($object);
            return $result;
        }
        return $result;*/

        /* $keyword = trim($object->Content);
        $mmc = memcache_init();
        $service = memcache_get($mmc, "service");
        
		
        //当前有人工客服对话
        if ($service){
            $relation = json_decode($service, true);
            //用户处在人工客服交互中
            if (in_array($object->FromUserName, $relation)){
                require_once('weixin.class.php');
                $to = ($relation['from'] == strval($object->FromUserName))?$relation['to']:$relation['from'];
                 $result=$this->transmitService($object); 
                $weixin = new class_weixin();
                $weixin->send_custom_msg($to, "text", $keyword);
                return $result;
            }
        }
        
        $content = "";
        if (is_array($content)){
            $result = $this->transmitNews($object, $content);
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;*/

        $category = substr($keyword,0,6);
        $code = trim(substr($keyword,6,strlen($keyword)));
        switch ($category)
        {
            case "股票":
                include("stock.php");
                $content = getStockInfo($code);
                break;
            case "分析":
                include("analysis.php");
                $content = getStockAnalysis($code);
                break;
            default:
                $content = "不支持的命令";
                break;
        }


        if(is_array($content)){
            $result = $this->transmitNews($object, $content);
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }


    //接收图片
    private function receiveImage($object)
    {
        //回复图片消息 
        $content = array("MediaId"=>$object->MediaId);
        $result = $this->transmitImage($object, $content);;
        return $result;
    }


    //接收声音
    private function receiveVoice($object)
    {
        //回复语音消息 
        $content = array("MediaId"=>$object->MediaId);
        $result = $this->transmitVoice($object, $content);;
        return $result;
    }

    //接收视频
    private function receiveVideo($object)
    {
        //回复视频消息 
        $content = array("MediaId"=>$object->MediaId, "ThumbMediaId"=>$object->ThumbMediaId, "Title"=>"", "Description"=>"");
        $result = $this->transmitVideo($object, $content);;
        return $result;
    }

    //接收关注、取消、菜单点击事件
    private function receiveEvent($object)
    {
        $content= "";
        switch ($object->Event)
        {
            case "subscribe":
                $content ="欢迎关注巨牛金融!了解最新市场动态资讯及相关产品信息，请点击“微官网”。";
                break;
            case "unsubscribe":
                break;
            case "CLICK":
                switch ($object->EventKey)
                {

                    case "联系我们":
                        //香港总部
                        $content[]=array(
                            "Title"=>"香港总部
地址：香港尖沙咀科学馆道1号康宏广场北座16楼
16/F, Suite North, Concordia Plaza, No.1 Science Museum Rd., Tsim Sha Tsui, Kowloon, HK                             
电话(Tel)：00852-69545869",
                            "Description"=>"",
                            "PicUrl"=>"http://s2.sinaimg.cn/bmiddle/48ebe3bc06dbf34fdf1c1",
                            "Url"=>"http://j.map.baidu.com/TlwPy");

                        //广州分部
                        $content[]=array(
                            "Title"=>"广州分部
地址：广东省广州市越秀区东风东路268号广州交易广场1906室 
Rm.1906, Guangzhou Exchange Square, No.268 Dongfeng Rd.(east), Yuexiu District, Guangzhou City, Guangdong Prov. 
电话(Tel)：020-83191139",
                            "Description"=>"",
                            "PicUrl"=>"http://hiphotos.baidu.com/lbsugc/pic/item/0bd162d9f2d3572c0cb3a1bd8813632762d0c379.jpg",
                            "Url"=>"http://j.map.baidu.com/6QGsl");

                        //天河分部
                        $content[]=array(
                            "Title"=>"天河分部
地址：广东省广州市天河区体育西路101号维多利广场A座3105室
Rm.3105, Guangzhou Victory Square, No.101 Tiyu Rd.(west), Tianhe District, Guangzhou City, Guangdong Prov.
电话(Tel)：020-38479550",
                            "Description"=>"",
                            "PicUrl"=>"https://mmbiz.qlogo.cn/mmbiz/icJia8DFEzGtEMUSjL6F6drIddDl0icZfkWBTiaWa09v2WnCBvp7PHgiaDQF2X5B0laMTOw7G74VhvF1gnJ8M32pPKg/0?wx_fmt=jpeg",
                            "Url"=>"http://j.map.baidu.com/LspBq");

                        //南海分部
                        $content[]=array(
                            "Title"=>"南海分部
地址：广东省佛山市南海区桂城南桂东路17号邮政局大楼9楼 
9/F, The Post Office building, No.17 Nangui Rd.(east), Guicheng, Nanhai District, Foshan City, Guangdong Prov. 
电话(Tel)：0757-86332066",
                            "Description"=>"",
                            "PicUrl"=>"http://store.is.autonavi.com/showpic/d563c29c2e5c9fe4a07d399583fa84a7",
                            "Url"=>"http://amap.com/077no8");

                        //顺德分部
                        $content[]=array(
                            "Title"=>"顺德分部
地址：广东省佛山市顺德区大良镇新桂中路明日广场A座803室 
Rm.803, Suite A, Tomorrow Square, Xingui middle Rd., Daliang Town, Shunde District, Foshan City, Guangdong Prov. 
电话(Tel)：0757-22275272",
                            "Description"=>"",
                            "PicUrl"=>"http://www.sd888.org/house/Upload/2009911542573175.jpg",
                            "Url"=>"http://j.map.baidu.com/-Ajy0");

                        //肇庆分部
                        $content[]=array(
                            "Title"=>"肇庆分部
地址：广东省肇庆市端州区端州三路48号文化创意大厦2201室
Rm.2201, Cultural and Creative building, No.48 Duanzhou 3rd Rd., Duanzhou District, Zhaoqing City, Guangdong Prov.",
                            "Description"=>"",
                            "PicUrl"=>"https://mmbiz.qlogo.cn/mmbiz/icJia8DFEzGtG54WbUEnuZUrVdQuiauaJBKDoprOnkavbkeZc4QqLlWob12icc7qyf3vUgjLCqicYkzyDFNRebeJIzA/0?wx_fmt=jpeg",
                            "Url"=>"http://j.map.baidu.com/_m_d3");

                        //成都分部
                        $content[]=array(
                            "Title"=>"成都鼓楼
地址：四川省成都市青羊区大墙西街33号鼓楼国际广场1712室
Rm.1712, Gulou International, No.33 Daqiang Street(west), Qingyang District, Chengdu City, Sichuan Prov.
电话(Tel)：028-86786725",
                            "Description"=>"",                   "PicUrl"=>"http://hiphotos.baidu.com/lbsugc/pic/item/5243fbf2b2119313faffd3d667380cd791238d13.jpg",
                            "Url"=>"http://j.map.baidu.com/5m1v6");
                        //成都二部
                        $content[]=array(
                            "Title"=>"成都草堂
地址：四川省成都市青羊区草堂路37号四楼
4th Floor, No.37 Caotang Rd., Qingyang District, Chengdu City, Sichuan Prov.
电话(Tel)：028-86114892",
                            "Description"=>"",                   "PicUrl"=>"http://hiphotos.baidu.com/lbsugc/pic/item/5243fbf2b2119313faffd3d667380cd791238d13.jpg",
                            "Url"=>"http://j.map.baidu.com/39LM5");

                        break;
                
               case "ziben":
                   $fund = "ziben";
                   $content = weixin_getdata($fund);
                   break;

               case "zhixuan":
                        $fund = "zhixuan";
                        $content="净值统计更新中";
                        //$content = weixin_getdata($fund);
                        break;

               case "baoying":
                        $fund = "baoying";
                        $content="净值统计更新中";
                        //$content = weixin_getdata($fund);
                        break;

               case "tianzi":
                        $fund = "tianzi";
                        $content = weixin_getdata($fund);
                        break;

               case "huanan":
                        $fund = "huanan";
                        $content = weixin_getdata($fund);
                        break;
                
               case "在线咨询":
                    $result=$this->transmitService($object);
                    return $result;
                    default:
                        $content = "菜单默认回复";
                        break;
    
                
                
            }
                break;
            default:
                break;
        }
        if(is_array($content)){
            $result = $this->transmitNews($object, $content);
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }


    /*回复文字消息*/
    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }


    /*
     * 回复图片消息
     */
    private function transmitImage($object, $imageArray)
    {
        $itemTpl = "<Image>
    <MediaId><![CDATA[%s]]></MediaId>
</Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复多客服信息
    private function transmitService($object)
    {
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }


    /*
     * 回复语音消息
     */
    private function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
    <MediaId><![CDATA[%s]]></MediaId>
</Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }


    /*
     * 回复视频消息
     */
    private function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
    <MediaId><![CDATA[%s]]></MediaId>
    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
</Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }



    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 10000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }




    /*
     * 回复图文消息
     */
    private function transmitNews($object, $arr_item)
    {
        if(!is_array($arr_item))
            return;

        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);

        $newsTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item));
        return $result;
    }


    /*
     * 回复音乐消息
     */
    private function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
</Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }
}
?>