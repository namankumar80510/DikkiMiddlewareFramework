<?php

use Core\Libraries\SessionManager;
use Dikki\Config\ConfigFetcher;

/**
 * procedural functions/helpers
 */

function config(string $key, mixed $default = null): mixed
{
    return (new ConfigFetcher(CONFIG_PATH))->get($key, $default);
}

function esc(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function dd(...$args)
{
    dump(...$args);
    die;
}

function base_url(string $path = ''): string
{
    $siteUrl = getenv('APP_URL') ?? config('app.url');
    return rtrim($siteUrl, '/') . '/' . ltrim($path, '/');
}

function session(): SessionManager
{
    static $session = null;
    if ($session === null) {
        $session = new SessionManager();
    }
    return $session;
}

function isLoggedIn(): bool
{
    return session()->has('isLoggedIn');
}

function user(string $key = null)
{
    $user = session()->get('user');
    if ($key) {
        return $user[$key] ?? null;
    }
    return $user;
}
