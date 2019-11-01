<?php
namespace cncoders\helper;

/**
 * 数组相关的一些处理
 * Class Arr
 * @package helper
 */
class Arrays
{
    /**
     * 判断一个数组是否是二维数组
     * @param $array
     * @return bool
     */
    public static function hasDoubleArray(array $array) :bool
    {
        return count($array) == count($array, 1);
    }

    /**
     * 计算指定二维数组里面某个字段的总和
     * @param array $array 数组
     * @param $coloum  指定字段
     * @return float
     */
    public static function sumArray(array $array, $coloum)
    {
        return array_sum(array_column($array, $coloum));
    }

    /**
     * 计算数组里面某个单价的总和 精确到分
     * @param array $array
     * @param $column
     * @return string
     */
    public static function sumArrayWithPrice(array $array, $column)
    {
        $total = self::sumArray($array, $column);
        return Helper::formatPrice($total);
    }

    /**
     * 大数组中用于替换in_array或者array_search
     * @param $key
     * @param $array
     * @return bool
     */
    public static function inArray($key, $array) :bool
    {
        $arrayFlip = array_flip($array);
        return isset($arrayFlip[$key]);
    }
}