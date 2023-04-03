<?php
namespace App\QrCode;

use BaconQrCode\Common\Mode as BaseMode;

class PublicMode
{
    private BaseMode $mode;

    public function __construct(int $encodingMode)
    {
        $this->mode = new BaseMode($encodingMode);
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->mode, $name], $arguments);
    }
}