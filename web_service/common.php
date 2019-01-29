<?php

function Post($url, $post = null){
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


/**
 * CURL post请求
 * @param $url
 * @param $data
 * @param null $header
 * @return mixed
 */
function curl_post($url,$data,$header=null){
    $ch = curl_init();
    $header[] = "Accept-Charset: utf-8";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    if(strpos($url,'https') != false){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//https
        $opt[CURLOPT_SSL_VERIFYHOST] = 1;
        $opt[CURLOPT_SSL_VERIFYPEER] = FALSE;
    }
    if($header){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
    // 	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    // if(is_array($data)) $data = http_build_query($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);

    //关闭curl
    curl_close($ch);
    return $result;
}

/**
 * 判断http 地址是否有效
 * @param $url
 * @return bool
 * @author china_skag
 * @source https://blog.csdn.net/china_skag/article/details/6745825
 */
function url_exists($url){
    return url_exists1($url);
}
/** 判断http 地址是否有效 */
function url_exists1($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_NOBODY, 1); // 不下载
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    return (curl_exec($ch)!==false) ? true : false;
}
/** 判断http 地址是否有效 */
function url_exists2($url){
    $head = @get_headers($url);
    return is_array($head) ?  true : false;
}

/**
 * 图片链接是否存在
 * @param $url
 * @return bool
 * @author china_skag
 * @source https://blog.csdn.net/china_skag/article/details/6745825
 */
function img_exists($img_url){
    return file_get_contents($img_url,0,null,0,1) ? true : false;
}