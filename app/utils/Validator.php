<?php

namespace App\Utils;

use App\Exceptions\HttpException;
use Leaf\Form;

class Validator
{
    /**
     * @throws HttpException
     */
    public function validate(array $rules, array $data): void
    {
        $form = new Form();

        $isValid = $form::validate($data, $rules);

        if ($isValid === false) {
            response()->withHeader('Content-Type', 'application/json');
            response()->exit(json_encode([
                'errors' => $form::errors()
            ]), 400);
        }
    }
}
