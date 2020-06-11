<?php

namespace App\Forms;

interface FormInterface
{
    public function render(array $params = []): string;
}
