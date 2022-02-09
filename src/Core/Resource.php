<?php

namespace KevinEduardo\PagHiper\Core;

use KevinEduardo\PagHiper\PagHiper;

class Resource
{

    /**
     * @var \KevinEduardo\PagHiper\PagHiper;
     */
    protected $paghiper;

    public function __construct(PagHiper $paghiper)
    {
        $this->paghiper = $paghiper;
    }
}
