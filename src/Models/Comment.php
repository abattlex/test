<?php

namespace App\Models;

use App\Config;

class Comment extends BaseModel
{
    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->tableName = 'comments';

        $this->saveMap = [
            'user_id'       => [
                self::PARAM_TYPE    => \PDO::PARAM_INT,
            ],
            'product_id'    => [
                self::PARAM_TYPE    => \PDO::PARAM_INT,
            ],
            'value'         => [
                self::PARAM_TYPE    => \PDO::PARAM_STR,
            ],
        ];

        $this->findMap = [
            'user_id'       => [
                self::PARAM_TYPE    => \PDO::PARAM_INT,
            ],
            'product_id'    => [
                self::PARAM_TYPE    => \PDO::PARAM_INT,
            ],
        ];
    }
}
