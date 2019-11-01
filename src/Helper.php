<?php
namespace cncoders\helper;

class Helper
{
    /**
     * 格式化价格 保留到两位小数
     * @param $price
     * @return string
     */
    public static function formatPrice($price) :string
    {
        return sprintf("%.2f", $price);
    }

    /**
     * 将字符串拆分成数组
     * @param $string
     * @return mixed
     */
    public static function stringToArray($string) :array
    {
        preg_match_all("/./u", $string, $math);
        return $math[0];
    }

    /**
     * 生成唯一订单号
     * @param string $prefix
     * @return string
     */
    public static function builderOrderSn($prefix = '') :string
    {
        $prefix = !empty($prefix) ? $prefix : '';
        return  $prefix . date('Ymd') .
            substr(microtime(), 2, 5) .
            substr(implode(NULL,
                array_map('ord', str_split(substr(uniqid($prefix), 7, 13), 1))
            ), 0, 8).
            sprintf('%04d', rand(0, 9999));
    }

    /**
     * 生成UUID
     * @param bool $strtoupper 是否转换为大小写输出
     * @param string $spilt 链接字符 false表示不连接
     * @return string
     * @throws \Exception
     */
    public static function uuid( $strtoupper = false , $spilt = '-') :string
    {
        $str = uniqid('',true);
        $arr = explode('.',$str);
        $str = base_convert($arr[0],16,36) .
            base_convert($arr[1],10,36).
            base_convert(bin2hex(random_bytes(5)),16,36);
        $len = 24;
        $str = substr($str,0,$len);
        if(strlen($str) < $len){
            $mt = base_convert(bin2hex(random_bytes(5)),16,36);
            $str = $str.substr($mt,0,$len - strlen($str));
        }
        if ( $spilt ) {
            $str = substr($str, 0, 5) . $spilt .
                substr($str, 5, 5) . $spilt .
                substr($str, 15, 5) . $spilt .
                substr($str, 20, $len);
        }
        return $strtoupper ? strtoupper($str) : $str;
    }

    /**
     * 对APP等客户端传过来的表情符号进行处理 入库
     * @param string $content
     * @return string
     */
    public static function encodeLook($content = '') :string
    {
        return preg_replace_callback('/[\xf0-\xf7].{3}/', function($r) {
            return '@E' . base64_encode($r[0]);
            }, $content);
    }

    /**
     * 返回内容的时候对 使用encodeLook加密过的表情进行转换
     * @param string $content
     * @return string
     */
    public static function decodeLook($content = ''):string
    {
        return preg_replace_callback('/@E(.{6}==)/', function($r) {
            return base64_decode($r[1]);
            }, $content);
    }
}