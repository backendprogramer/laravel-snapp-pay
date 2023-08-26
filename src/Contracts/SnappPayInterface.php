<?php

namespace BackendProgramer\SnappPay\Contracts;

use BackendProgramer\SnappPay\Order\Order;

interface SnappPayInterface
{
    /**
     * Get SnappPay API URL base.
     *
     * @return string
     */
    public function getApiBaseUrl(): string;

    /**
     * Get SnappPay API request basic token.
     *
     * @return array
     */
    public function getRequestBasicToken(): array;

    /**
     * Get SnappPay API request bearer token.
     *
     * @return array
     */
    public function getRequestBearerToken(): array;

    /**
     * Check Merchant Eligibility.
     *
     * @param int    $amount
     * @param string $currency
     *
     * @return array
     */
    public function isMerchantEligible(int $amount, string $currency): array;

    /**
     * Get Payment token.
     *
     * @param Order  $order
     * @param string $callBackUrl
     * @param string $transactionId
     *
     * @return array
     */
    public function getPaymentToken(Order $order, string $callBackUrl, string $transactionId): array;

    /**
     * Verify order.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    public function verifyOrder(string $paymentToken): array;

    /**
     * Settle order.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    public function settleOrder(string $paymentToken): array;

    /**
     * Revert order.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    public function revertOrder(string $paymentToken): array;

    /**
     * Get Payment Status.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    public function getPaymentStatusOrder(string $paymentToken): array;

    /**
     * Cancel order.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    public function cancelOrder(string $paymentToken): array;

    /**
     * Update order.
     *
     * @param Order $order
     *
     * @return array
     */
    public function updateOrder(Order $order): array;
}
