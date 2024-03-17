<?php

namespace App\Utils\Validation\Resolver;

use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsTargetedValueResolver;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

#[AsTargetedValueResolver('map_request_query')]
class RequestQueryStringResolver implements ValueResolverInterface
{
    public function __construct(
        private RequestDataResolver $resolver
    ) {}

    /**
     * @throws ValidationException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        return $this->resolver->resolve($request->query->all(), $argument);
    }
}