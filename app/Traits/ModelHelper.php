<?php

namespace App\Traits;

trait ModelHelper
{
    public function getId($encrypt = false)
    {
        return $this->id;
    }
}