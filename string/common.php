<?php

/** 
  * 使用正则将字符串内连续重复的空格替换成一个空格；<br/>
  * 一般使用在写原生SQL语句时，连接导致很多空格的情况；<br/>
  * 为了避免调试时麻烦，尽量缩减空格。<br/>
  * @param String $str
  * @return String
  */
function remove_extra_spaces($str=''){
    return trim(preg_replace("/[\s]+/is"," ",$str));
}

/** 生成无符号的随机字符串
  * @param String $length 返回的字符串长度(默认5位)
  * @return String
  */
function generate_code( $length = 5 ) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';
    for ( $i = 0; $i < $length; $i++ )
        $code .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    return $code;
}

/** 返回5位根据传入的字符串而生成的短码
  * @param String $long_str 
  * @return Array<String>
  */
function hash5code($long_str){
    $key = 'abcdef'; // your fixed str
    $base32 = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    // 利用md5算法方式生成hash值
    $hex = hash('md5', $long_str.$key);
    $hexLen = strlen($hex);
    $subHexLen = $hexLen / 8;

    $output = array();
    for( $i = 0; $i < $subHexLen; $i++ ){
        // 将这32位分成四份，每一份8个字符，将其视作16进制串与0x3fffffff(30位1)与操作
        $subHex = substr($hex, $i*8, 8);
        $idx = 0x3FFFFFFF & (1 * ('0x' . $subHex));

        // 这30位分成6段, 每5个一组，算出其整数值，然后映射到我们准备的62个字符
        $out = '';
        for( $j = 0; $j < 6; $j++ ){
            $val = 0x0000003D & $idx;
            $out .= $base32[$val];
            $idx = $idx >> 5;
        }
        $output[$i] = $out;
    }
    return $output;
}