# php_functions
自己整理的php在项目中常用的方法，不依赖任何第三方库

- [二维数组排序 array_order_by(array,field1,sort,field2,sort[,...])](/functions.php)

> 对二维数组根据选定字段进行排序

```
 @param   array   $data   排序的二维数组
 @param   string  $filed  排序的字段
 @param   string  $sort   排序的方式 SORT_DESC SORT_ASC
 @return array 排序后的数组
 
$array = [
     ['a'=>1,'b'=>2,'c'=>3],
     ['a'=>3,'b'=>4,'c'=>1],
     ['a'=>4,'b'=>3,'c'=>3],
     ['a'=>2,'b'=>3,'c'=>3],
];

$sorted = array_order_by($array, 'a', SORT_DESC, 'b', SORT_ASC);
```

- [cURL Request请求 curl_request(url,data,method,timeout,headerArray)](/functions.php)

> 通过php cURL扩展 模拟发送 POST、GET、RESTFUL风格等请求

```
 * @param   string      $url     请求地址
 * @param   array       $data    需要发送的数据
 * @param   string      $method  请求方法
 * @param   integer     $timeout 超时时间
 * @param   array       $headerArray 请求header头
 * @return  array       网站数据返回
 
$request = curl_request('demo.test/request.php',['id'=>3123123],'POST',10);
```

- [日志写入 write_log($log = '' ,$flag = '',$level = 'log',$path = '')](/functions.php)

> 在指定位置将变量写入到文件

```
@param   $log    string/array    日志数据
@param   $flag   string          日志标志
@param   $level  string          日志级别(相当于日志文件前缀，根据日志级别写入对应级别日志文件)
@param   $path   string          日志目录

write_log([1,2,3,4,5,6,7],'======= debug ======'，'error');
```

- [字符串加解密 str_encrypt_decrypt($data, $key,$crypt = 1)](/functions.php)

> 字符串的可逆加解密

```
@param $data     string  需要加密(解密)的字符串
@param $key      string  字符串加密(解密)的秘钥
@param $crypt    integer 字符串加密(解密)的秘钥 1：加密；2：解密
@return string/boolean 成功返回字符串、失败返回 false
//加密
$str = str_encrypt_decrypt(123123,'key',1);
//解密
str_encrypt_decrypt($str,'key',2);
```
- [数组子孙树的递归实现 array_subtree_recursive($array , $pid = 0 ,$_pk = 'id', $_pid = 'pid', $level =0)](/functions.php)

> 通过递归方式实现数组的子孙树排序，通常运用于分类等的展示，效率低但是程序结构清晰

```
@param   array   $array  递归数组
@param   string  $pid    起始节点
@param   string  $_pk    主键字段
@param   string  $_pid   父级字段
@param   string  $level  层级标识
@return  array 排序后的数组

$tmp = array(
    array('id'=>1 , 'name'=>'首页' , 'pid'=>'0'),
    array('id'=>2 , 'name'=>'新闻中心' , 'pid'=>'1'),
    array('id'=>3 , 'name'=>'娱乐新闻' , 'pid'=>'2'),
    array('id'=>4 , 'name'=>'军事要闻' , 'pid'=>'2'),
    array('id'=>5 , 'name'=>'体育新闻' , 'pid'=>'2'),
    array('id'=>6 , 'name'=>'博客' , 'pid'=>'1'),
    array('id'=>7 , 'name'=>'旅游日志' , 'pid'=>'6'),
    array('id'=>8 , 'name'=>'心情' , 'pid'=>'6'),
    array('id'=>9 , 'name'=>'小小说' , 'pid'=>'6'),
    array('id'=>10 , 'name'=>'明星' , 'pid'=>'3'),
    array('id'=>11 , 'name'=>'网红' , 'pid'=>'3')
);

$res = array_subtree_recursive($tmp);

```


- [数组子孙树的迭代实现 array_subtree_iteration($array , $pid = 0 ,$_pk = 'id', $_pid = 'pid')](/functions.php)

> 通过迭代方式实现数组的子孙树排序，通常运用于分类等的展示，效率高但是程序结构复杂

```
@param   array   $array  递归数组
@param   string  $pid    起始节点
@param   string  $_pk    主键字段
@param   string  $_pid   父级字段
@return  array 排序后的数组

$tmp = array(
    array('id'=>1 , 'name'=>'首页' , 'pid'=>'0'),
    array('id'=>2 , 'name'=>'新闻中心' , 'pid'=>'1'),
    array('id'=>3 , 'name'=>'娱乐新闻' , 'pid'=>'2'),
    array('id'=>4 , 'name'=>'军事要闻' , 'pid'=>'2'),
    array('id'=>5 , 'name'=>'体育新闻' , 'pid'=>'2'),
    array('id'=>6 , 'name'=>'博客' , 'pid'=>'1'),
    array('id'=>7 , 'name'=>'旅游日志' , 'pid'=>'6'),
    array('id'=>8 , 'name'=>'心情' , 'pid'=>'6'),
    array('id'=>9 , 'name'=>'小小说' , 'pid'=>'6'),
    array('id'=>10 , 'name'=>'明星' , 'pid'=>'3'),
    array('id'=>11 , 'name'=>'网红' , 'pid'=>'3')
);

$res = array_subtree_iteration($tmp);

```



- [数组子孙树的递归实现 array_ancestry_recursive($data , $id, $_pk = 'id' ,$_ppk = 'pid')](/functions.php)

> 通过递归方式实现数组的家谱树排序，通常运用于网站面包屑导航等

```
@param   array   $data   递归数组
@param   string  $pid    起始节点
@param   string  $_pk    主键字段
@param   string  $_ppk   父级字段
@return  array 排序后的数组

$tmp = array(
    array('id'=>1 , 'name'=>'首页' , 'pid'=>'0'),
    array('id'=>2 , 'name'=>'新闻中心' , 'pid'=>'1'),
    array('id'=>3 , 'name'=>'娱乐新闻' , 'pid'=>'2'),
    array('id'=>4 , 'name'=>'军事要闻' , 'pid'=>'2'),
    array('id'=>5 , 'name'=>'体育新闻' , 'pid'=>'2'),
    array('id'=>6 , 'name'=>'博客' , 'pid'=>'1'),
    array('id'=>7 , 'name'=>'旅游日志' , 'pid'=>'6'),
    array('id'=>8 , 'name'=>'心情' , 'pid'=>'6'),
    array('id'=>9 , 'name'=>'小小说' , 'pid'=>'6'),
    array('id'=>10 , 'name'=>'明星' , 'pid'=>'3'),
    array('id'=>11 , 'name'=>'网红' , 'pid'=>'3')
);

$res = array_ancestry_recursive($tmp,3);

```


- [数组子孙树的迭代实现 array_ancestry_iteration($data , $id, $_pk = 'id' ,$_ppk = 'pid')](/functions.php)

> 通过迭代方式实现数组的家谱树排序，通常运用于网站面包屑导航等

```
@param   array   $data   递归数组
@param   string  $id     起始节点
@param   string  $_pk    主键字段
@param   string  $_ppk   父级字段
@return  array 排序后的数组

$tmp = array(
    array('id'=>1 , 'name'=>'首页' , 'pid'=>'0'),
    array('id'=>2 , 'name'=>'新闻中心' , 'pid'=>'1'),
    array('id'=>3 , 'name'=>'娱乐新闻' , 'pid'=>'2'),
    array('id'=>4 , 'name'=>'军事要闻' , 'pid'=>'2'),
    array('id'=>5 , 'name'=>'体育新闻' , 'pid'=>'2'),
    array('id'=>6 , 'name'=>'博客' , 'pid'=>'1'),
    array('id'=>7 , 'name'=>'旅游日志' , 'pid'=>'6'),
    array('id'=>8 , 'name'=>'心情' , 'pid'=>'6'),
    array('id'=>9 , 'name'=>'小小说' , 'pid'=>'6'),
    array('id'=>10 , 'name'=>'明星' , 'pid'=>'3'),
    array('id'=>11 , 'name'=>'网红' , 'pid'=>'3')
);

$res = array_ancestry_iteration($tmp,3);

```

- [获取客户端IP地址 get_client_ip($type = 0,$adv=false)](/functions.php)

> 获取客户端IP地址

```
@param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
@param boolean $adv  是否进行高级模式获取（有可能被伪装）
@return mixed

$client_ip = get_client_ip();

```





