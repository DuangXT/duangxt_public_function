
// 因为项目里面一个金额支付问题，被截取的位数总是会进1，然后小数点截取方法使用了 substr 和 sprintf("%.9f",……) 这样的方法，和使用floor()先乘再除一样，会丢失精度导致截取位数再往后一位为某个数字（比如9）时，会进一位，遂干脆自己写一个， 用纯字符串截取，毛事都没有了。
/** 截取浮点数的小数点位数，默认8位 */
function formatDoubleVal($double_val,$point_size=8){
    $double_val=doubleval($double_val);
    $point_size=intval($point_size);
    if(!$point_size || $point_size<=0 ) $point_size=8;
    var_dump($point_size);
    if(!strpos($double_val,".")) return $double_val;
    $double_val=explode('.',$double_val);
    $double_val[1]= substr($double_val[1],0,$point_size);
    return doubleval($double_val[0].".".$double_val[1]);
}

/** 获取小数点后的位数 */ //网络流传方法
function getFloatLength($double_val) {
    $count=0;$num=doubleval($double_val);
    $temp=explode('.',$double_val);
    if (sizeof($temp)>1){
        $decimal = end($temp);
        $count = strlen($decimal);}
    return $count;
}