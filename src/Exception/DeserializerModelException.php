<?php

namespace App\Exception;

use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

class DeserializerModelException extends \Exception  
{

    private const CODE = 496;

    public function __construct(NotNormalizableValueException $e) {
        parent::__construct($e->getMessage(), self::CODE);
    }
}
