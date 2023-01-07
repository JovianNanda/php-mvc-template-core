<?php

namespace jnanda\jnandaphpmvc\exception;

class TokenException extends \Exception
{
    protected $message = "There's an error with session Token!";
    protected $code = 400;
}