<?php

//用户名、邮箱、手机账号中间字符串以*隐藏
if (!function_exists('hide_special_string')) {
    function hide_special_string($str)
    {
        if (strpos($str, '@')) {
            $email_array = explode("@", $str);
            $prefix = (strlen($email_array[0]) < 4) ? "" : substr($str, 0, 3); //邮箱前缀
            $count = 0;
            $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $str, -1, $count);
            $rs = $prefix . $str;
        } else {
            $pattern = '/(1[3458]{1}[0-9])[0-9]{4}([0-9]{4})/i';
            if (preg_match($pattern, $str)) {
                $rs = preg_replace($pattern, '$1****$2', $str); // substr_replace($name,'****',3,4);
            } else {
                $rs = substr($str, 0, 3) . "***" . substr($str, -4);
            }
        }
        return $rs;
    }
}

// 区分邮箱和手机
if (!function_exists('match_email_phone')) {
    function match_email_phone($name)
    {
        preg_match('/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/', $name, $emailMatch);
        $param = $emailMatch ? 'email' : 'phone';
        return $param;
    }
}

// 乘以10的8次方
if (!function_exists('multiply_hundred_million')) {
    function multiply_hundred_million($value)
    {
        return $value * 1e8;
    }
}

// 除以10的8次方
if (!function_exists('division_hundred_million')) {
    function division_hundred_million($value)
    {
        return number_format($value / 1e8, 8,'.','');
    }
}

if (!function_exists('order_url_build')) {
    function order_url_build($outTradeNo)
    {
        return 'http://' . env('PAY_DOMAIN') . '/order?out_trade_no=' . $outTradeNo . '&t=' . microtime(true);
    }
}

// 人民币转化 乘以10的2次方
if (!function_exists('multiply_hundred')){
    function multiply_hundred($value){
        return $value * 100;
    }
}

// 人民币转化 除以10的2次方
if(!function_exists('division_hundred')){
    function division_hundred($value){
        return number_format($value / 100, 2,'.','');
    }
}

// 将秒数转换为时间（年、天、小时、分、秒）
if(!function_exists('sec2Time')){
    function sec2Time($time){
        if(is_numeric($time)){
            $value = array(
                "years" => 0, "days" => 0, "hours" => 0,
                "minutes" => 0, "seconds" => 0,
            );
            if($time >= 31556926){
                $value["years"] = floor($time/31556926);
                $time = ($time%31556926);
            }
            if($time >= 86400){
                $value["days"] = floor($time/86400);
                $time = ($time%86400);
            }
            if($time >= 3600){
                $value["hours"] = floor($time/3600);
                $time = ($time%3600);
            }
            if($time >= 60){
                $value["minutes"] = floor($time/60);
                $time = ($time%60);
            }
            $value["seconds"] = floor($time);
            if($value["years"] == 0){
                if($value["days"] == 0){
                    if($value["hours"] == 0){
                        $t = $value["minutes"] ."M"." ".$value["seconds"]."S";
                    }else{
                        $t = $value["hours"] ."H"." ". $value["minutes"] ."M"." ".$value["seconds"]."S";
                    }
                }else{
                    $t = $value["days"] ."D"." ". $value["hours"] ."H"." ". $value["minutes"] ."M"." ".$value["seconds"]."S";
                }
            }else{
                $t =$value["years"] ."Y". $value["days"] ."D"." ". $value["hours"] ."H". $value["minutes"] ."M".$value["seconds"]."S";

            }

            Return $t;

        }else{
            return (bool) FALSE;
        }
    }
}

// 百分比格式处理
if(!function_exists('numberRateFormat')){
    function numberRateFormat($number,$decimal){
        return floatval(number_format($number,$decimal,'.',''));
    }
}
