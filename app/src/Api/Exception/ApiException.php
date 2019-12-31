<?php

namespace RecruitingApp\Api\Exception;

use Throwable;

class ApiException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = json_encode(['message' => $message]);

        parent::__construct($message, $code, $previous);
    }
}