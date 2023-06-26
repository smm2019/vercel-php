<?php

/*
$url='https://aws.ulivetv.net/v3/web/api/filter';
$post[]='';
$headers[]='content-type: application/json';
$headers[]='appid: 6fd0866dffd24341c680ed4a5417bdca';
$headers[]='user-agent:'. PC_UA;
$headers[]='origin:'.url;
$headers[]='referer:'.url;

$url='https://www.histar.tv/_next/data/7AugI6VnjiJEE_d-lvpd6/live.json';
*/



$url='https://www.histar.tv/_next/data/7AugI6VnjiJEE_d-lvpd6/live/cctv1.json?id=cctv1';

$code=get_curl_contents($url);
echo $code;





function get_curl_contents($url, $header = 0, $nobody = 0, $headers = null, $post = null) {
    if (!function_exists('curl_init')) die('php.ini未开启php_curl.dll');
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $url);
    curl_setopt($c, CURLOPT_TIMEOUT, 30); //5秒超时
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($c, CURLOPT_HEADER, $header); //如果你想把一个头包含在输出中，设置这个选项为一个非零值。
    curl_setopt($c, CURLOPT_NOBODY, $nobody); //如果你不想在输出中包含body部分，设置这个选项为一个非零值。
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true); //设定是否显示头信息
    //curl_setopt($c, CURLOPT_FOLLOWLOCATION, true); //设定是否跟随重定向
    if ($headers) {
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
    }
    if ($post) {
        curl_setopt($c, CURLOPT_POST, 1); // POST数据
        curl_setopt($c, CURLOPT_POSTFIELDS, $post); // 把post的变量加上
    }
    $res = curl_exec($c);
    $errorno = curl_errno($c);
    if ($errorno) {
        return $errorno;
    }
    curl_close($c);
    return $res;
}
