<?php

namespace App\Models;

use App\Config;

class User extends BaseModel
{
    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->tableName = 'users';

        $this->fieldsMap = [
            'name'  => [
                self::PARAM_TYPE    => \PDO::PARAM_STR,
            ],
            'pass'  => [
                self::PARAM_TYPE    => \PDO::PARAM_STR,
                self::PARAM_HANDLER => fn (string $pass) => password_hash($pass, PASSWORD_DEFAULT),
            ],
        ];
    }
}
