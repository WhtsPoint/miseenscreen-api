<?php

namespace App\Services;
use App\Repositories\CallFormRepository;

class CallFormService
{
    public function __construct(
        protected CallFormRepository $repository,
    ) {}

    public function create()
    {

    }
}
