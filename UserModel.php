<?php

namespace jnanda\jnandaphpmvc;

use jnanda\jnandaphpmvc\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;



}