<?php

use BackendProgramer\SnappPay\enums\Currency;
use BackendProgramer\SnappPay\Traits\OrderSettings;

uses(OrderSettings::class);

it('convert price test', function () {
    $this->assertEquals(10000, $this->convertPrice(1000, Currency::TOMAN, Currency::RIAL));
    $this->assertEquals(10000, $this->convertPrice(100000, Currency::RIAL, Currency::TOMAN));
});

it('snapp pay mobile test', function () {
    $this->assertNull($this->snappPayMobile('1234567'));
    $this->assertEquals('+989381234567', $this->snappPayMobile('09381234567'));
    $this->assertEquals('+989381234567', $this->snappPayMobile('9381234567'));
    $this->assertEquals('+989381234567', $this->snappPayMobile('+989381234567'));

    $this->assertEquals('+989381234567', $this->snappPayMobile('۰۹۳۸۱۲۳۴۵۶۷')); //persian number
    $this->assertEquals('+989381234567', $this->snappPayMobile('٠٩٣٨١٢٣٤٥٦٧')); //arabic number
});
