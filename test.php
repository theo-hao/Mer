<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pily_K
 * Date: 13-3-19
 * Time: 下午6:42
 * To change this template use File | Settings | File Templates.
 */
//
//$pattern = "/^user\/(:num)$/i";
//$url = "user/35";
//$r_pattern = str_replace(":num", "[\\d]*", $pattern);
//echo $r_pattern;
//if (preg_match($r_pattern, $url, $matches))
//{
//    var_dump($matches);
//}

//$class = 'dcir' . DIRECTORY_SEPARATOR . "xxxs";
//
//echo strpos($class, DIRECTORY_SEPARATOR, (strlen($class) - 1));

//$pattern = '/^user\/list\/([\d]+)[\/]([\d]*)$/i';
//$string = 'user/list/35/';;
//preg_match($pattern, $string, $matches);
//var_dump($matches);


//$pattern = "/^user\/(?'word'[\\w]+)\/(?'word'[\\w]+)$/i";
//$string = 'user/xxx/xxe';
//preg_match($pattern, $string, $m);
//var_dump($m);

//$pattern = '/^user[\/]list[\/](?:num)$/i';
//$null_or_number = explode('(?:num)', $pattern);
//$pattern = '';
//for($i =1; $i< count($null_or_number); $i++ )
//{
//    $pattern .= $null_or_number[$i-1];
//    echo 'xe';
//    echo $pattern;
//}
//
//
//Router::action("user/list", 'user@list');

//$string = '/xxx/sdf';
//echo ltrim($string, '/');

//$string = 'base.user@';
////$pattern = '/^([\w\W^@]*)@([\w]*)$/i';
//$pattern = "/^(?'controller'[\w\W^@]*)@(?'action'[\w\W]*)$/i";
//preg_match($pattern, $string, $matches);
//var_dump($matches);
//
//$pattern = "/^([\\w\.]*)$/i";
//$string = "base.user";
//if (preg_match($pattern, $string, $matches))
//{
//    var_dump($matches);
//}

//echo strrpos('123', '23');

//$object = 'TestOBJE';
//$string = "echo 'PHP'; echo '<span>HTML SPAN</span>'; echo $object;";
//eval($string);

//$size = "large";
//$var_array = array("color" => "blue",
//    "size"  => "medium",
//    "shape" => "sphere");
//extract($var_array, EXTR_PREFIX_SAME , "wddx");
//
////echo "$color, $size, $shape, $wddx_size\n";
//$str = "echo \"$color, $size, $shape, $wddx_size\n\";";
//eval($str);

//$reg = '/\d+/';
//$s = '123s32';
//preg_match_all($reg,$s, $m);
//preg_match($reg, $s, $m2);
//var_dump($m);
//var_dump($m2);

//
//function GBsubstr($string, $start, $length) {
//    if(strlen($string)>$length){      //strlen得到字符串的长度
//        $str=null;
//        $len=$start+$length;
//        for($i=$start;$i<$len;$i++){
//            if(ord(substr($string,$i,1))>0xa0){
//                $str.=substr($string,$i,2);
//                $i++;
//            }else{
//                $str.=substr($string,$i,1);
//            }
//        }
//        return $str.'...';
//    }else{
//        return $string;
//    }
//}
//
//function utf8_substr($string, $start, $length)
//{
//    if( is_string($string) && mb_check_encoding($string, 'utf-8'))
//    {
//        return mb_substr($string, $start, $length, 'utf-8');
//    }
//}
//
//echo utf8_substr('这里是一段测试性文字', 2,3);
//echo utf8_substr('This is a test string', 2, 3);
//echo utf8_substr('This is 测试性文字', 1, 20);

header("Location:http://www.baidu.com");