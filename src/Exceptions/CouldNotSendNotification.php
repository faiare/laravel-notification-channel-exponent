<?php

namespace NotificationChannels\Exponent\Exceptions;

use GuzzleHttp\Exception\RequestException;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError(RequestException $exception)
    {
        return new static($exception->getMessage());
    }
}
