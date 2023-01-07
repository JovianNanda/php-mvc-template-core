<?php

namespace jnanda\jnandaphpmvc\exception;

class ViewException extends \Exception
{
    protected $message = 'View Not Found';
    protected $code = 400;
}