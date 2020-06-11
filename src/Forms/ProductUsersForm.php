<?php

namespace App\Forms;

use App\Models\Product;

class ProductUsersForm implements FormInterface
{
    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function render(array $params = []): string
    {
        $productId = (int) $params['product_id'];
        $productName = null;
        $totalRating = 0;
        $html = '<h1>%s</h1><table>';

        $users = $this->product->getUsers($productId);

        foreach ($users as $user) {
            if (!$productName) {
                $productName = $user['product_name'];
            }
            $totalRating += $user['rating'];

            $html .= sprintf('<tr><td>%s</td><td>%d</td><td>%s</td>', $user['user_name'], $user['rating'], $user['comment']);
        }
        $html .= '</table><h3>Total Rating: %d</h3><h3>Average Rating: %f</h3>';

        return sprintf($html, $productName, $totalRating, $totalRating / count($users));
    }
}
