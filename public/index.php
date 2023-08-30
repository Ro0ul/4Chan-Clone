<?php 

session_start();

define("ROOT",$_SERVER["DOCUMENT_ROOT"] . "/..");

function redirect(string $url) : void 
{
    header("Location : $url");
}

require_once ROOT . "/bootstrap/bootstrap.php";