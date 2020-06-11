<?php

namespace App\Models;

use App\Config;

class Product extends BaseModel
{
    public function __construct(Config $config)
    {
        parent::__construct($config);
        $this->tableName = 'products';

        $this->findMap = [
            'id'  => [
                self::PARAM_TYPE    => \PDO::PARAM_INT,
            ],
        ];
    }

    public function getUsers(int $productId)
    {
        $sql = 'SELECT users.id AS user_id, users.name AS user_name, p.id AS product_id, p.name AS product_name,
            r.id AS rating_id, r.value AS rating, c.id AS comment_id, c.value AS comment
            FROM users
            LEFT JOIN (SELECT * FROM ratings WHERE ratings.product_id = :product_id AND ratings.value IS NOT NULL AND ratings.value != 0) r ON users.id = r.user_id
            LEFT JOIN (SELECT * FROM comments WHERE comments.product_id = :product_id) c ON users.id = c.user_id
            JOIN products p ON r.product_id = p.id';

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':product_id', $productId, \PDO::PARAM_INT);

        $result = [];
        if ($statement->execute()) {
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $result;
    }
}
