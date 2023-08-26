<?php

namespace BackendProgramer\SnappPay\Contracts;

interface CartListInterface
{
    /**
     * Get SnappPay cart list array.
     *
     * @return array
     */
    public function toArray(): array;
}
