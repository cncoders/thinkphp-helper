# thinkphp-helper

# 说明

从网上搜罗了一些经常会用的一些对数组字符等处理的一些方法，如果大家有需要增加的也可以留言

# 使用

```

//对价格保留两位小数格式化
\cncoders\helper\Helper::formatPrice(2); // 2.00

//将字符串拆解为数组
\cncoders\helper\Helper::stringToArray('abcdefg');

//生成唯一的订单号 我尝试一次性生成几千个都没有重复 具体参数参考方法或IDE提示
\cncoders\helper\Helper::builderOrderSn();

//生成UUID 具体参数参考代码
\cncoders\helper\Helper::uuid();

//对客户端传过来的带有输入法自带表情的数据进行处理
\cncoders\helper\Helper::encodeLook();

//对处理的客户端带表情符号的数据进行还原给客户端
\cncoders\helper\Helper::decodeLook();

//判断一个数组是否是二维数组
\cncoders\helper\Arrays::hasDoubleArray();

//计算指定二维数组里面某个字段的总和
\cncoders\helper\Arrays::sumArray();

//计算二维数组里面某个单价的总和 精确到分
\cncoders\helper\Arrays::sumArrayWithPrice();

//用于在大数组中替代in_array的方法 据说性能比in_array没有亲自对比性能 可以根据自己需求来定
\cncoders\helper\Arrays::inArray();

#以下功能1.0.2新增

//数组冒泡排序
\cncoders\helper\Arrays::bubbSort($array, $sort = 'desc');

//快速排序
\cncoders\helper\Arrays::quickSort($array, $sort = 'desc');

//二分查找
\cncoders\helper\Arrays::twoPointSearch($toSearch, $array);

//获取字符串拼音首字母
\cncoders\helper\Helper::firstCharter($str) :string

#以下功能1.0.3新增

//复制指定目录下所有文件目录到指定目录
\cncoders\helper\Helper::copyDir($disDir, $targetDir):bool

//比较两个版本号的大小
\cncoders\helper\Helper::compareVersion('1.0.1', '1.0.2):int

//无限级分类树
\cncoders\helper\Arrays::toTree($array, $parent = 'pid', $id = 0, $level = 0);

```
