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
 * Class SignatureVerifier
 * @package BoltPay
 *
 * Helper class to verify the signature of request from Bolt server.
 */
class SignatureVerifier {

    /**
     * Pre exchanged secret issued by Bolt.
     *
     * @var bool
     */
    private $signingSecret;

    public function __construct($signingSecret) {
        $this->signingSecret = $signingSecret;
    }

    /**
     * Verifying Hook Requests using pre-exchanged signing secret key.
     *
     * @param $payload
     * @param $hmacHeader
     * @return bool
     */
    public function verifySignature($payload, $hmacHeader) {
        $computedHmac = trim(base64_encode(hash_hmac('sha256', $payload, $this->signingSecret, true)));
        return $hmacHeader == $computedHmac;
    }

}
