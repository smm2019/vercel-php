<?php
//百视通直播、回看
//header('Content-type:text/plain;charset=utf-8');

$domain = 'http://223.109.33.33/liveplay-kk.rtxapp.com';
$domain = 'http://[2409:8c74:f100:1804::14]/liveplay-kk.rtxapp.com';
$domain = 'http://223.111.117.11/liveplay-kk.rtxapp.com';


$id = isset($_GET['id'])?$_GET['id']:'dsjpdhd@4000000';
$id = str_replace('@', '/', $id);
$playseek = isset($_GET['playseek'])?$_GET['playseek']:'';
if ($playseek != '') {
    $palyseek_arr = explode('-', $playseek);
    $s_time = $palyseek_arr[0];
    $e_time = $palyseek_arr[1];
    //get_tvback_url_bestv($domain_rand, $id, $s_time, $e_time);

    $url = sprintf('%s/live/program/live/%s/mnf.m3u8?starttime=%d&endtime=%d', $domain, $id, strtotime($s_time), strtotime($e_time));
    //echo $url;exit;
    header('Location:'.$url);
} else {
    $url = sprintf('%s/live/program/live/%s/mnf.m3u8', $domain, $id);
    //echo $url;exit;
    header('Location:'.$url);
}



//直播生成回看地址
function get_tvback_url_bestv($domain, $ch_id = 'cctv1hd/4000000', $s_time, $e_time) {
    $st = ceil(strtotime($s_time)/10);
    $et = ceil(strtotime($e_time)/10);
    $http = $domain.'/live/program/live';
    $m3u8 = '#EXTM3U'; $m3u8 .= PHP_EOL;
    $m3u8 .= '#EXT-X-VERSION:3'; $m3u8 .= PHP_EOL;
    $m3u8 .= '#EXT-X-TARGETDURATION:10'; $m3u8 .= PHP_EOL;
    $m3u8 .= '#EXT-X-MEDIA-SEQUENCE:'.$st; $m3u8 .= PHP_EOL;
    for ($i = $st; $i < $et; $i++) {
        $ymdh = date('YmdH', $i*10);
        $url = sprintf('%s/%s/%s/%s.ts', $http, $ch_id, $ymdh, $i);
        $m3u8 .= '#EXTINF:10,'; $m3u8 .= PHP_EOL;
        $m3u8 .= $url; $m3u8 .= PHP_EOL;
    }
    $m3u8 .= '#EXT-X-ENDLIST';
    header('Content-Type: application/vnd.apple.mpegurl');
    header("Content-Disposition: attachment; filename=mnf.m3u8");
    echo $m3u8;
    //return $url;
}


?>
