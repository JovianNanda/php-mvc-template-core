<?php

namespace jnanda\jnandaphpmvc\exception;

class NotFoundException extends \Exception
{
    protected $message = 'Page not found';
    protected $code = 404;
}