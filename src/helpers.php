<?php

define('PUBLIC_DIR', realpath(__DIR__ . '/../public/'));
define('VIEW_DIR',   realpath(__DIR__ . '/Views/'));

function require_public(string $path) : string
{
    return PUBLIC_DIR . '/' .  $path;
}

function view(string $path, $data = []) {
    extract($data);
    require_once(VIEW_DIR . '/' . $path);
}