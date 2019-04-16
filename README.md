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



