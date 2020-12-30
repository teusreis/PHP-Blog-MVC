<?php

function isLogin(): bool
{
    if(isset($_SESSION['user'])){
        return true;
    } else {
        return false;
    }
}

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
