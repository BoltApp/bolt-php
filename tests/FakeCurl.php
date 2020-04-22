<?php

namespace BoltPay\Http;

function get_fake_curl_instance()
{
    global $bolt_test_fake_curl;
    if ($bolt_test_fake_curl == null) {
        return $bolt_test_fake_curl = new FakeCurl();
    } else {
        return $bolt_test_fake_curl;
    }
}

function curl_init($url)
{
    global $bolt_test_fake_curl;
    $bolt_test_fake_curl->setURL($url);
    return $bolt_test_fake_curl;
}

function curl_setopt($ch, $option, $value)
{
    $ch->setOption($option, $value);
}

function curl_exec($ch)
{
    return $ch->execute();
}

function curl_getinfo($ch, $opt = -1)
{
    return $ch->getInfo($opt);
}

function curl_close($ch)
{
    $ch = null;
}

class FakeCurl
{
    private $url;
    private $optMap;
    private $infoMap;

    private $responseCode;
    private $responseHeaderStr;
    private $responseBodyStr;

    public function __construct()
    {
        $this->optMap = array();
        $this->infoMap = array();
    }

    public function getURL()
    {
        return $this->url;
    }

    public function setURL($url)
    {
        return $this->url = $url;
    }

    public function getOptions()
    {
        return $this->optMap;
    }

    public function getOption($option)
    {
        return $this->optMap[strval($option)];
    }

    public function setOption($option, $value)
    {
        $this->optMap["$option"] = $value;
    }

    public function mockResponseCode($statusCode)
    {
        $this->responseCode = $statusCode;
    }

    public function mockResponseHeader($headerArray)
    {
        $s = '';
        foreach ($headerArray as $key => $value) {
            $s = $s . "$key: $value\r\n";
        }
        $this->responseHeaderStr = $s . "\r\n";
    }

    public function mockResponseBody($responseBodyStr)
    {
        $this->responseBodyStr = $responseBodyStr;
    }

    public function getInfo($option)
    {
        if ($option == CURLINFO_HTTP_CODE) {
            return $this->responseCode;
        } elseif ($option == CURLINFO_HEADER_SIZE) {
            return strlen($this->responseHeaderStr);
        }
        return '';
    }

    public function execute()
    {
        return $this->responseHeaderStr . $this->responseBodyStr;
    }
}