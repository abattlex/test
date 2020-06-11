<?php

namespace App\Forms;

use App\Models\User;

class UserProductsForm implements FormInterface
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function render(array $params = []): string
    {
        $userId = $this->user->get('id');
        $products = $this->user->getProducts($userId);
        $formHtml = '<form method="post"><table>';
        foreach ($products as $product) {
            $formHtml .= sprintf('<tr>
                <td><a href="/product/%d/users">%s</a></td>
                <td><select name="ratings[%d]">%s</select></td>
                <td><input type="text" name="comments[%d]" value="%s"></td>
                </tr>',
                $product['product_id'], $product['product_name'],
                $product['product_id'], $this->getRatingOptions($product['rating']),
                $product['product_id'], $product['comment']
            );
        }
        $formHtml .= '<tr><td></td><td></td><td><input type="submit" value="Save"></td></tr></table></form>';

        return $formHtml;
    }

    protected function getRatingOptions($rating) {
        $html = '<option value="0">NOT SET</option>';
        foreach (range(1, 5) as $value) {
            $html .= sprintf('<option value="%s" %s>%s</option>', $value, $rating == $value ? 'selected': '', $value);
        }

        return $html;
    }
}
