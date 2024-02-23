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
 * API Client to interact with Bolt APIs (https://docs.bolt.com/api_reference).
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
     * @return Http\Response
     */
    public function createOrder(array $params) {
        return $this->httpClient->post($this->getUrl('merchant/orders'), $params);
    }

    /**
     * @param $reference
     * @return Http\Response
     * @internal param array $params
     */
    public function getTransactionDetails($reference) {
        return $this->httpClient->get($this->getUrl('merchant/transactions/' . $reference));
    }

    /**
     * @param array $params
     * @return Http\Response
     */
    public function void(array $params) {
        return $this->httpClient->post($this->getUrl('merchant/transactions/void'), $params);
    }

    /**
     * @param array $params
     * @return Http\Response
     */
    public function capture(array $params) {
        return $this->httpClient->post($this->getUrl('merchant/transactions/capture'), $params);
    }

    /**
     * @param array $params
     * @return Http\Response
     */
    public function credit(array $params) {
        return $this->httpClient->post($this->getUrl('merchant/transactions/credit'), $params);
    }

    /**
     * Authorize a transaction from an existing customer (i.e. recharge).
     * @param array $params
     * @return Http\Response
     */
    public function authorize(array $params) {
        return $this->httpClient->post($this->getUrl('merchant/transactions/authorize'), $params);
    }

    /**
     * Manually review a transaction that is in the reversibly_rejected state.
     * @param array $params
     * @return Http\Response
     */
    public function review(array $params) {
        return $this->httpClient->post($this->getUrl('merchant/transactions/review'), $params);
    }

    /**
     * Send shipment tracking details
     * @param array $params
     * @return Http\Response
     */
    public function trackShipment(array $params) {
        return $this->httpClient->post($this->getUrl('merchant/track_shipment'), $params);
    }

    private function getUrl($path) {
        $base = $this->isSandbox ? Bolt::$apiSandboxUrl . '/v1/' : Bolt::$apiProductionUrl . '/v1/';
        return $base . $path;
    }
}
