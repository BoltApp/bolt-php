<?php

namespace BoltPay\Http;

include_once("FakeCurl.php");

class CurlClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var string
     */
    private $apiKey = 'test_key';

    /**
     * @var string
     */
    private $url = 'https://api.github.com/users/hadley/orgs';

    /**
     * @var array
     */
    private $mockResponseHeader = [
        'X-Bolt-Trace-Id' => 'test_trace_id',
        'header1' => 'value1',
        'header2' => 'value2'
    ];

    /**
     * @var string
     */
    private $mockResponseBody = [
        'X-Bolt-Trace-Id' => 'test_trace_id',
        'header1' => 'value1',
        'header2' => 'value2'
    ];

    /**
     * @var CurlClient
     */
    private $curlClient;

    protected function setUp()
    {
        $this->mockResponseHeader = [
            'X-Bolt-Trace-Id' => 'test_trace_id',
            'header1' => 'value1',
            'header2' => 'value2'
        ];

        $this->mockResponseBody = json_encode([
            'status' => 'OK'
        ]);

        $this->curlClient = new CurlClient($this->apiKey);
    }

    /**
     * @test
     */
    public function get()
    {
        # mock curl response
        $bolt_test_fake_curl = get_fake_curl_instance();
        $bolt_test_fake_curl->mockResponseCode(200);
        $bolt_test_fake_curl->mockResponseHeader($this->mockResponseHeader);
        $bolt_test_fake_curl->mockResponseBody($this->mockResponseBody);

        $response = $this->curlClient->get($this->url);

        # check request headers
        $requestHeaders = $bolt_test_fake_curl->getOption(CURLOPT_HTTPHEADER);
        $this->assertTrue(in_array('Content-Type: application/json', $requestHeaders));
        $this->assertTrue(in_array('Content-Length: 0', $requestHeaders));
        $this->assertTrue(in_array('X-Api-Key: ' . $this->apiKey, $requestHeaders));
        $this->assertTrue(in_array('User-Agent: BoltPay/PHP-Client-0.1', $requestHeaders));

        # check url
        $this->assertEquals($this->url, $bolt_test_fake_curl->getURL());

        # check options
        $this->assertEquals(true, $bolt_test_fake_curl->getOption(CURLOPT_RETURNTRANSFER));
        $this->assertEquals(true, $bolt_test_fake_curl->getOption(CURLOPT_HEADER));

        # check response
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('test_trace_id', $response->getTraceId());
        $this->assertEquals($this->mockResponseBody, json_encode($response->getBody()));
    }

    /**
     * @test
     */
    public function post()
    {
        # mock curl response
        $bolt_test_fake_curl = get_fake_curl_instance();
        $bolt_test_fake_curl->mockResponseCode(200);
        $bolt_test_fake_curl->mockResponseHeader($this->mockResponseHeader);
        $bolt_test_fake_curl->mockResponseBody($this->mockResponseBody);

        $params = [
            'param1' => 'value1',
            'param2' => 'value2'
        ];
        $response = $this->curlClient->post($this->url, $params);

        # check url
        $this->assertEquals($this->url, $bolt_test_fake_curl->getURL());

        # check request headers
        $requestHeaders = $bolt_test_fake_curl->getOption(CURLOPT_HTTPHEADER);
        $this->assertTrue(in_array('Content-Type: application/json', $requestHeaders));
        $this->assertTrue(in_array('Content-Length: ' . strlen(json_encode($params)), $requestHeaders));
        $this->assertTrue(in_array('X-Api-Key: ' . $this->apiKey, $requestHeaders));
        $this->assertTrue(in_array('User-Agent: BoltPay/PHP-Client-0.1', $requestHeaders));


        # check other options
        $this->assertEquals(1, $bolt_test_fake_curl->getOption(CURLOPT_POST));
        $this->assertEquals(json_encode($params), $bolt_test_fake_curl->getOption(CURLOPT_POSTFIELDS));
        $this->assertEquals(true, $bolt_test_fake_curl->getOption(CURLOPT_RETURNTRANSFER));
        $this->assertEquals(true, $bolt_test_fake_curl->getOption(CURLOPT_HEADER));

        # check response
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('test_trace_id', $response->getTraceId());
        $this->assertEquals($this->mockResponseBody, json_encode($response->getBody()));
    }
}