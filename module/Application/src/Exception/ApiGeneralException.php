<?php

namespace Application\Exception;

use Exception;
use Throwable;
use ZF\ApiProblem\Exception\ProblemExceptionInterface;

class ApiGeneralException extends Exception implements ProblemExceptionInterface
{
    /**
     * @var string
     */
    protected $type = 'http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html';

    /**
     * @var array
     */
    protected $details = [];

    /**
     * @param string $title
     * @param int $code
     * @param Throwable $previous
     * @param array $details
     */
    public function __construct(string $detail = 'Ocorreu um erro no servidor', int $code = 500, Throwable $previous = null, array $details = [])
    {
        $this->details = $details;

        return parent::__construct($detail, $code, $previous);
    }

    /**
     * @inheritDoc
     */
    public function getAdditionalDetails()
    {
        return $this->details;
    }

    /**
     * @inheritDoc
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function getTitle() {}
}