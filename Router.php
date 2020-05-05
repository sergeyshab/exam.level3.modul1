<?php

class Router
{

//     array $routes - массив соответствий адресов и путей подключаемых файлов
//     string $path404 - путь к файлу с ошибкой 404

    public static function execute($routes, $path404)

    {
        if(array_key_exists($_SERVER['REQUEST_URI'], $routes))
            include $routes[$_SERVER['REQUEST_URI']];
        else
            include $path404;
    }
}