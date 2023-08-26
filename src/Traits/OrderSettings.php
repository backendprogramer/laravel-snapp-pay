<?php

namespace BackendProgramer\SnappPay\Traits;

trait OrderSettings
{
    /**
     * Convert price from to.
     *
     * @param int    $price
     * @param string $from
     * @param string $to
     *
     * @return int
     */
    public function convertPrice(int $price, string $from, string $to): int
    {
        switch ($from) {
            case 'IRR':
                switch ($to) {
                    case 'IRR':
                        return $price;
                    case 'IRT':
                        return $price / 10;
                }
                break;
            case 'IRT':
                switch ($to) {
                    case 'IRR':
                        return $price * 10;
                    case 'IRT':
                        return $price;
                }
                break;
        }

        return $price;
    }

    /**
     * Convert mobile number.
     *
     * @param string $mobile
     *
     * @return string|null
     */
    public function snappPayMobile(string $mobile): ?string
    {
        $mobile = $this->replaceFaNumberWithEnNumber($mobile);
        if (preg_match("@^\+98@", $mobile)) {
            return $mobile;
        }
        if (preg_match("@^\+980@", $mobile) && strlen($mobile) == 14) {
            return '+98'.substr($mobile, 4);
        }
        if (str_starts_with($mobile, '09') && strlen($mobile) == 11) {
            return '+98'.substr($mobile, 1);
        }
        if (str_starts_with($mobile, '9') && strlen($mobile) == 10) {
            return '+98'.$mobile;
        }

        return null;
    }

    /**
     * Replace persian and arabic number with english number.
     *
     * @param string $number
     *
     * @return string
     */
    private function replaceFaNumberWithEnNumber(string $number): string
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $num = range(0, 9);
        $convertedPersianNum = str_replace($persian, $num, $number);

        return str_replace($arabic, $num, $convertedPersianNum);
    }
}
