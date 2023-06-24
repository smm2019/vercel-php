<?php
$url='https://github.com/search?q=vercel&type=code';


$headers[]='cookie: _octo=GH1.1.169314837.1665371473; _device_id=0d62721776e20d09ca3e50b35c8187a9; user_session=xQbTJI6qvG69frsUJsWiAGZZi8_sX-Q5HVHryyKvTh6OOleL; __Host-user_session_same_site=xQbTJI6qvG69frsUJsWiAGZZi8_sX-Q5HVHryyKvTh6OOleL; logged_in=yes; dotcom_user=tqx5201; has_recent_activity=1; color_mode=^%^7B^%^22color_mode^%^22^%^3A^%^22auto^%^22^%^2C^%^22light_theme^%^22^%^3A^%^7B^%^22name^%^22^%^3A^%^22light^%^22^%^2C^%^22color_mode^%^22^%^3A^%^22light^%^22^%^7D^%^2C^%^22dark_theme^%^22^%^3A^%^7B^%^22name^%^22^%^3A^%^22dark^%^22^%^2C^%^22color_mode^%^22^%^3A^%^22dark^%^22^%^7D^%^7D; preferred_color_mode=light; tz=Asia^%^2FShanghai; _gh_sess=S^%^2FBYtO3cNIVz878uKCaL65ba1PadGoJu5Li8y39Gx6LHkLC^%^2FybLxDyw6yqCkYH^%^2FvHY3rD^%^2FmOb3Io7vzkeHtdmclCUme8JKNGG68PWIkRcnyvPYt750z2lfwEpk9zyhdaV2I7w^%^2BAkIQzYAx^%^2BU2mfqKgaO^%^2Be7AuN7w1xrbnbmfK01Gm9Ycyc8o4IuFEO0xsdAkSObBQmoNkjiqh6oIcdyP7iVKt^%^2FtjfzPceHSm3xQq5UM^%^2FYKg0cSm9SQdvnuKV1Eb1PzAkfjTAzQ8Y3idng^%^2BS4Wz0N0PK7TM^%^2BCSTFVsMuFcEQhsc3xKv^%^2F3X43y7Mol4cN^%^2B5VdIYPpEFNpd1PpaYEG^%^2Ba4Hc51V^%^2F8kNeqdEpy^%^2FfIGvtmN5INecr50AejZhjQt05c2AN0y^%^2B4kPEde^%^2FT7GbEEv2FHVJvpHhgjMh9yTWPOJl6v6XR3m66Y^%^2B5blX0doVGcHE7n8Wd3e3wDSsQmWbPQ1tdo8CqQovvBKZrCIV2A9V2Kce--UOiSnW2RaOHtIVQS--fnKbb5PS96iX^%^2B5^%^2BRz4V^%^2Baw^%^3D^%^3D';

$code=get_curl_contents($url, $headers);
echo $code;




//取源码
    function get_curl_contents($url, $headers = '', $post = '', $header = 0, $nobody = 0) {
        if (!function_exists('curl_init')) die('php.ini未开启php_curl.dll');
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_TIMEOUT, 30); //5秒超时
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($c, CURLOPT_HEADER, $header); //如果你想把一个头包含在输出中，设置这个选项为一个非零值。
        curl_setopt($c, CURLOPT_NOBODY, $nobody); //如果你不想在输出中包含body部分，设置这个选项为一个非零值。
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true); //设定是否显示头信息
        if ($headers) {
            curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
        }
        if ($post) {
            curl_setopt($c, CURLOPT_POST, 1); // POST数据
            curl_setopt($c, CURLOPT_POSTFIELDS, $post); // 把post的变量加上
        }
        //var_dump($headers);var_dump($post);
        $res = curl_exec($c);
        $errorno = curl_errno($c);
        if ($errorno) {
            return $errorno;
        }
        curl_close($c);
        return $res;
    }
