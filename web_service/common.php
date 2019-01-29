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

/**
 * How To Check If Page Exists With CURL
 * @param $url
 * @return bool
 * @author china_skag
 * @source https://blog.csdn.net/china_skag/article/details/6745825
 */
function page_exists($url)
{
    $parts = parse_url($url);
    if (!$parts) {
        return false; /* the URL was seriously wrong */
    }

    if (isset($parts['user'])) {
        return false; /* user@gmail.com */
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    /* set the user agent - might help, doesn't hurt */
    //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; wowTreebot/1.0; +http://wowtree.com)');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

    /* try to follow redirects */
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    /* timeout after the specified number of seconds. assuming that this script runs
       on a server, 20 seconds should be plenty of time to verify a valid URL.  */
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);

    /* don't download the page, just the header (much faster in this case) */
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_HEADER, true);

    /* handle HTTPS links */
    if ($parts['scheme'] == 'https') {
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    }

    $response = curl_exec($ch);
    curl_close($ch);

    /* allow content-type list */
    $content_type = false;
    if (preg_match('/Content-Type: (.+\/.+?)/i', $response, $matches)) {
        switch ($matches[1])
        {
            case 'application/atom+xml':
            case 'application/rdf+xml':
                //case 'application/x-sh':
            case 'application/xhtml+xml':
            case 'application/xml':
            case 'application/xml-dtd':
            case 'application/xml-external-parsed-entity':
                //case 'application/pdf':
                //case 'application/x-shockwave-flash':
                $content_type = true;
                break;
        }

        if (!$content_type && (preg_match('/text\/.*/', $matches[1]) || preg_match('/image\/.*/', $matches[1]))) {
            $content_type = true;
        }
    }

    if (!$content_type) {
        return false;
    }

    /*  get the status code from HTTP headers */
    if (preg_match('/HTTP\/1\.\d+\s+(\d+)/', $response, $matches)) {
        $code = intval($matches[1]);
    } else {
        return false;
    }

    /* see if code indicates success */
    return (($code >= 200) && ($code < 400));
}

/**
 * 检查网址格式
 * @author china_skag
 * @source https://blog.csdn.net/china_skag/article/details/6745825
 * @param $weburl
 * @return bool
 */
function checkUrl($weburl)
{
    return !ereg("^http(s)*://[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$", $weburl);
}