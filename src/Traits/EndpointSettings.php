<?php

namespace BackendProgramer\SnappPay\Traits;

trait EndpointSettings
{
    /**
     * Control url to start with slash and end with slash.
     *
     * @param string $url
     * @param bool   $removeFromEnd
     * @param bool   $removeFromStart
     *
     * @return string
     */
    public function urlSlashCheck(string $url, bool $removeFromEnd = true, bool $removeFromStart = true): string
    {
        if ($removeFromEnd && str_ends_with($url, '/')) {
            $url = substr($url, 0, strlen($url) - 1);
        }
        if ($removeFromStart && str_starts_with($url, '/')) {
            $url = substr($url, 1);
        }

        return $url;
    }
}
