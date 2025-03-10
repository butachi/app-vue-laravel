<?php

namespace App\Exceptions\Listing;

use Exception;

class CannotPublishListingException extends Exception
{
    public static function because(string $message): self
    {
        return new self($message);
    }
}
