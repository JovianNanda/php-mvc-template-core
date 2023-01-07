<?php

namespace jnanda\jnandaphpmvc\form;

use jnanda\jnandaphpmvc\Model;

class Form
{
    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }

    public function csrf(Model $model, $attribute) {
        return new TokenField($model, $attribute);
    }

}