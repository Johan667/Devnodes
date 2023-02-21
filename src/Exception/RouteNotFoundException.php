<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RouteNotFoundException extends NotFoundHttpException
{
public function __construct(string $message = null, \Throwable $previous = null, array $headers = [], ?int $code = 0)
{
parent::__construct($message, $previous, $code, $headers);
}
}