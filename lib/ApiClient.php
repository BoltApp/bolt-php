<?php

namespace BoltPay;

/**
 * Class ApiClient
 * @package BoltPay
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

    public function __construct(array $options) {
        $this->apiKey = $options['api_key'];
        $this->isSandbox = $options['is_sandbox'];
        $this->httpClient = new Http\CurlClient($this->apiKey);
    }

    /**
     * @param array $params
     * @return Response
     */
    public function createOrder(array $params) {
        return $this->httpClient->post($this->getUrl('merchant/orders'), $params);
    }

    /**
     * @param $reference
     * @return Response
     * @internal param array $params
     */
    public function getTransactionDetails($reference) {
        return $this->httpClient->get($this->getUrl('merchant/transactions/' . $reference));
    }

    private function getUrl($path) {
        $base = $this->isSandbox ? Bolt::$apiSandboxUrl . '/v1/' : Bolt::$apiProductionUrl . '/v1/';
        return $base . $path;
    }
}
