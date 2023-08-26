<?php

namespace BackendProgramer\SnappPay;

class SnappPaySetting
{
    /**
     * Username of the snapppay.
     *
     * @var string username
     */
    protected string $username;

    /**
     * Password of the snapppay.
     *
     * @var string password
     */
    protected string $password;

    /**
     * Client ID of the snapppay.
     *
     * @var string clientId
     */
    protected string $clientId;

    /**
     * Client Secret of the snapppay.
     *
     * @var string clientSecret
     */
    protected string $clientSecret;

    /**
     * Base url of the snapppay api.
     *
     * @var string baseUrl
     */
    protected string $baseUrl;

    /**
     * Setting constructor.
     *
     * @param bool setFromConfig
     */
    public function __construct(bool $setFromConfig = false)
    {
        if ($setFromConfig) {
            $this->username = config('snapp-pay.settings.user_name');
            $this->password = config('snapp-pay.settings.password');
            $this->clientId = config('snapp-pay.settings.client_id');
            $this->clientSecret = config('snapp-pay.settings.client_secret');
            $this->baseUrl = config('snapp-pay.settings.base_url');
        }
    }

    /**
     * Setting Credentials.
     *
     * @param string username
     * @param string password
     * @param string clientId
     * @param string clientSecret
     * @param string baseUrl
     *
     * @return SnappPaySetting
     */
    public static function credentials(string $username, string $password, string $clientId, string $clientSecret, string $baseUrl): SnappPaySetting
    {
        $instance = new self();
        $instance->setUsername($username);
        $instance->setPassword($password);
        $instance->setClientId($clientId);
        $instance->setClientSecret($clientSecret);
        $instance->setBaseUrl($baseUrl);

        return $instance;
    }

    /**
     * Set Username.
     *
     * @param string $username
     *
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Get Username.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set Password.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Get Password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set clientId.
     *
     * @param string $clientId
     *
     * @return void
     */
    public function setClientId(string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * Get clientId.
     *
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * Set clientSecret.
     *
     * @param string $clientSecret
     *
     * @return void
     */
    public function setClientSecret(string $clientSecret): void
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * Get clientSecret.
     *
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * Set baseUrl.
     *
     * @param string $baseUrl
     *
     * @return void
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Get baseUrl.
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return str_ends_with($this->baseUrl, '/') ? $this->baseUrl : $this->baseUrl.'/';
    }
}
