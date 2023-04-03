<?php

namespace App\Service;

class HelperService
{
    

    public function __construct()
    {
        
    }

    public function generateToken()
    {
        return bin2hex(random_bytes(20));
    }

}
