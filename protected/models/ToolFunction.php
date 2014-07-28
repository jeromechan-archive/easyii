<?php
/**
 * Coypright (C) 2014 All rights reserved
 * Author: jeromechan
 * Date: 7/03/14
 * Time: 3:11 PM
 * Description: ToolFunction.php
 */
class ToolFunction
{
    public static function arrKeysToCamelCase($in)
    {
        if(empty($in)||!is_array($in))
            return $in;
        $reCopyRes = array();
        foreach($in as $key=>$val)
        {
            $reKey = self::ucFirstWord($key);
            if(!is_array($val)){
                $reCopyRes[$reKey] = $val;
            }else{
                $reCopyRes[$reKey] = self::arrKeysToCamelCase($val);
            }
        }
        return $reCopyRes;
    }

    public static function ucFirstWord($word)
    {
        if(!is_string($word)){
            return $word;
        }else{
            $wordArr = explode('_',$word);
            if(!empty($wordArr)){
                $index = 0;
                foreach($wordArr as &$wd)
                {
                    if($index==0){
                        $index++;
                        continue;
                    }
                    $wd = ucfirst($wd);
                }
                $outStr = implode('',$wordArr);
                return $outStr;
            }else{
                return $word;
            }
        }
    }

    public static function arrayObjectToArray($arrayObject,$criteriaSelect=null)
    {
        $resultArr = array();
        foreach($arrayObject as $obj)
        {
            $resultArr[] = $obj->getAttributes($criteriaSelect);
        }
        return $resultArr;
    }

    public static function arrKeysToUnderlineCase($in)
    {
        if(empty($in)||!is_array($in))
            return $in;
        $reCopyRes = array();
        foreach($in as $key=>$val)
        {
            $reKey = self::lcFirstWord($key);
            if(!is_array($val)){
                $reCopyRes[$reKey] = $val;
            }else{
                $reCopyRes[$reKey] = self::arrKeysToUnderlineCase($val);
            }
        }
        return $reCopyRes;
    }

    public static function lcFirstWord($word)
    {
        if(!is_string($word)){
            return $word;
        }else{
            preg_match_all('/([a-z0-9_]*)([A-Z][a-z0-9_]*)?/',$word,$matches,PREG_PATTERN_ORDER);
            if(!empty($matches)){
                $strPattern1 = !empty($matches[1][0])?trim($matches[1][0]):'';
                $subMatch = array_filter($matches[2]);
                $strPattern2 = !empty($subMatch)?trim(implode('_',$subMatch)):'';
                $strPattern2 = !empty($strPattern2) && !empty($strPattern1)?'_'.$strPattern2:$strPattern2;
                $outStr = strtolower($strPattern1.$strPattern2);
            }else{
                $outStr = $word;
            }
            return $outStr;
        }
    }

    public static function urlEncodeAndDecode($in,$flag='')
    {
        if(!empty($in) && is_array($in)){
            foreach($in as $key => &$val)
            {
                if(is_array($val)){
                    $val = self::urlEncodeAndDecode($val,$flag);
                }else{
                    if($flag == 'encode'){
                        $val = urlencode($val);
                    }elseif($flag == 'decode'){
                        $val = urldecode($val);
                    }
                }
            }
        }elseif(!is_array($in)){
            if($flag == 'encode'){
                $in = urlencode($in);
            }elseif($flag == 'decode'){
                $in = urldecode($in);
            }
        }
        return $in;
    }

}
