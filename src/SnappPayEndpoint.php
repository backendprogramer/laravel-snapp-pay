<?php

namespace BackendProgramer\SnappPay;

use BackendProgramer\SnappPay\Traits\EndpointSettings;

class SnappPayEndpoint
{
    use EndpointSettings;

    /**
     * BearerToken endpoint.
     *
     * @var string[] bearerToken
     */
    protected array $bearerToken;

    /**
     * MerchantEligible endpoint.
     *
     * @var string[] merchantEligible
     */
    protected array $merchantEligible;

    /**
     * PaymentToken endpoint.
     *
     * @var string[] paymentToken
     */
    protected array $paymentToken;

    /**
     * VerifyOrder endpoint.
     *
     * @var string[] verifyOrder
     */
    protected array $verifyOrder;

    /**
     * SettleOrder endpoint.
     *
     * @var string[] settleOrder
     */
    protected array $settleOrder;

    /**
     * RevertOrder endpoint.
     *
     * @var string[] revertOrder
     */
    protected array $revertOrder;

    /**
     * CancelOrder endpoint.
     *
     * @var string[] cancelOrder
     */
    protected array $cancelOrder;

    /**
     * UpdateOrder endpoint.
     *
     * @var string[] updateOrder
     */
    protected array $updateOrder;

    /**
     * StatusOrder endpoint.
     *
     * @var string[] statusOrder
     */
    protected array $statusOrder;

    /**
     * Endpoints constructor.
     *
     *  @param bool setFromConfig
     */
    public function __construct($setFromConfig = false)
    {
        if ($setFromConfig) {
            $this->bearerToken = config('snapp-pay.endpoints.bearer_token');
            $this->merchantEligible = config('snapp-pay.endpoints.merchant_eligible');
            $this->paymentToken = config('snapp-pay.endpoints.payment_token');
            $this->verifyOrder = config('snapp-pay.endpoints.payment_verify');
            $this->settleOrder = config('snapp-pay.endpoints.payment_settle');
            $this->revertOrder = config('snapp-pay.endpoints.payment_revert');
            $this->cancelOrder = config('snapp-pay.endpoints.payment_cancel');
            $this->updateOrder = config('snapp-pay.endpoints.payment_update');
            $this->statusOrder = config('snapp-pay.endpoints.payment_status');
        } else {
            $this->bearerToken = ['url' => 'api/online/v1/oauth/token', 'method' => 'POST'];
            $this->merchantEligible = ['url' => 'api/online/offer/v1/eligible', 'method' => 'GET'];
            $this->paymentToken = ['url' => 'api/online/payment/v1/token', 'method' => 'POST'];
            $this->verifyOrder = ['url' => 'api/online/payment/v1/verify', 'method' => 'POST'];
            $this->settleOrder = ['url' => 'api/online/payment/v1/settle', 'method' => 'POST'];
            $this->revertOrder = ['url' => 'api/online/payment/v1/revert', 'method' => 'POST'];
            $this->cancelOrder = ['url' => 'api/online/payment/v1/cancel', 'method' => 'POST'];
            $this->updateOrder = ['url' => 'api/online/payment/v1/update', 'method' => 'POST'];
            $this->statusOrder = ['url' => 'api/online/payment/v1/status', 'method' => 'GET'];
        }
    }

    /**
     * Set bearerToken.
     *
     * @param string $url
     * @param string $method
     *
     * @return void
     */
    public function setBearerToken(string $url, string $method): void
    {
        $this->bearerToken = ['url' => $url, 'method' => $method];
    }

    /**
     * Get merchantEligible.
     *
     * @param string $type
     *
     * @return string
     */
    public function getBearerToken(string $type): string
    {
        if ($type == 'method') {
            return $this->urlSlashCheck($this->bearerToken[$type]);
        }

        return $this->bearerToken[$type];
    }

    /**
     * Set merchantEligible.
     *
     * @param string $url
     * @param string $method
     *
     * @return void
     */
    public function setMerchantEligible(string $url, string $method): void
    {
        $this->merchantEligible = ['url' => $url, 'method' => $method];
    }

    /**
     * Get merchantEligible.
     *
     * @param string $type
     *
     * @return string
     */
    public function getMerchantEligible(string $type): string
    {
        if ($type == 'method') {
            return $this->urlSlashCheck($this->merchantEligible[$type]);
        }

        return $this->merchantEligible[$type];
    }

    /**
     * Set paymentToken.
     *
     * @param string $url
     * @param string $method
     *
     * @return void
     */
    public function setPaymentToken(string $url, string $method): void
    {
        $this->paymentToken = ['url' => $url, 'method' => $method];
    }

    /**
     * Get paymentToken.
     *
     * @param string $type
     *
     * @return string
     */
    public function getPaymentToken(string $type): string
    {
        if ($type == 'method') {
            return $this->urlSlashCheck($this->paymentToken[$type]);
        }

        return $this->paymentToken[$type];
    }

    /**
     * Set verifyOrder.
     *
     * @param string $url
     * @param string $method
     *
     * @return void
     */
    public function setVerifyOrder(string $url, string $method): void
    {
        $this->verifyOrder = ['url' => $url, 'method' => $method];
    }

    /**
     * Get verifyOrder.
     *
     * @param string $type
     *
     * @return string
     */
    public function getVerifyOrder(string $type): string
    {
        if ($type == 'method') {
            return $this->urlSlashCheck($this->verifyOrder[$type]);
        }

        return $this->verifyOrder[$type];
    }

    /**
     * Set settleOrder.
     *
     * @param string $url
     * @param string $method
     *
     * @return void
     */
    public function setSettleOrder(string $url, string $method): void
    {
        $this->settleOrder = ['url' => $url, 'method' => $method];
    }

    /**
     * Get settleOrder.
     *
     * @param string $type
     *
     * @return string
     */
    public function getSettleOrder(string $type): string
    {
        if ($type == 'method') {
            return $this->urlSlashCheck($this->settleOrder[$type]);
        }

        return $this->settleOrder[$type];
    }

    /**
     * Set revertOrder.
     *
     * @param string $url
     * @param string $method
     *
     * @return void
     */
    public function setRevertOrder(string $url, string $method): void
    {
        $this->revertOrder = ['url' => $url, 'method' => $method];
    }

    /**
     * Get revertOrder.
     *
     * @param string $type
     *
     * @return string
     */
    public function getRevertOrder(string $type): string
    {
        if ($type == 'method') {
            return $this->urlSlashCheck($this->revertOrder[$type]);
        }

        return $this->revertOrder[$type];
    }

    /**
     * Set cancelOrder.
     *
     * @param string $url
     * @param string $method
     *
     * @return void
     */
    public function setCancelOrder(string $url, string $method): void
    {
        $this->cancelOrder = ['url' => $url, 'method' => $method];
    }

    /**
     * Get cancelOrder.
     *
     * @param string $type
     *
     * @return string
     */
    public function getCancelOrder(string $type): string
    {
        if ($type == 'method') {
            return $this->urlSlashCheck($this->cancelOrder[$type]);
        }

        return $this->cancelOrder[$type];
    }

    /**
     * Set updateOrder.
     *
     * @param string $url
     * @param string $method
     *
     * @return void
     */
    public function setUpdateOrder(string $url, string $method): void
    {
        $this->updateOrder = ['url' => $url, 'method' => $method];
    }

    /**
     * Get updateOrder.
     *
     * @param string $type
     *
     * @return string
     */
    public function getUpdateOrder(string $type): string
    {
        if ($type == 'method') {
            return $this->urlSlashCheck($this->updateOrder[$type]);
        }

        return $this->updateOrder[$type];
    }

    /**
     * Set statusOrder.
     *
     * @param string $url
     * @param string $method
     *
     * @return void
     */
    public function setStatusOrder(string $url, string $method): void
    {
        $this->statusOrder = ['url' => $url, 'method' => $method];
    }

    /**
     * Get statusOrder.
     *
     * @param string $type
     *
     * @return string
     */
    public function getStatusOrder(string $type): string
    {
        if ($type == 'method') {
            return $this->urlSlashCheck($this->statusOrder[$type]);
        }

        return $this->statusOrder[$type];
    }
}
