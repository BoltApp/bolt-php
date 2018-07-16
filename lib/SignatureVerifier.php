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

    public function __construct($signingSecret)
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
        $computedHmac = trim(base64_encode(hash_hmac('sha256', $payload, $this->signingSecret, true)));
        return $hmacHeader == $computedHmac;
    }

    /**
     * Verifying Hook Requests. If signing secret is not defined fallback to api call.
     * @param $payload
     * @param $hmacHeader
     * @return bool
     */
    public function verifyHook($payload, $hmacHeader)
    {
        return $this->verifySignature($payload, $hmacHeader) || $this->verifyHookApi($payload, $hmacHeader);
    }


    /**
     * Verifying Hook Requests via API call.
     *
     * @param $payload
     * @param $hmacHeader
     * @return bool if signature is verified
     */
    public function verifyHookApi($payload, $hmacHeader)
    {
        $url = Helper::getApiUrl() . "/v1/merchant/verify_signature";
        $key = Bolt::getApiKey();

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $httpHeader = array(
            "X-Api-Key: $key",
            "X-Bolt-Hmac-Sha256: $hmacHeader",
            "Content-type: application/json",
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_exec($ch);

        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return (int)($response / 100) == 2;
    }

}
