<?php 

/**
 * 你可以用microtime()获取时间戳和毫秒，也可以用microtime(true)获取float的带毫秒时间戳。<br/>
 * 但是你可能会发现microtime(true)得到的float只有4位。即便将microtime()得到的数拆开相加，也是4位。<br/>
 * 于是写了这个方法。
 */
function getMicrotime(){
    $time = explode(' ', microtime());
    $time[0] = str_replace("0.","",doubleval($time[0]));
    return doubleval($time[1] .".". $time[0]);
}