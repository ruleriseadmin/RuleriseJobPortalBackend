<?php

namespace App\Supports;

class HelperSupport
{
    public static function snake_to_camel($input, $capitalizeFirstCharacter = false)
    {
        if(! is_array($input)){
            $str = str_replace('_', '', ucwords($input, '-'));

            return $capitalizeFirstCharacter ? lcfirst($str) : $str;
        }
        $newInput = array();

        foreach ($input as $key => $inputs){
            $str = str_replace('_', '', ucwords($key, '_'));
            $str = ! $capitalizeFirstCharacter ? lcfirst($str) : $str;
            $newInput[$str] = $inputs;
        }

        return $newInput;
    }

    public static function camel_to_snake($input)
    {
        if(! is_array($input)){
            preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
            $ret = $matches[0];
            foreach ($ret as &$match) {
                $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
            }
            return implode('_', $ret);
        }
        $newInput = array();
        foreach ($input as $key => $inputs){
            preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $key, $matches);
            $ret = $matches[0];
            foreach ($ret as &$match) {
                $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
            }
            $index = implode('_', $ret);
            $newInput[$index] = $inputs;
        }

        return $newInput;
    }
}
