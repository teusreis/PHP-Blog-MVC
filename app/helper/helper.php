<?php

// Debuging functions
function d($data): void
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

function dd($data): void
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}

// Auth functions
function isLogin(): bool
{
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}

function canModify(int $id): bool
{
    if (isLogin() && $id == getUserId()) {
        return true;
    } else {
        return false;
    }
}

function getUserId(): int
{
    return $_SESSION['user']['id'];
}

// URL and Assets functions
function url(string $complement = null): string
{
    if ($complement) {
        return $_ENV['DOMAIN'] . $complement;
    }

    return $_ENV['DOMAIN'];
}

function loadCss($fileName): string
{
    return $_ENV['DOMAIN'] . "css/$fileName";
}

function loadJs($fileName): string
{
    return $_ENV['DOMAIN'] . "js/$fileName";
}

function loadImg($img)
{
    return $_ENV['DOMAIN'] . "$img";
}
