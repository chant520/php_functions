<?php
/**
 * 函数库
 * auth:chantszo <chant.vip@qq.com>
 * data:更新于 2019年4月15日10:39:32
 * fun_version:0.0.1
 * php_version:7.0
 */

/**
 * 方法：二维数组排序
 * 描述：对二维数组根据选定字段进行排序
 * 时间：2019年4月15日10:40:57
 * 使用示例：
 * $array = [
 *      ['a'=>1,'b'=>2,'c'=>3],
 *      ['a'=>3,'b'=>4,'c'=>1],
 *      ['a'=>4,'b'=>3,'c'=>3],
 *      ['a'=>2,'b'=>3,'c'=>3],
 * ];
 * $sorted = array_order_by($array, 'a', SORT_DESC, 'b', SORT_ASC);
 * @param   array   $data   排序的二维数组
 * @param   string  $filed  排序的字段
 * @param   string  $sort   排序的方式 SORT_DESC SORT_ASC
 * @return array 排序后的数组
 */
if (!function_exists('array_order_by')){
    function array_order_by() {
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $args[$n] =  array_column($data,$field);;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }
}
/**
 * 方法：数组子孙树的递归实现
 * 描述：通过递归方式实现数组的子孙树排序，通常运用于分类等的展示
 * 时间：2019年4月16日11:04:06
 * @param   array   $array  递归数组
 * @param   string  $pid    起始节点
 * @param   string  $_pk    主键字段
 * @param   string  $_ppk   父级字段
 * @param   string  $level  层级标识
 * @return  array 排序后的数组
 */
if(!function_exists('array_subtree_recursive')){
    function array_subtree_recursive($array , $pid = 0 ,$_pk = 'id', $_ppk = 'pid', $level =0){
        //也可以用array_merge将每次返回的数组与上一次的进行合并。
        //$data = [];
        static $data = [];
        foreach ($array as $key => $value){
            if($value[$_ppk] == $pid){
                $value['level'] = $level;
                //$data = array_merge($data,$value);
                $data[] = $value;
                array_subtree_recursive($array,$value[$_pk],$_pk,$_ppk,$level+1);
            }
        }
        return $data;
    }
}

/**
 * 方法：数组子孙树的迭代实现
 * 描述：通过递归方式实现数组的子孙树排序，通常运用于分类等的展示
 * 时间：2019年4月16日11:04:06
 * @param   array   $array  递归数组
 * @param   string  $pid    起始节点
 * @param   string  $_pk    主键字段
 * @param   string  $_ppk   父级字段
 * @return  array 排序后的数组
 */
if(!function_exists('array_subtree_iteration')){
    function array_subtree_iteration($array , $pid = 0 ,$_pk = 'id', $_ppk = 'pid'){
        $task = [$pid];//任务栈
        $data = [];
        while (!empty($task)){
            $flag = false;
            foreach ($array as $key => $value){
                if($value[$_ppk] == $pid){
                    array_push($task,$value[$_pk]);
                    $data[] = $value;
                    $pid = $value[$_pk];
                    unset($array[$key]);
                    $flag = true;
                }
            }

            if($flag == false){
                array_pop($task);
                $pid = end($task);
            }
        }
        return $data;
    }
}

/**
 * 方法：数组家谱树的递归实现
 * 描述：通过递归方式实现数组的家谱树排序，通常运用于网站面包屑导航等
 * 时间：2019年4月16日14:34:06
 * @param   array   $data   递归数组
 * @param   string  $id     起始节点
 * @param   string  $_pk    主键字段
 * @param   string  $_ppk   父级字段
 * @return  array 排序后的数组
 */
if(!function_exists('array_ancestry_recursive')){
    function array_ancestry_recursive($data , $id, $_pk = 'id' ,$_ppk = 'pid') {
        static $ancestry = array();
        foreach($data as $key => $value) {
            if($value[$_pk] == $id) {
                $ancestry[] = $value;
                array_ancestry_recursive($data , $value[$_ppk]);
            }
        }
        return $ancestry;
    }
}

/**
 * 方法：数组家谱树的迭代实现
 * 描述：通过递归方式实现数组的家谱树排序，通常运用于网站面包屑导航等
 * 时间：2019年4月16日14:59:36
 * @param   array   $data   递归数组
 * @param   string  $id     起始节点
 * @param   string  $_pk    主键字段
 * @param   string  $_ppk   父级字段
 * @return  array 排序后的数组
 */
if(!function_exists('array_ancestry_iteration')){
    function array_ancestry_iteration($data , $id, $_pk = 'id' ,$_ppk = 'pid') {
        $ancestry = array();
        while ($id > 0){
            foreach ($data as $key=>$value){
                if($value[$_pk] == $id){
                    $ancestry[] = $value;
                    $id        = $value[$_ppk];
                }
            }
        }
        return $ancestry;
    }
}

/**
 * 方法：cURL HTTP请求
 * 描述：通过php cURL 模拟发送 POST、GET、RESTFUL风格等请求
 * 时间：2019年4月15日10:40:57
 * 使用示例：
 * $request = curl_request('demo.test/request.php',['id'=>3123123],'POST',10);
 * @param   string      $url     请求地址
 * @param   array       $data    需要发送的数据
 * @param   string      $method  请求方法
 * @param   integer     $timeout 超时时间
 * @param   array       $headerArray 请求header头
 * @return  array       网站数据返回
 *
 */
if(!function_exists('curl_request')) {
    function curl_request($url,$data,$method = 'GET',$timeout = 30,array $headerArray = []){
        $ch = curl_init();
        if(empty($headerArray)){
            /*get*/
            //$headerArray =array("Content-type:application/json;","Accept:application/json");
            /*post*/
            $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");
            /*delete put patch*/
            //$headerArray = array('Content-type:application/json');
        }
        //需要获取的 URL 地址，也可以在curl_init() 初始化会话的时候。
        curl_setopt($ch, CURLOPT_URL, $url);
        //FALSE 禁止 cURL 验证对等证书（peer's certificate）。
        //要验证的交换证书可以在 CURLOPT_CAINFO 选项中设置，或在 CURLOPT_CAPATH中设置证书目录。
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //设置为 1 是检查服务器SSL证书中是否存在一个公用名(common name),(Common Name)一般来讲就是填写你将要申请SSL证书的域名 (domain)或子域名(sub domain)。
        //设置成 2 会检查公用名是否存在，并且是否与提供的主机名匹配。
        //设置成 0 为不检查名称。
        //在生产环境中，这个值应该是 2（默认值）。
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        //HTTP 请求时，使用自定义的 Method 来代替"GET"或"HEAD"。
        //对 "DELETE" 或者其他更隐蔽的 HTTP 请求有用。
        //有效值如 "GET"，"POST"，"CONNECT"等等；也就是说，不要在这里输入整行 HTTP 请求。
        //例如输入"GET /index.html HTTP/1.0\r\n\r\n"是不正确的。
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,$method); //设置请求方式
        if(in_array($method,['POST','PUT','DELETE','PATCH'])){
            $data = json_encode($data);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        //TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //设置 HTTP 头字段的数组。格式： array('Content-type: text/plain', 'Content-length: 100')
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headerArray);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output,true);
        return $output;
    }
}

/**
 * 方法：日志写入
 * 描述：在指定位置将变量写入到文件
 * 时间：2019年4月15日17:40:50
 * 示例：write_log([1,2,3,4,5,6,7],'======= debug ======'，'error');
 * @param   $log    string/array    日志数据
 * @param   $flag   string          日志标志
 * @param   $level  string          日志级别(相当于日志文件前缀，根据日志级别写入对应级别日志文件)
 * @param   $path   string          日志目录
 * @author chantszo
 */
if(!function_exists('write_log')){
    function write_log($log = '' ,$flag = '',$level = 'log',$path = ''){
        if(empty($path)) $path = $level.'_'.date('Y_m_d').'.log';
        $_path = __DIR__.DIRECTORY_SEPARATOR.'_log';
        $fileName = $_path.DIRECTORY_SEPARATOR.$path;
        try{
            $debug_backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,1);
            if(!file_exists($dirname = dirname($fileName))){
                if(!is_dir($dirname)){
                    mkdir(iconv("UTF-8", "GBK", $dirname),0777,true);
                }
            }
            $content = PHP_EOL."[时间:".date('H:i:s')."][文件:".$debug_backtrace[0]['file'].":".$debug_backtrace[0]['line']."]".PHP_EOL;
            if($flag) $content.= $flag.PHP_EOL;

            if(!is_string($log)){
                $content .= var_export($log,true);
            }else{
                $content .= $log;
            }
            error_log($content, 3 ,$fileName);
            return true;
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }
}

/**
 * 方法：字符串加解密
 * 描述：字符串的可逆加解密
 * 时间：2019年4月15日11:03:24
 * @param $data     string  需要加密(解密)的字符串
 * @param $key      string  字符串加密(解密)的秘钥
 * @param $crypt    integer 字符串加密(解密)的秘钥
 * @return string/boolean 成功返回字符串、失败返回 false
 */
if(!function_exists('str_encrypt_decrypt')){
    function str_encrypt_decrypt($data, $key,$crypt = 1)
    {
        $key    =    md5($key);
        $x      =    0;
        $data   =    ($crypt == 2) ? base64_decode($data) : $data;
        $len    =    strlen($data);
        $l      =    strlen($key);
        $char   =    '';
        $str    =    '';
        switch($crypt){
            case 1:
                for ($i = 0; $i < $len; $i++)
                {
                    if ($x == $l)
                    {
                        $x = 0;
                    }
                    $char .= $key{$x};
                    $x++;
                }
                for ($i = 0; $i < $len; $i++)
                {
                    $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
                }
                return base64_encode($str);
                break;
            case 2:
                for ($i = 0; $i < $len; $i++)
                {
                    if ($x == $l)
                    {
                        $x = 0;
                    }
                    $char .= substr($key, $x, 1);
                    $x++;
                }
                for ($i = 0; $i < $len; $i++)
                {
                    if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
                    {
                        $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
                    }
                    else
                    {
                        $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
                    }
                }
                return $str;
                break;
            default:
                return false;

        }

    }
}