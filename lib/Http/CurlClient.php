<?php

namespace BoltPay\Http;

/**
 * Class CurlClient
 * @package BoltPay\Http
 *
 * Implementation of HTTP client backed by curl.
 */
class CurlClient
{
    const REQUEST_TYPE_GET = 'get';
    const REQUEST_TYPE_POST = 'post';

    /**
     * API key for communicating with Bolt server.
     *
     * @var string
     */
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $url URL to send a request to.
     * @param array request parameters
     *
     * @return Response response.
     */
    public function post($url, $params)
    {
        return $this->sendRequest($url, self::REQUEST_TYPE_POST, $params);
    }


    /**
     * @param string $url URL to send a request to.
     * @param array request parameters
     *
     * @return Response response.
     */
    public function get($url)
    {
        return $this->sendRequest($url, self::REQUEST_TYPE_GET);
    }

    private function sendRequest($url, $method, $params = null ) {
        $ch = curl_init($url);
        $contentLength = 0;
        if ($method === self::REQUEST_TYPE_POST) {
            curl_setopt($ch, CURLOPT_POST, 1);
            if ($params != null) {
                $encoded = json_encode($params);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
                $contentLength = strlen($encoded);
            }
        }
        $headers = array(
            'Content-Type: application/json',
            'Content-Length: ' . $contentLength,
            'X-Api-Key: ' . $this->apiKey,
            'X-Nonce: ' . rand(100000000, 999999999),
            'User-Agent: BoltPay/PHP-Client-0.1'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $rawResponse = curl_exec($ch);

        if ($rawResponse === false) { // Timeout
            curl_close($ch);
            return new Response(0, "{}", 0);
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);

        $chHeaders = substr($rawResponse, 0, $headerSize);
        $body = json_decode(substr($rawResponse, $headerSize));

        $boltTraceId = '';
        foreach(explode("\r\n", $chHeaders) as $row) {
            if(preg_match('/(.*?): (.*)/', $row, $matches)) {
                if(count($matches) == 3 && $matches[1] == 'X-Bolt-Trace-Id') {
                    $boltTraceId = $matches[2];
                    break;
                }
            }
        }
        return new Response($statusCode, $body ?: [], $boltTraceId);
    }
}





