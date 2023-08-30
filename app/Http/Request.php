<?php declare(strict_types=1);

namespace App\Http;

class Request 
{
    public static function getMethod() : string 
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }
    public static function getBody() : array 
    {
        if(self::getMethod() == "get"){
            return $_GET;
        }else if(self::getMethod() == "post"){
            return $_POST;
        }else{
            return $_REQUEST;
        }
    }
    public static function getUri() : string 
    {
        return filter_var($_SERVER["REQUEST_URI"],FILTER_SANITIZE_URL);
    }
    public static function getFiles() : array 
    {
        return $_FILES;
    }
}