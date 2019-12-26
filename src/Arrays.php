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
    public static function hasDoubleArray(array $array)
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
    public static function inArray($key, $array)
    {
        $arrayFlip = array_flip($array);
        return isset($arrayFlip[$key]);
    }

    /**
     * 冒泡排序
     * @param $array
     * @param string $sort
     * @return mixed
     */
    public static function bubbSort($array, $sort = 'desc')
    {
        if(empty($array)) return $array;
        //默认有序
        $isSorted   = true;
        $Count     = count($array);
        for($i = 0; $i < $Count; $i++) {
            //对比次数随着循环逐渐减少，因为后面的数据已经处理为有序
            for($j = 0; $j < ($Count - $i - 1); $j++) {
                //执行判断
                $isChange = $sort == 'desc' ? $array[$j] < $array[$j+1] : $array[$j] > $array[$j+1];
                if($isChange) {
                    //首次对比，判断是否有序
                    $isSorted       = false;
                    $temp           = $array[$j];
                    $array[$j]      = $array[$j+1];
                    $array[$j+1]    = $temp;
                }
            }
            if($isSorted) break;
        }
        unset($i, $j, $isSorted, $temp, $Count);
        return $array;
    }

    /**
     * 快速排序
     * @param $array
     * @param string $sort
     * @return array
     */
    public static function quickSort($array, $sort = 'desc')
    {
        //检查数据，多于一个数据才执行
        $nCount = count($array);
        if($nCount > 1) {
            //选取标准（第一个数据）
            $nStandard = $array[0];
            $arrLeftData = [];
            $arrRightData = [];
            //遍历，注意这里从1开始比较
            for($i = 1; $i < $nCount; $i++) {
                if($sort == 'desc') {
                    $array[$i] > $nStandard ? $arrLeftData[] = $array[$i] : $arrRightData[] = $array[$i];
                } else {
                    $array[$i] > $nStandard ? $arrRightData[] = $array[$i] : $arrLeftData[] = $array[$i];
                }
            }
            $array = array_merge(
                self::quickSort($arrLeftData, $sort),
                array($nStandard),
                self::quickSort($arrRightData, $sort)
            );
        }
        return $array;
    }

    /**
     * 二分查找
     * @param $toSearch
     * @param $array
     * @return bool|int
     */
    public static function twoPointSearch($toSearch, $array)
    {
        //确定当前的检索范围
        $nCount = count($array);
        //低位键，初始为0
        $nLowNum = 0;
        //高位键，初始为末尾
        $nHighNum = $nCount - 1;
        while($nLowNum <= $nHighNum) {
            //选定大概中间键
            $nMiddleNum = intval(($nHighNum + $nLowNum)/2);
            if($array[$nMiddleNum] > $toSearch) {
                //比检索值大
                $nHighNum = $nMiddleNum - 1;
            } elseif ($array[$nMiddleNum] < $toSearch) {
                //比检索值小
                $nLowNum = $nMiddleNum + 1;
            } else {
                return $nMiddleNum;
            }
        }
        return false;
    }

    /**
     * 数组的无限极分类
     * @param $array
     * @param string $parent
     * @param int $id
     * @param int $level
     * @return array
     */
    public static function toTree($array, $parent = 'pid', $id = 0, $level = 0)
    {
        static $list =array();
        foreach ($array as $k=>$v){
            if ($v[$parent] == $id){
                $v['level']=$level;
                $v['son'] = self::toTree($array, $parent, $v['id'],$level+1);
                $list[] = $v;
            }
        }
        return $list;
    }
}