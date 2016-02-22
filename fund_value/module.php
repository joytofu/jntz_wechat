<?php
class Sql{
    function getValue($cateid,$conn)
    {
        //通过cateid查询具体value值的id
        $sql = "SELECT id FROM `juniu2_list_cate` WHERE cateid = {$cateid} ORDER BY id DESC";
        $res = mysql_query($sql,$conn);
        $id = mysql_fetch_assoc($res);

        //通过id查询具体value值
        $sql = "SELECT val FROM `juniu2_list_ext` WHERE id = $id[id] and field = 'value'";
        $res = mysql_query($sql,$conn);
        $value = mysql_fetch_assoc($res);
        return $value[val];
    }
}