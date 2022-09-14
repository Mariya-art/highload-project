<?php

namespace App\Components;

class ClothesMessage
{
    public function __construct(public string $type, public int $userId) 
    {

    }
}