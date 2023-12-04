<?php

namespace App\Controllers;

use Leaf\Controller;

class CallFormController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get(): void
    {
        response()->json('');
    }
}
