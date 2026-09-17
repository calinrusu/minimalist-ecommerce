<?php

function csrf_token()
{
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['_csrf_token'];
}

function csrf_verify($token)
{
    if (empty($_SESSION['_csrf_token']) || !is_string($token)) {
        return false;
    }

    return hash_equals($_SESSION['_csrf_token'], $token);
}
