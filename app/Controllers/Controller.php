<?php declare(strict_types=1);

namespace App\Controllers;
use App\Twig\Twig;
use App\Http\Session;

class Controller
{
    public static function render() : void 
    {
        $twig = new Twig;
        $twig->view("home/index");
    }
}