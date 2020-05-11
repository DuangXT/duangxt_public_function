<?php

/**
 * PHP对javascript逗号运算符 , 的模拟<p>
 * 转换效果（ js to PHP ）：
 * <pre>
 * if (i = 0, j = 1, k =2) {} to if (comma($i = 0, $j = 1, $k = 2)) {}
 * </pre>
 * @param ...
 * @return mixed
 * @source: https://zhile.io/2018/06/21/php-equivalent-javascript-bitwise-operators.html
 */
function comma(){
    $args = func_get_args();
    return end($args);
}