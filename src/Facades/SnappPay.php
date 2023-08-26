<?php

namespace BackendProgramer\SnappPay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BackendProgramer\SnappPay\SnappPay
 */
class SnappPay extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \BackendProgramer\SnappPay\SnappPay::class;
    }
}
