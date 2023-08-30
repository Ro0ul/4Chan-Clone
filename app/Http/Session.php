<?php declare(strict_types=1);

namespace App\Http;

class Session 
{
    public static function getSessionVariable(string $variableName) : mixed 
    {
        return $_SESSION[$variableName];
    }
    public static function getAllSessionVariables() : array 
    {
        return $_SESSION;
    }
    public static function setSessionVariable(string $variableName, mixed $value) : bool 
    {
        if($_SESSION[$variableName] = $value){
            return true;
        }else{
            return false;
        }
    }
    public static function removeVariable(string $variableName) : void 
    {
        unset($_SESSION[$variableName]);
    }
}