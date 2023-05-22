<?php

function debug($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escape / sanitize the HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function isLast(string $current, string $next) : bool {
    if($current !== $next) {
        return true;
    }
    return false;
}

// Function that checks if the user is authenticated
function isAuth() : void { 
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

// Function that checks if the user is an admin
function isAdmin() : void { 
    if(!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}