<?php
namespace ApiResource\V1\Rest\Debito;

class DebitoResourceFactory
{
    public function __invoke($services)
    {
        return new DebitoResource();
    }
}
