<?php
define('UC_ROOT', dirname(dirname(__FILE__)).'/');
function sso_get_user($username)
{
    $isuid = false;
    $return = call_user_func(uc_api_post, 'user', 'get_user', array('username'=>$username, 'isuid'=>$isuid));
    return uc_unserialize($return);
}
function sso_get_user_info($tgt){
    // TODO: check this tgt valid and expire time.
    return array('id' => 0, 'un' => 'admin', 'email' => 'zy.netsec@gmail.com'); // data for debug test.
}
function uc_stripslashes($string) {
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
    if(MAGIC_QUOTES_GPC) {
        return stripslashes($string);
    } else {
        return $string;
    }
}
define('UC_KEY', 'T4ff66h4j5k4G7Y8C7l7kbM153A1k7Md493bP1Z2Pajb46v0Xe44r2bdXaR385Qe');

define('UC_APPID', '1');                // 当前应用的 ID
define('UC_CLIENT_RELEASE', '20110501');
define('UC_API', 'http://127.0.0.1/linuxfans/discuz/uc_server'); // UCenter 的 URL 地址, 在调用头像时依赖此常量
define('UC_IP', '127.0.0.1');               // UCenter 的 IP, 当 UC_CONNECT 为非 mysql 方式时, 并且当前应用服务器解析域名有问题时, 请设置此值
function uc_api_post($module, $action, $arg = array()) {
    $s = $sep = '';
    foreach($arg as $k => $v) {
        $k = urlencode($k);
        if(is_array($v)) {
            $s2 = $sep2 = '';
            foreach($v as $k2 => $v2) {
                $k2 = urlencode($k2);
                $s2 .= "$sep2{$k}[$k2]=".urlencode(uc_stripslashes($v2));
                $sep2 = '&';
            }
            $s .= $sep.$s2;
        } else {
            $s .= "$sep$k=".urlencode(uc_stripslashes($v));
        }
        $sep = '&';
    }
    $postdata = uc_api_requestdata($module, $action, $s);
    return uc_fopen2(UC_API.'/index.php', 500000, $postdata, '', TRUE, UC_IP, 20);
}
function uc_api_input($data) {
    $s = urlencode(uc_authcode($data.'&agent='.md5($_SERVER['HTTP_USER_AGENT'])."&time=".time(), 'ENCODE', UC_KEY));
    return $s;
}
function uc_api_requestdata($module, $action, $arg='', $extra='') {
    $input = uc_api_input($arg);
    $post = "m=$module&a=$action&inajax=2&release=".UC_CLIENT_RELEASE."&input=$input&appid=".UC_APPID.$extra;
    return $post;
}
function uc_unserialize($s) {
    include_once UC_ROOT.'./lib/xml.class.php';
    return xml_unserialize($s);
}
function uc_authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

    $ckey_length = 4;

    $key = md5($key ? $key : UC_KEY);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}
function uc_fopen2($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
    $__times__ = isset($_GET['__times__']) ? intval($_GET['__times__']) + 1 : 1;
    if($__times__ > 2) {
        return '';
    }
    $url .= (strpos($url, '?') === FALSE ? '?' : '&')."__times__=$__times__";
    return uc_fopen($url, $limit, $post, $cookie, $bysocket, $ip, $timeout, $block);
}

function uc_fopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
    $return = '';
    $matches = parse_url($url);
    !isset($matches['host']) && $matches['host'] = '';
    !isset($matches['path']) && $matches['path'] = '';
    !isset($matches['query']) && $matches['query'] = '';
    !isset($matches['port']) && $matches['port'] = '';
    $host = $matches['host'];
    $path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
    $port = !empty($matches['port']) ? $matches['port'] : 80;
    if($post) {
        $out = "POST $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= 'Content-Length: '.strlen($post)."\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cache-Control: no-cache\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
        $out .= $post;
    } else {
        $out = "GET $path HTTP/1.0\r\n";
        $out .= "Accept: */*\r\n";
        //$out .= "Referer: $boardurl\r\n";
        $out .= "Accept-Language: zh-cn\r\n";
        $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Cookie: $cookie\r\n\r\n";
    }

    if(function_exists('fsockopen')) {
        $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
    } elseif (function_exists('pfsockopen')) {
        $fp = @pfsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
    } else {
        $fp = false;
    }

    if(!$fp) {
        return '';
    } else {
        stream_set_blocking($fp, $block);
        stream_set_timeout($fp, $timeout);
        @fwrite($fp, $out);
        $status = stream_get_meta_data($fp);
        if(!$status['timed_out']) {
            while (!feof($fp)) {
                if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
                    break;
                }
            }

            $stop = false;
            while(!feof($fp) && !$stop) {
                $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                $return .= $data;
                if($limit) {
                    $limit -= strlen($data);
                    $stop = $limit <= 0;
                }
            }
        }
        @fclose($fp);
        return $return;
    }
}

?>
