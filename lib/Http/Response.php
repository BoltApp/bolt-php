<?php

namespace BoltPay\Http;

/**
 * Class Response
 * @package BoltPay\Http
 *
 * Response of HTTP request.
 */
class Response {
    /**
     * HTTP status code.
     *
     * @var integer
     */
    private $status;

    /**
     * Decoded response body.
     *
     * @var object
     */
    private $body;

    /**
     * TraceID that can be used by Bolt team to investigate the issue.
     *
     * @var string
     */
    private $traceId;


    public function __construct($status, $body, $traceId) {
        $this->status = $status;
        $this->body = $body;
        $this->traceId = $traceId;
    }

    /**
     * Get the HTTP status code.
     *
     * @return integer
     */
    public function getStatusCode() {
        return $this->status;
    }

    /**
     * Get the HTTP response body as PHP object.
     *
     * @return object
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * Get the TraceID that can be used by Bolt team to investigate the issue.
     *
     * @return string
     */
    public function getTraceId() {
        return $this->traceId;
    }

    /**
     * Check if response data is successful
     * @return bool
     */
    public function isResponseSuccessful()
    {
        return (int)($this->status / 100) == 2;
    }
}