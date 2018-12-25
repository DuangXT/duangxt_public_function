<?php

/** 
  * 获取IP地址所在的位置<br/>
  * （淘宝api） */
function ipv4_info_by_taobao($ip_v4){
    $test="/^((25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))/";
    if( 1!==preg_match($test,$ip) )
        return false;

    $url='http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;
    $response =Post($url);

    if(!$response) return false;

    $response=json_decode($response,1);

    return $response['data'];

}

function Post($url, $post = null)
{
    $context = array();
    if (is_array($post))
    {
        ksort($post);
        $context['http'] = array
        (
            'timeout'=>60,
            'method' => 'POST',
            'content' => http_build_query($post, '', '&'),
        );
    }
    return file_get_contents($url, false, stream_context_create($context));
}