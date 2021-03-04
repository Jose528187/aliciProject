<?php

namespace App\Exception;

class RegisterNotFoundException extends \Exception  
{

    private const CODE = 400;

    public function __construct($id) {
        parent::__construct("Register not found : {$id}", self::CODE);
    }
}
