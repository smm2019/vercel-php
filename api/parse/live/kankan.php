<?php
error_reporting(0);
$id = $_GET['id']??'shxwzh';
$n = [
     'dfws' => 1, //东方卫视
     'shxwzh' => 2, //上海新闻综合
     'shds' => 4, //上海都市
     'dycj' => 5, //第1财 经
     'jsrw' => 6, //上海纪实人文
     'hhxd' => 9, //哈哈炫动
     ];
$date = date('Y-m-d');
$t = time();
$sign = md5(md5('Api-Version=v1&channel_id='.$n[$id].'&date='.$date.'&nonce=1&platform=pc&timestamp='.$t.'&version=v2.0.0&28c8edde3d61a0411511d3b1866f0636'));
$h = ['api-version: v1','nonce:1','platform:pc','version:v2.0.0','timestamp:'.$t,'sign:' .$sign,'referer: https://live.kankanews.com/'];
$json = json_decode(get('https://kapi.kankanews.com/content/pc/tv/programs?channel_id='.$n[$id].'&date='.$date,$h)) -> result -> programs;
for($i=0;$i < count($json);$i++){
  if($json[$i] -> start_time < $t && $t < $json[$i] -> end_time)
   $iid = $json[$i] -> id;
  }
$sign1 = md5(md5('Api-Version=v1&channel_program_id='.$iid.'&nonce=1&platform=pc&timestamp='.$t.'&version=v2.0.0&28c8edde3d61a0411511d3b1866f0636'));
array_pop($h);
$h[] = 'sign:' .$sign1;
$encrypted = json_decode(get('https://kapi.kankanews.com/content/pc/tv/program/detail?channel_program_id='.$iid,$h)) -> result -> channel_info -> live_address;    
$public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDP5hzPUW5RFeE2xBT1ERB3hHZI
Votn/qatWhgc1eZof09qKjElFN6Nma461ZAwGpX4aezKP8Adh4WJj4u2O54xCXDt
wzKRqZO2oNZkuNmF2Va8kLgiEQAAcxYc8JgTN+uQQNpsep4n/o1sArTJooZIF17E
tSqSgXDcJ7yDj5rc7wIDAQAB
-----END PUBLIC KEY-----';
$pu_key = openssl_pkey_get_public($public_key);
openssl_public_decrypt(base64_decode($encrypted),$decrypted,$pu_key);

$burl = "https://tencent-stream.kksmg.com/live/";

$playurl = preg_replace("/(.*?.ts)/i",$burl."$1",m3u8($decrypted));
header('Content-Type: application/vnd.apple.mpegurl');
print_r($playurl);

function get($url,$header){
   $ch = curl_init($url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
   curl_setopt($ch, CURLOPT_REFERER, 'https://live.kankanews.com/');
   curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
   $d = curl_exec($ch);
   curl_close($ch);
   return $d;
   }
function m3u8($url){
   $ch = curl_init($url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
   curl_setopt($ch, CURLOPT_REFERER, 'https://live.kankanews.com/');
   $d = curl_exec($ch);
   curl_close($ch);
   return $d;
   }
?>
