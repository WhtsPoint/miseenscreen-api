<?php

namespace App\Controllers;

use App\Services\CallFormService;
use Leaf\Controller;

class CallFormController extends Controller
{

    public function __construct(
        protected CallFormService $service
    ) {
        parent::__construct();
    }

    public function create(): void
    {
        $data = $this->request->body();

        response()->json($data);
    }
}
