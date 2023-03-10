<?php

// 应用公共函数库文件

use think\Request;
use think\Log;
use think\Validate;

/**
 * 打印调试函数
 * @param $content
 * @param $is_die
 */
function pre($content, $is_die = true)
{
    header('Content-type: text/html; charset=utf-8');
    echo '<pre>' . print_r($content, true);
    $is_die && die();
}

/**
 * 驼峰命名转下划线命名
 * @param $str
 * @return string
 */
function toUnderScore($str)
{
    $dstr = preg_replace_callback('/([A-Z]+)/', function ($matchs) {
        return '_' . strtolower($matchs[0]);
    }, $str);
    return trim(preg_replace('/_{2,}/', '_', $dstr), '_');
}

/**
 * 生成密码hash值
 * @param $password
 * @return string
 */
function fbshop_hash($password)
{
    return md5(md5($password) . 'fbshop_salt_SmTRx');
}

/**
 * 获取当前域名及根路径
 * @return string
 */
function base_url()
{
    static $baseUrl = '';
    if (empty($baseUrl)) {
        $request = Request::instance();
        $subDir = str_replace('\\', '/', dirname($request->server('PHP_SELF')));
        $baseUrl = $request->scheme() . '://' . $request->host() . $subDir . ($subDir === '/' ? '' : '/');
        // $baseUrl = 'https://' . $request->host() . $subDir . ($subDir === '/' ? '' : '/');
    }
    return $baseUrl;
}

/**
 * 写入日志 (废弃)
 * @param string|array $values
 * @param string $dir
 * @return bool|int
 */
//function write_log($values, $dir)
//{
//    if (is_array($values))
//        $values = print_r($values, true);
//    // 日志内容
//    $content = '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . $values . PHP_EOL . PHP_EOL;
//    try {
//        // 文件路径
//        $filePath = $dir . '/logs/';
//        // 路径不存在则创建
//        !is_dir($filePath) && mkdir($filePath, 0755, true);
//        // 写入文件
//        return file_put_contents($filePath . date('Ymd') . '.log', $content, FILE_APPEND);
//    } catch (\Exception $e) {
//        return false;
//    }
//}

/**
 * 写入日志 (使用tp自带驱动记录到runtime目录中)
 * @param $value
 * @param string $type
 */
function log_write($value, $type = 'yoshop-info')
{
    $msg = is_string($value) ? $value : var_export($value, true);
    Log::record($msg, $type);
}

/**
 * curl请求指定url (get)
 * @param $url
 * @param array $data
 * @return mixed
 */
function curl($url, $data = [])
{
    // 处理get数据
    if (!empty($data)) {
        $url = $url . '?' . http_build_query($data);
    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

/**
 * curl请求指定url (post)
 * @param $url
 * @param array $data
 * @return mixed
 */
function curlPost($url, $data = [])
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

if (!function_exists('array_column')) {
    /**
     * array_column 兼容低版本php
     * (PHP < 5.5.0)
     * @param $array
     * @param $columnKey
     * @param null $indexKey
     * @return array
     */
    function array_column($array, $columnKey, $indexKey = null)
    {
        $result = array();
        foreach ($array as $subArray) {
            if (is_null($indexKey) && array_key_exists($columnKey, $subArray)) {
                $result[] = is_object($subArray) ? $subArray->$columnKey : $subArray[$columnKey];
            } elseif (array_key_exists($indexKey, $subArray)) {
                if (is_null($columnKey)) {
                    $index = is_object($subArray) ? $subArray->$indexKey : $subArray[$indexKey];
                    $result[$index] = $subArray;
                } elseif (array_key_exists($columnKey, $subArray)) {
                    $index = is_object($subArray) ? $subArray->$indexKey : $subArray[$indexKey];
                    $result[$index] = is_object($subArray) ? $subArray->$columnKey : $subArray[$columnKey];
                }
            }
        }
        return $result;
    }
}

/**
 * 多维数组合并
 * @param $array1
 * @param $array2
 * @return array
 */
function array_merge_multiple($array1, $array2)
{
    $merge = $array1 + $array2;
    $data = [];
    foreach ($merge as $key => $val) {
        if (
            isset($array1[$key])
            && is_array($array1[$key])
            && isset($array2[$key])
            && is_array($array2[$key])
        ) {
            $data[$key] = array_merge_multiple($array1[$key], $array2[$key]);
        } else {
            $data[$key] = isset($array2[$key]) ? $array2[$key] : $array1[$key];
        }
    }
    return $data;
}

/**
 * 二维数组排序
 * @param $arr
 * @param $keys
 * @param bool $desc
 * @return mixed
 */
function array_sort($arr, $keys, $desc = false)
{
    $key_value = $new_array = array();
    foreach ($arr as $k => $v) {
        $key_value[$k] = $v[$keys];
    }
    if ($desc) {
        arsort($key_value);
    } else {
        asort($key_value);
    }
    reset($key_value);
    foreach ($key_value as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}

/**
 * 数据导出到excel(csv文件)
 * @param $fileName
 * @param array $tileArray
 * @param array $dataArray
 */
function export_excel($fileName, $tileArray = [], $dataArray = [])
{
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 0);
    // ob_end_clean();
    ob_start();
    header("Content-Type: text/csv");
    header("Content-Disposition:attachment;filename=" . $fileName);
    $fp = fopen('php://output', 'w');
    fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));// 转码 防止乱码(比如微信昵称)
    fputcsv($fp, $tileArray);
    $index = 0;
    foreach ($dataArray as $item) {
        if ($index == 1000) {
            $index = 0;
            ob_flush();
            flush();
        }
        $index++;
        fputcsv($fp, $item);
    }
    ob_flush();
    flush();
    ob_end_clean();
}

/**
 * 隐藏敏感字符
 * @param $value
 * @return string
 */
function substr_cut($value)
{
    $strlen = mb_strlen($value, 'utf-8');
    if ($strlen <= 1) return $value;
    $firstStr = mb_substr($value, 0, 1, 'utf-8');
    $lastStr = mb_substr($value, -1, 1, 'utf-8');
    return $strlen == 2 ? $firstStr . str_repeat('*', $strlen - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
}

/**
 * 获取当前系统版本号
 * @return mixed|null
 * @throws Exception
 */
function get_version()
{
    static $version = null;
    if ($version) {
        return $version['version'];
    }
    $file = dirname(ROOT_PATH) . '/version.json';
    if (!file_exists($file)) {
        throw new Exception('version.json not found');
    }
    $version = json_decode(file_get_contents($file), true);
    if (!is_array($version)) {
        throw new Exception('version cannot be decoded');
    }
    return $version['version'];
}

/**
 * 获取全局唯一标识符
 * @param bool $trim
 * @return string
 */
function getGuidV4($trim = true)
{
    // Windows
    if (function_exists('com_create_guid') === true) {
        $charid = com_create_guid();
        return $trim == true ? trim($charid, '{}') : $charid;
    }
    // OSX/Linux
    if (function_exists('openssl_random_pseudo_bytes') === true) {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    // Fallback (PHP 4.2+)
    mt_srand((double)microtime() * 10000);
    $charid = strtolower(md5(uniqid(rand(), true)));
    $hyphen = chr(45);                  // "-"
    $lbrace = $trim ? "" : chr(123);    // "{"
    $rbrace = $trim ? "" : chr(125);    // "}"
    $guidv4 = $lbrace .
        substr($charid, 0, 8) . $hyphen .
        substr($charid, 8, 4) . $hyphen .
        substr($charid, 12, 4) . $hyphen .
        substr($charid, 16, 4) . $hyphen .
        substr($charid, 20, 12) .
        $rbrace;
    return $guidv4;
}

/**
 * 时间戳转换日期
 * @param $timeStamp
 * @return false|string
 */
function format_time($timeStamp)
{
    return date('Y-m-d H:i:s', $timeStamp);
}

/**
 * 左侧填充0
 * @param $value
 * @param int $padLength
 * @return string
 */
function pad_left($value, $padLength = 2)
{
    return \str_pad($value, $padLength, "0", STR_PAD_LEFT);
}

/**
 * 过滤emoji表情
 * @param $text
 * @return null|string|string[]
 */
function filter_emoji($text)
{
    // 此处的preg_replace用于过滤emoji表情
    // 如需支持emoji表情, 需将mysql的编码改为utf8mb4
    return preg_replace('/[\xf0-\xf7].{3}/', '', $text);
}

/**
 * 根据指定长度截取字符串
 * @param $str
 * @param int $length
 * @return bool|string
 */
function str_substr($str, $length = 30)
{
    if (strlen($str) > $length) {
        $str = mb_substr($str, 0, $length, 'utf-8');
    }
    return $str;
}

/**
 * 根据起点坐标和终点坐标测距离
 * @param  [array]   $from  [起点坐标(经纬度),例如:array(118.012951,36.810024)]
 * @param  [array]   $to    [终点坐标(经纬度)]
 * @param  [bool]    $km        是否以公里为单位 false:米 true:公里(千米)
 * @param  [int]     $decimal   精度 保留小数位数
 * @return [string]  距离数值
 */
function get_distance($from,$to,$km=true,$decimal=2){
    sort($from);
    sort($to);
    $EARTH_RADIUS = 6370.996; // 地球半径系数

    $distance = $EARTH_RADIUS*2*asin(sqrt(pow(sin( ($from[0]*pi()/180-$to[0]*pi()/180)/2),2)+cos($from[0]*pi()/180)*cos($to[0]*pi()/180)* pow(sin( ($from[1]*pi()/180-$to[1]*pi()/180)/2),2)))*1000;

    if($km){
        $distance = $distance / 1000;
    }
    return round($distance, $decimal);
}

function to_km($distance)
{
    return sprintf("%.2f",$distance / 1000).'km';
}
/**
 * 求两个日期之间相差的天数
 * (针对1970年1月1日之后，求之前可以采用泰勒公式)
 * @param string $day1
 * @param string $day2
 * @return number
 */

function diffBetweenTwoDays($day1, $day2)
{
    $second1 = strtotime($day1);
    $second2 = strtotime($day2);

    if ($second1 < $second2) {
        $tmp = $second2;
        $second2 = $second1;
        $second1 = $tmp;
    }
    return ($second1 - $second2) / 86400;
}

/**
 * 中文切割
 */
function utf8_str_split($str, $split_len = 1)
{
    if (!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1)
        return FALSE;
    $len = mb_strlen($str, 'UTF-8');
    if ($len <= $split_len)
        return array($str);
    preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);
    return $ar[0];
}

/**
 * 变量替换
 */
function str_replace_template($html, $params)
{
    foreach ($params as $key => $value)
    {
        $html = str_replace('${'.$key.'}',$value,$html);
    }
    return $html;
}

//用户名、邮箱、手机账号中间字符串以*隐藏
function hide_star($str)
{
    if (strpos($str, '@')) {
        $email_array = explode("@", $str);
        $prevfix = (strlen($email_array[0]) < 4) ? "" : substr($str, 0, 3); //邮箱前缀
        $count = 0;
        $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $str, -1, $count);
        $rs = $prevfix . $str;
    } else {
        $pattern = '/(1[3458]{1}[0-9])[0-9]{4}([0-9]{4})/i';
        if (preg_match($pattern, $str)) {
            $rs = preg_replace($pattern, '$1****$2', $str);
        } else {
            $rs = substr($str, 0, 3) . "***" . substr($str, -1);
        }
    }
    return $rs;
}


function validate_phone($data)
{
    $validate = new Validate(
        [
            'phone_number' =>  ['require','regex'=>'/^1(3[0-9]|4[01456879]|5[0-35-9]|6[2567]|7[0-8]|8[0-9]|9[0-35-9])\d{8}$/'],
        ],
        [
            'phone_number.require' => lang('phone_number_empty'),
            'phone_number.regex' => lang('phone_number_error'),
        ]);
    if(!$validate->check($data)){
        throw new \app\common\exception\BaseException(['msg' => $validate->getError()]);
    }
}


/**
 * @throws \app\common\exception\BaseException
 */
function validate_email($data)
{
    $validate = new Validate(
        [
            'email' =>  'require|email',
        ],
        [
            'email.require' => lang('email_empty'),
            'email.email' => lang('email_error'),
        ]);
    if(!$validate->check($data)){
        throw new \app\common\exception\BaseException(['msg' => $validate->getError()]);
    }
}

/**
 * @throws \app\common\exception\BaseException
 */
function validate_password($data)
{
    $validate = new Validate(
        [
            'password' =>  'require',
        ],
        [
            'password.require' => lang('password_empty'),
        ]);
    if(!$validate->check($data)){
        throw new \app\common\exception\BaseException(['msg' => $validate->getError()]);
    }
}
function default_avatar()
{
    return config('web_domain').'assets/common/i/user_default_avatar.png';
}
function default_nickname($id)
{
    return lang('puzhen').$id;
}
function getCategoryIdBySlug($slug)
{
    $model = new \app\common\model\Category;
    return $model->where('slug',$slug)->value('category_id') ?: $model->order(['sort' => 'asc', 'create_time' => 'asc'])->value('category_id');
}