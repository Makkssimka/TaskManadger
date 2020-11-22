<?php
    namespace Core;

    class Route{
         public function set($routes){
             $urlArray = parse_url($_SERVER['REQUEST_URI']);
             $url = explode('/', $urlArray['path']);

             $request = new Request();


             $param = filter_var(isset($url[2])?$url[2]:'', FILTER_SANITIZE_NUMBER_INT);
             $url = implode('/', array_slice($url, 0, 2));

             $route =  explode('@', $routes[$url]);
             $controller = $route[0];
             $action = $route[1];

             $controllerName = "\Controller\\$controller";
             $cont = new $controllerName();
             $cont->$action($request, $param);
         }
    }