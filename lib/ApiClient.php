<?php

namespace BoltPay\Http;

/**
 * Class ApiClient
 * @package BoltPay\Http
 *
 * API Client to interact with Bolt APIs (https://docs.bolt.com/reference).
 */
class ApiClient {

    /**
     * Whether API client talks to sandbox or production.
     *
     * @var boolean
     */
    private $isSandbox;

    /**
     * API key for communicating with Bolt server.
     *
     * @var string
     */
    private $apiKey;

    private $httpClient;

    public function __construct(array $options)
    {
        $this->apiKey = $options['api_key'];
        $this->isSandbox = $options['is_sandbox'];
        $this->httpClient = new CurlClient($this->apiKey);
    }

    /**
     * @param array $params
     * @return Response
     */
    public function createOrder(array $params) {
        return $this->httpClient->post($this->getUrl('merchant/orders'), $params);
    }

    private function getUrl(string $path) {
        $base = $this->isSandbox ? 'https://api-sandbox.bolt.com/v1/' : 'https://api.bolt.com/v1/';
        return $base . $path;
    }
}
