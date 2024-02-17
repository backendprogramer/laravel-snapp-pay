<?php

namespace BackendProgramer\SnappPay\Abstracts;

use BackendProgramer\SnappPay\Contracts\SnappPayInterface;
use BackendProgramer\SnappPay\Order\Order;
use BackendProgramer\SnappPay\SnappPayEndpoint;
use BackendProgramer\SnappPay\SnappPaySetting;
use BackendProgramer\SnappPay\Traits\EndpointSettings;
use BackendProgramer\SnappPay\Traits\OrderSettings;
use JetBrains\PhpStorm\Pure;

abstract class SnappPay implements SnappPayInterface
{
    use OrderSettings;
    use EndpointSettings;

    /**
     * Base Setting.
     *
     * @var SnappPaySetting setting
     */
    protected SnappPaySetting $setting;

    /**
     * End point of urls.
     *
     * @var SnappPayEndpoint endPoint
     */
    protected SnappPayEndpoint $endPoint;

    /**
     * Expaierd Values.
     *
     * @var array expiredValue
     */
    protected static array $expiredValue = [];

    /**
     * Class constructor.
     *
     * @param SnappPaySetting|null  $setting
     * @param SnappPayEndpoint|null $endPoint
     */
    public function __construct(SnappPaySetting $setting = null, SnappPayEndpoint $endPoint = null)
    {
        if (!$setting) {
            $this->setting = new SnappPaySetting(true);
        } else {
            $this->setting = $setting;
        }

        if (!$endPoint) {
            $this->endPoint = new SnappPayEndpoint(true);
        } else {
            $this->endPoint = $endPoint;
        }
    }

    /**
     * Gets SnappPay API URL base.
     *
     * @return string
     */
    #[Pure]
    public function getApiBaseUrl(): string
    {
        return $this->urlSlashCheck($this->setting->getBaseUrl(), true) . '/';
    }

    /**
     * Gets SnappPay API request basic token.
     *
     * @return array
     */
    abstract public function getRequestBasicToken(): array;

    /**
     * Gets SnappPay API request bearer token.
     *
     * @return array
     */
    abstract public function getRequestBearerToken(): array;

    /**
     * Check Merchant Eligibility.
     *
     * @param int    $amount
     * @param string $currency
     *
     * @return array
     */
    abstract public function isMerchantEligible(int $amount, string $currency): array;

    /**
     * Get Payment token.
     *
     * @param Order  $order
     * @param string $callBackUrl
     * @param string $transactionId
     *
     * @return array
     */
    abstract public function getPaymentToken(Order $order, string $callBackUrl, string $transactionId): array;

    /**
     * Verify order.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    abstract public function verifyOrder(string $paymentToken): array;

    /**
     * Settle order.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    abstract public function settleOrder(string $paymentToken): array;

    /**
     * Revert order.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    abstract public function revertOrder(string $paymentToken): array;

    /**
     * Get Payment Status.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    abstract public function getPaymentStatusOrder(string $paymentToken): array;

    /**
     * Cancel order.
     *
     * @param string $paymentToken
     *
     * @return array
     */
    abstract public function cancelOrder(string $paymentToken): array;

    /**
     * Update order.
     *
     * @param Order $order
     *
     * @return array
     */
    abstract public function updateOrder(Order $order): array;

    /**
     * Checks response for any error.
     *
     * @param array|string $response
     * @param array        $requestArgs
     * @param string       $requestUrl
     *
     * @return array
     */
    protected function processResponse(array|string $response, array $requestArgs = [], string $requestUrl = ''): array
    {
        if ($this->snappPayIsJson($response)) {
            $response = json_decode($response, true);
        }
        // Check if response has an error, and return it back if it is.
        if (isset($response['curlError'])) {
            $responseCode = 500;
            $responseBody = $response['curlError'];
        } elseif (isset($response['status'])) {
            $responseCode = $response['status'];
            $responseBody = $response['data'] ?? null;
        } else {
            if (isset($response['successful']) && !$response['successful']) {
                $responseCode = $this->getResponseCode($response['errorData']['errorCode']);
                $responseBody = $response['errorData']['message'];
            } else {
                $responseCode = 200;
                $responseBody = json_encode($response);
            }
        }

        $is_json = $this->snappPayIsJson($responseBody);
        // Check the status code, if it's not between 200 and 299 then it's an error.
        // for "RBA: Access Denied" strings raises array error in json_decode. for this king of errors, 
        // it's better to return arrya of error message.
        if (!$is_json) {
            return [
                'status' => 'error',
                'successful' => false,
                'statusCode' => $responseCode,
                'message' => $responseBody,
                'url' => $requestUrl,
                'args' => $requestArgs
            ];
        }
        return json_decode($responseBody, true);

    }

    /**
     * Custom remote request wrapper.
     *
     * @param string      $endpoint
     * @param string      $method
     * @param string      $token
     * @param array       $args
     * @param string|null $url
     *
     * @return array
     */
    protected function request(string $endpoint, string $method = 'GET', string $token = 'Basic', array $args = [], string $url = null): array
    {
        if (!$url) {
            $url = $this->getApiBaseUrl() . $endpoint;
        }

        if ($token == 'Basic') {
            $headers = $this->getRequestBasicToken();
        } else {
            $headers = $this->getRequestBearerToken();
        }
        $request = [
            'method' => $method,
        ];

        if ($method == 'GET' && !empty($args) && is_array($args)) {
            $url = $url . '?' . http_build_query($args);
        } else {
            if ($token === 'Basic') {
                $request['body'] = http_build_query($args);
            } else {
                $request['body'] = json_encode($args);
            }
        }

        // Add custom user-agent to request.
        $headers['user-agent'] = 'SnappPay, ' . $this->setting->getClientId();

        $request['headers'] = $headers;
        $response = $this->curlExecute($url, $request);
        //file_put_contents(ABSPATH . 'snapppay.log', date('Y-m-d H:i:s') . ' === ' . json_encode(['req' => $request, 'res' => $response, 'url' => $url], true) . PHP_EOL . PHP_EOL, FILE_APPEND);
        return $this->processResponse($response, $request, $url);
    }

    /**
     * Execute request by curl.
     *
     * @param string $url
     * @param array  $request
     *
     * @return array|string
     */
    protected function curlExecute(string $url, array $request): array|string
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_CONNECTTIMEOUT => 30,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $request['method'],
            CURLOPT_POSTFIELDS => $request['body'] ?? '',
            CURLOPT_HTTPHEADER => $request['headers'],
            CURLINFO_HEADER_OUT => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,

        ]);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);

            return ['curlError' => $error_msg];
        }

        curl_close($ch);

        return $response;
    }

    /**
     * Set expired value in array.
     *
     * @param string $name
     * @param string $value
     * @param int    $ttl
     *
     * @return void
     */
    protected function setExpiredValue(string $name, string $value, int $ttl): void
    {
        self::$expiredValue[$name] = [$value, $ttl];
    }

    /**
     * Gets expired value from array or false if expired data.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function getExpiredValue(string $name): bool
    {
        if (isset(self::$expiredValue[$name])) {
            if (isset(self::$expiredValue[$name][0])) {
                $value = self::$expiredValue[$name][0];
            } else {
                return false;
            }
            if (isset(self::$expiredValue[$name][1])) {
                $ttl = self::$expiredValue[$name][1];
            } else {
                return false;
            }
            if (time() >= $ttl) {
                return $value;
            } else {
                unset(self::$expiredValue[$name]);
            }
        }

        return false;
    }

    /**
     * Check response error and return error code.
     *
     * @param int $errorCode
     *
     * @return int
     */
    protected function getResponseCode(int $errorCode): int
    {
        return match ($errorCode) {
            1000 => 500,
            1003, 1013 => 401,
            1008 => 409,
            1011 => 400,
            default => 200,
        };
    }

    /**
     * Check response is json or not.
     *
     * @param array|string $string
     *
     * @return bool
     */
    protected function snappPayIsJson(array|string $string): bool
    {
        return !is_array($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE);
    }
}
