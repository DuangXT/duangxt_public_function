<?php

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

