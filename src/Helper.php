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

    /**
     * 获取汉字拼音的首字母
     * @param $str
     * @return string|null
     */
    public static function firstCharter($str) :string
    {
        static $fchar;
        if (empty($str)) return '';
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
        $s1 = iconv('UTF-8', 'gb2312', $str);
        $s2 = iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) return 'A';
        if ($asc >= -20283 && $asc <= -19776) return 'B';
        if ($asc >= -19775 && $asc <= -19219) return 'C';
        if ($asc >= -19218 && $asc <= -18711) return 'D';
        if ($asc >= -18710 && $asc <= -18527) return 'E';
        if ($asc >= -18526 && $asc <= -18240) return 'F';
        if ($asc >= -18239 && $asc <= -17923) return 'G';
        if ($asc >= -17922 && $asc <= -17418) return 'H';
        if ($asc >= -17417 && $asc <= -16475) return 'J';
        if ($asc >= -16474 && $asc <= -16213) return 'K';
        if ($asc >= -16212 && $asc <= -15641) return 'L';
        if ($asc >= -15640 && $asc <= -15166) return 'M';
        if ($asc >= -15165 && $asc <= -14923) return 'N';
        if ($asc >= -14922 && $asc <= -14915) return 'O';
        if ($asc >= -14914 && $asc <= -14631) return 'P';
        if ($asc >= -14630 && $asc <= -14150) return 'Q';
        if ($asc >= -14149 && $asc <= -14091) return 'R';
        if ($asc >= -14090 && $asc <= -13319) return 'S';
        if ($asc >= -13318 && $asc <= -12839) return 'T';
        if ($asc >= -12838 && $asc <= -12557) return 'W';
        if ($asc >= -12556 && $asc <= -11848) return 'X';
        if ($asc >= -11847 && $asc <= -11056) return 'Y';
        if ($asc >= -11055 && $asc <= -10247) return 'Z';
        return null;
    }

    /**
     * 递归移动目录所有内容到指定目录
     * @param $disDir     旧目录
     * @param $targetDir   目标目录
     * @return bool
     * @throws \Exception
     */
    public static function copyDir($disDir, $targetDir)
    {
        if ( !is_dir($disDir) ) {
            throw new \Exception('源目录不存在无法移动!');
        }

        if ( !is_dir($targetDir) ) {
            mkdir($targetDir , 0770, true);
        }

        $dir = opendir($disDir);
        while ( false !== ($file = readdir($dir)) ) {
            if($file != "." && $file !="..") {
                $disFile = $disDir . DIRECTORY_SEPARATOR . $file;
                if ( is_dir($disFile) ) {
                    self::copyDir( $disFile, $targetDir . DIRECTORY_SEPARATOR . $file);
                    continue;
                }else {
                    copy($disFile, $targetDir . DIRECTORY_SEPARATOR . $file);
                }
            }
        }
        closedir($dir);
        return true;
    }
}