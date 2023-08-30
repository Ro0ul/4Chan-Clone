<?php 

use App\Controllers\Boards;
use App\Controllers\Controller;

$router = new \Bramus\Router\Router();

$router->get("/",[Controller::class, "render"]);

$router->mount("/boards/{boardName}",function() use($router){

    $router->get("/thread",function(){
        echo "nice";
    });

    $router->post("/new",[Boards::class, "new"]);

    $router->get("/",[Boards::class, "render"]);

});

$router->set404(function(){
    echo "404";
});

$router->run();