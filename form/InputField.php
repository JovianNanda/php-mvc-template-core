<?php

namespace jnanda\jnandaphpmvc\form;

use jnanda\jnandaphpmvc\Model;

class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    public const TYPE_HIDDEN = 'hidden';
    public const TYPE_DATE = 'date';

    public string $type;

    /**
     * @param Model $model
     * @param string $attribute
     */

    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function numberField()
    {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }

    public function hiddenField()
    {
        $this->type = self::TYPE_HIDDEN;
        return $this;
    }

    public function dateField()
    {
        $this->type = self::TYPE_DATE;
        return $this;
    }

    public function renderInput(): string
    {
        return sprintf('<input type="%s" name="%s" value="%s" class="form-control%s">',
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
        );
    }
}