<?php

namespace BackendProgramer\SnappPay;

use BackendProgramer\SnappPay\Abstracts\SnappPay as AbstractsSnappPay;
use BackendProgramer\SnappPay\enums\Currency;
use BackendProgramer\SnappPay\enums\EPType;
use BackendProgramer\SnappPay\Order\Order;
use JetBrains\PhpStorm\ArrayShape;

class SnappPay extends AbstractsSnappPay
{
    use Traits\OrderSettings;

    /**
     * Gets SnappPay API request basic token.
     *
     * @return string[]
     */
    #[ArrayShape(['Authorization' => 'string', 'Content-Type' => 'string'])]
    public function getRequestBasicToken(): array
    {
        $token = 'Authorization: Basic ' . base64_encode($this->setting->getClientId() . ':' . str_replace('amp;', '', $this->setting->getClientSecret()));

        return [
            'Authorization' => $token,
            'Content-Type' => 'Content-Type: application/x-www-form-urlencoded',
        ];
    }

    /**
     * Gets SnappPay API request bearer token.
     *
     * @return string[]
     */
    public function getRequestBearerToken(): array
    {
        $bearer_token = $this->getExpiredValue('snapppay_bearer_token');
        if (!$bearer_token) {
            $response = $this->request(
                $this->endPoint->getBearerToken(EPType::URL),
                $this->endPoint->getBearerToken(EPType::METHOD),
                'Basic',
                [
                    'grant_type' => 'password',
                    'scope' => 'online-merchant',
                    'username' => $this->setting->getUsername(),
                    'password' => str_replace('amp;', '', $this->setting->getPassword()),
                ]
            );
            if (isset($response['status']) && $response['status'] == 'error') {
                return ['status' => 'error', 'code' => 401, 'message' => 'خطای دریافت توکن'];
            }
            $bearer_token = $response['access_token'];
            $ttl = $response['expires_in'] + time();
            $this->setExpiredValue('snapppay_bearer_token', $bearer_token, $ttl);
        }

        return [
            'Authorization' => 'Authorization: Bearer ' . $bearer_token,
            'Content-Type' => 'Content-Type: application/json',
        ];
    }

    /**
     * Check Merchant Eligibility.
     *
     * @param int    $amount
     * @param string $currency
     *
     * @return array
     */
    public function isMerchantEligible(int $amount, string $currency): array
    {
        if (empty($this->setting->getUsername()) || empty($this->setting->getPassword()) || empty($this->setting->getClientId()) || empty($this->setting->getClientSecret()) || empty($this->setting->getBaseUrl())) {
            return ['status' => 'error', 'code' => 401, 'message' => 'خطای تنظیمات پلاگین درگاه پرداخت اسنپ! پی'];
        }
        $amount = $this->convertPrice($amount, $currency, Currency::RIAL);

        return $this->request(
            $this->endPoint->getMerchantEligible(EPType::URL),
            $this->endPoint->getMerchantEligible(EPType::METHOD),
            'Bearer',
            ['amount' => $amount]
        );
    }

    /**
     * Get Payment token.
     *
     * @param Order  $order
     * @param string $callBackUrl
     * @param string $transactionId
     *
     * @return array
     */
    public function getPaymentToken(Order $order, string $callBackUrl, string $transactionId): array
    {
        $amount = $this->convertPrice(
            $order->getPrice(),
            $order->getOrderCurrency(),
            Currency::RIAL
        );

        $data = [
            'amount' => $amount,
            'paymentMethodTypeDto' => 'INSTALLMENT',
            'returnURL' => $callBackUrl,
            'transactionId' => "$transactionId",
            'externalSourceAmount' => 0,
        ];

        $mobile = $this->snappPayMobile($order->getUserMobile());

        if ($mobile) {
            $data['mobile'] = $mobile;
        }

        $data['cartList'][] = $order->buildCartList();
        $discountAmount = $order->getTotalPrice() - $order->getPrice();
        $data['discountAmount'] = $discountAmount > 0 ? $this->convertPrice(
            $discountAmount,
            $order->getOrderCurrency(),
            Currency::RIAL
        ) : 0;

        return $this->request(
            $this->endPoint->getPaymentToken(EPType::URL),
            $this->endPoint->getPaymentToken(EPType::METHOD),
            'Bearer',
            $data
        );
    }

    /**
     * Verify order.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    public function verifyOrder(string $paymentToken): array
    {
        return $this->request(
            $this->endPoint->getVerifyOrder(EPType::URL),
            $this->endPoint->getVerifyOrder(EPType::METHOD),
            'Bearer',
            ['paymentToken' => $paymentToken]
        );
    }

    /**
     * Settle order.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    public function settleOrder(string $paymentToken): array
    {
        return $this->request(
            $this->endPoint->getSettleOrder(EPType::URL),
            $this->endPoint->getSettleOrder(EPType::METHOD),
            'Bearer',
            ['paymentToken' => $paymentToken]
        );
    }

    /**
     * Revert order.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    public function revertOrder(string $paymentToken): array
    {
        return $this->request(
            $this->endPoint->getRevertOrder(EPType::URL),
            $this->endPoint->getRevertOrder(EPType::METHOD),
            'Bearer',
            ['paymentToken' => $paymentToken]
        );
    }

    /**
     * Get Payment Status.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    public function getPaymentStatusOrder(string $paymentToken): array
    {
        return $this->request(
            $this->endPoint->getStatusOrder(EPType::URL),
            $this->endPoint->getStatusOrder(EPType::METHOD),
            'Bearer',
            ['paymentToken' => $paymentToken]
        );
    }

    /**
     * Cancel order.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    public function cancelOrder(string $paymentToken): array
    {
        return $this->request(
            $this->endPoint->getCancelOrder(EPType::URL),
            $this->endPoint->getCancelOrder(EPType::METHOD),
            'Bearer',
            ['paymentToken' => $paymentToken]
        );
    }

    /**
     * Update order.
     *
     * @param Order $order
     *
     * @return array
     */
    public function updateOrder(Order $order): array
    {
        $amount = $this->convertPrice(
            $order->getPrice(),
            $order->getOrderCurrency(),
            Currency::RIAL
        );
        $data = [
            'amount' => $amount,
            'paymentMethodTypeDto' => 'INSTALLMENT',
            'paymentToken' => $order->getPaymentToken(),
        ];

        $data['cartList'][] = $order->buildCartList();
        $discountAmount = $order->getTotalPrice() - $order->getPrice();
        $data['discountAmount'] = $discountAmount > 0 ? $this->convertPrice(
            $discountAmount,
            $order->getOrderCurrency(),
            Currency::RIAL
        ) : 0;

        return $this->request(
            $this->endPoint->getUpdateOrder(EPType::URL),
            $this->endPoint->getUpdateOrder(EPType::METHOD),
            'Bearer',
            $data
        );
    }
}
