<?php

    $routes = array(
        "/"         => 'IndexController@index',
        "/login"    => 'LoginController@index',
        "/logout"   => 'LoginController@logout',
        "/add-task" => 'IndexController@add',
        "/edit" => 'IndexController@edit'
    );