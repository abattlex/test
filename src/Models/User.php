<?php

namespace App\Models;

use App\Config;
use App\Session;
use App\SimpleContainer;

class User extends BaseModel
{
    protected SimpleContainer $container;

    public function __construct(Config $config, Session $session, SimpleContainer $container)
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

        $this->container = $container;

        $this->set('id', $session->get(Session::KEY_USER_ID));
        $this->set('name', $session->get(Session::KEY_USER_NAME));
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

    public function getProducts(int $userId)
    {
        $sql = 'SELECT products.id AS product_id, products.name AS product_name,
                r.id AS rating_id, r.value AS rating, c.id AS comment_id, c.value AS comment
                FROM products
                LEFT JOIN (SELECT * FROM ratings WHERE ratings.user_id = :user_id) r ON products.id = r.product_id
                LEFT JOIN (SELECT * FROM comments WHERE comments.user_id = :user_id) c ON products.id = c.product_id';

        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':user_id', $userId, \PDO::PARAM_INT);

        $result = [];
        if ($statement->execute()) {
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $result;
    }

    public function saveProducts(array $params)
    {
        foreach ($params['ratings'] as $productId => $ratingValue) {
            $rating = $this->container->get(Rating::class);
            $ratingData = $rating->findOne([
                'product_id'    => $productId,
                'user_id'       => $this->get('id'),
            ]);

            $ratingData['value'] = $ratingValue;
            $rating->save($ratingData);
        }

        foreach ($params['comments'] as $productId => $commentValue) {
            $comment = $this->container->get(Comment::class);
            $commentData = $comment->findOne([
                'product_id'    => $productId,
                'user_id'       => $this->get('id'),
            ]);

            $commentData['value'] = $commentValue;
            $comment->save($commentData);
        }
    }
}
