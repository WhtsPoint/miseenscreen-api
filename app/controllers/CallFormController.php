<?php

namespace App\Controllers;

use Leaf\Controller;
use objects\Email;

class CallFormController extends Controller
{
    public function get(): void
    {
        response()->json(['email' => new Email('ubluewolfu@gmail.com')]);
    }
}
