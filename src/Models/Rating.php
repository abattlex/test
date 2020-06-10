<?php

namespace App\Models;

use App\Config;

class Rating extends BaseModel
{
    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->tableName = 'ratings';

        $this->saveMap = [
            'user_id'       => [
                self::PARAM_TYPE    => \PDO::PARAM_INT,
            ],
            'product_id'    => [
                self::PARAM_TYPE    => \PDO::PARAM_INT,
            ],
            'value'         => [
                self::PARAM_TYPE    => \PDO::PARAM_INT,
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
