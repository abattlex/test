<?php

namespace App;

class Session
{
    const KEY_USER_NAME = 'user_name';
    const KEY_USER_ID   = 'user_id';

    public function __construct()
    {
        session_start();
    }

    public function set(string $key, string $value): Session
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function get(string $key): ?string
    {
        return $_SESSION[$key] ?? null;
    }
}
