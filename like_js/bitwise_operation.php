<?php
// @source: https://zhile.io/2018/06/21/php-equivalent-javascript-bitwise-operators.html

/**
 * >>> javascript operator in php x86_64
 * @param int $v
 * @param int $n
 * @return int
 */
function rrr($v, $n){
    return ($v & 0xFFFFFFFF) >> ($n & 0x1F);
}

/**
 * >> javascript operator in php x86_64
 * @param int $v
 * @param int $n
 * @return int
 */
function rr($v, $n){
    $v = $v & 0x80000000 ? $v | 0xFFFFFFFF00000000 : $v & 0xFFFFFFFF;

    return $v >> ($n & 0x1F);
}


/**
 * << javascript operator in php x86_64
 * @param int $v
 * @param int $n
 * @return int
 */
function ll($v, $n){
    $t = ($v & 0xFFFFFFFF) << ($n & 0x1F);

    return $t & 0x80000000 ? $t | 0xFFFFFFFF00000000 : $t & 0xFFFFFFFF;
}