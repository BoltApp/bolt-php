<?php
/**
 * Bolt PHP library
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License (MIT)
 * that is bundled with this package in the file LICENSE.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/MIT
 *
 * @category   Bolt
 * @copyright  Copyright (c) 2018 Bolt Financial, Inc (https://www.bolt.com)
 * @license    https://opensource.org/licenses/MIT  MIT License (MIT)
 */

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
