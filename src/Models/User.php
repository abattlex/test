<?php

namespace App\Models;

use App\Config;

class User extends BaseModel
{
    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->tableName = 'users';

        $this->saveMap = [
            'name'  => [
                self::PARAM_TYPE    => \PDO::PARAM_STR,
            ],
            'pass'  => [
                self::PARAM_TYPE    => \PDO::PARAM_STR,
                self::PARAM_HANDLER => fn (string $pass) => password_hash($pass, PASSWORD_DEFAULT),
            ],
        ];

        $this->findMap = [
            'name'  => [
                self::PARAM_TYPE    => \PDO::PARAM_STR,
            ],
        ];
    }

    public function findOne(array $params = [])
    {
        $user = parent::findOne($params);
        if ($user) {
            $hash = $user['pass'];
            if (password_verify($params['pass'], $hash)) {
                return $user;
            }
        }

        return null;
    }
}
