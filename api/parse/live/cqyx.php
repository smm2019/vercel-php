<?php
//查看CURL的版本
//var_dump(curl_version()); exit;
//Rewrite by absentfriend
date_default_timezone_set("Asia/Shanghai");
$playseek = isset($_GET['playseek'])?$_GET['playseek']:'';

$cityId = '5A';
$playId = $_GET['id']??'cctv1HD';
$relativeId = $playId;
$type = '1';
$appId = "kdds-chongqingdemo";
$url = 'http://portal.centre.bo.cbnbn.cn/others/common/playUrlNoAuth?cityId=5A&playId='.$playId.'&relativeId='.$relativeId.'&type=1';
$curl = curl_init();
$timestamps = round(microtime(true) * 1000);
$sign = md5('aIErXY1rYjSpjQs7pq2Gp5P8k2W7P^Y@appId' . $appId . "cityId" . $cityId. "playId" . $playId . "relativeId" . $relativeId . "timestamps" . $timestamps . "type" . $type);
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'appId: kdds-chongqingdemo',
        'sign: '.$sign,
        'timestamps:'.$timestamps,
        'Content-Type: application/json;charset=utf-8'
    ),
));

$response = curl_exec($curl);
curl_close($curl);
$url = (json_decode($response));
$codes = $url->data->result->protocol[0]->transcode[0]->url;

//echo $codes;exit;
$i = 0;
do {
    $playurl = curl_get($codes);
    $i++;
}while (strpos($playurl, 'byte.live.cbncdn.cn'));

//echo $playurl;exit;
 header('location:'.$playurl);exit;
/*
if(strstr($playId,'HD')){
    $playurl=str_replace('index.m3u8','2/v4M/index.m3u8',$playurl);
}else{
    $playurl=str_replace('index.m3u8','1/v2M/index.m3u8',$playurl);
}
*/


if ($playseek != '') {
    $palyseek_arr = explode('-', $playseek);
    $s_time = $palyseek_arr[0];
    $e_time = $palyseek_arr[1];
    get_tvback($playurl, $s_time, $e_time);
}else{
    echo $i;echo '<br>';echo PHP_EOL; echo $playurl; exit;
    header('location:'.$playurl);
}




//http://cqcu2.live.cbncdn.cn:80/session/750062c6-f9fe-11ee-98bf-525400dfb345$h1.0$live.cbncdn.cn/pj9p9p/__cl/cg:live/__c/cctv1HD/__op/default/__f/2/v4M/index.m3u8
//回看
function get_tvback($playurl, $s_time, $e_time) {
    $domain = explode('?',$playurl)[0];
    $st = ceil(strtotime($s_time)/10);
    $et = ceil(strtotime($e_time)/10);
    $m3u8 = '#EXTM3U'; $m3u8 .= PHP_EOL;
    $m3u8 .= '#EXT-X-VERSION:3'; $m3u8 .= PHP_EOL;
    $m3u8 .= '#EXT-X-TARGETDURATION:10'; $m3u8 .= PHP_EOL;
    $m3u8 .= '#EXT-X-MEDIA-SEQUENCE:'.$st; $m3u8 .= PHP_EOL;
    for ($ts = $st; $ts < $et; $ts++) {
        $url = sprintf('%s/%s.ts', $domain, $ts);
        $m3u8 .= '#EXTINF:10,'; $m3u8 .= PHP_EOL;
        $m3u8 .= $url; $m3u8 .= PHP_EOL;
    }
    $m3u8 .= '#EXT-X-ENDLIST';
    header("Content-Type: text/plain");
    //header('Content-Type: application/vnd.apple.mpegurl');
    //header("Content-Disposition: attachment; filename=mnf.m3u8");
    echo $m3u8;
}


function curl_get($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, str_replace('live.cbncdn.cn', '118.24.228.117', $url));
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    /*
curl_setopt($ch, CURLOPT_VERBOSE, 1);
    //curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
curl_setopt($ch, CURLOPT_RESOLVE, ["live.cbncdn.cn:80:118.24.228.117"]);
    //curl_setopt($ch, CURLOPT_CONNECT_TO, ["live.cbncdn.cn:80:118.24.228.117"]);
*/
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['host:live.cbncdn.cn']);

    curl_setopt($ch, CURLOPT_HEADER, true);
    //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:39.0) Gecko/20100101 Firefox/39.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果把这行注释掉的话,就会直接输出
    $result = curl_exec($ch);
    curl_close($ch);
    preg_match('|Location:(.*)|', $result, $temp);
    $play_url = trim($temp[1]);
    return $play_url;
}

?>
