<?php

namespace App\Exceptions;

use App\Http\Constants\ResponseCodeConstant;
use Exception;

class ObjectNotExistException extends Exception
{
    protected $code = ResponseCodeConstant::CONSTANT_RESPONSE_CODE_OBJECT_NOT_EXIST;
    protected $message = 'object not exist';
}