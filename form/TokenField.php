<?php

namespace jnanda\jnandaphpmvc\form;

use jnanda\jnandaphpmvc\Model;

class TokenField
{
    public Model $model;
    public string $attribute;
    public string $value;

    /**
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    public function __toString()
    {
        return sprintf('<input type="hidden" name="%s" value="%s">',
            $this->attribute,
            $this->model->{$this->attribute},
        );
    }
}