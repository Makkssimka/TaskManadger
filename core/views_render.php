<?php

    function view($templateName, $data){

        $loader = new \Twig\Loader\FilesystemLoader("views");
        $twig = new \Twig\Environment($loader, [
            'cache' => 'cache'
        ]);

        echo $twig->render("$templateName.html", $data);

    }