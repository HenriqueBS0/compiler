<?php

define('VIEW_DIR',   realpath(__DIR__ . '/Views/'));

function view(string $path, $data = []) {
    extract($data);
    require_once(VIEW_DIR . '/' . $path);
}