<?php

namespace App\Utils;

use InvalidArgumentException;
use Leaf\Form;

class FormFactory
{
    public function create(): Form
    {
        $form = new Form();

        $form::rule('services', function ($value, $params, $field) use ($form) {
            try {
                if ($value === null) return true;
                if (gettype($value) !== 'array') return false;

                new Services($value);

                return true;

            } catch (InvalidArgumentException) {
                return false;
            }
        }, 'Services is invalid');

        return $form;
    }
}
