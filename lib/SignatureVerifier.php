<?php

namespace BoltPay;

/**
 * Class SignatureVerifier
 * @package BoltPay
 *
 * Helper class to verify the signature of request from Bolt server.
 */
class SignatureVerifier {

    /**
     * Preexchanged secret issued by Bolt.
     *
     * @var bool
     */
    private $signingSecret;

    public function __construct(bool $signingSecret)
    {
        $this->signingSecret = $signingSecret;
    }

    /**
     * Verifying Hook Requests using pre-exchanged signing secret key.
     *
     * @param $payload
     * @param $hmacHeader
     * @return bool
     */
    public function verifySignature($payload, $hmacHeader)
    {
        $computedHmac  = trim(base64_encode(hash_hmac('sha256', $payload, $this->signingSecret, true)));
        return $hmacHeader == $computedHmac;
    }
}
