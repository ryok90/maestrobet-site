<?php
namespace ApiResource\V1\Rest\Lancamento;

class LancamentoResourceFactory
{
    public function __invoke($services)
    {
        return new LancamentoResource();
    }
}
