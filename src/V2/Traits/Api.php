<?php

namespace PHPShopee\V2\Traits;

use GuzzleHttp\Client as Http;
use GuzzleHttp\Psr7\Response;

trait Api
{
    public $url;

    public $uri;

    public $fullUrl;

    protected $timestamp;

    protected $method = 'post';

    protected $response;

    /**
     * @var Http $httpClient
     */
    protected $httpClient;

    protected $options = [
        'verify'  => false,
        'timeout' => 60,
        'query'   => [],
        'body'    => '',
        'headers' => [
            'Content-type' => 'application/json',
            'Accept'       => 'application/json',
        ],
    ];

    protected $shopeeSDK;

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:18
     * @return static
     */
    protected function generateUrl()
    {
        $this->uri = $this->parentResource . $this->childResources;
        $this->url = $this->shopeeSDK->config['shopeeUrl'];
        $this->timestamp = time();
        $this->setApiCommonParameters();
        return sprintf('%s%s', $this->url, $this->uri);
    }

    public function fullUrl()
    {
        $this->generateUrl();
        $fullUrl = $this->fullUrl = sprintf('%s%s?%s', ...[
            $this->url,
            $this->uri,
            empty($this->options['query'])? '': http_build_query($this->options['query'])
        ]);

        return $fullUrl;
    }

    /**
     * 设置api公共参数
     * @Author: hwj
     * @DateTime: 2022/4/23 11:22
     */
    protected function setApiCommonParameters()
    {
        $shopeeSDK = &$this->shopeeSDK;
        $baseString = sprintf('%s%s%s%s%s', ...[
                $shopeeSDK->config['partnerId'],
                $this->uri,
                $this->timestamp,
                $shopeeSDK->config['accessToken'],
                $shopeeSDK->config['shopId']
            ]
        );

        $this->options['query'] = array_merge([
            'partner_id'   => $shopeeSDK->config['partnerId'],
            'timestamp'    => $this->timestamp,
            'access_token' => $shopeeSDK->config['accessToken'],
            'shop_id'      => $shopeeSDK->config['shopId'],
            'sign'         => $this->generateSign($baseString, $shopeeSDK->config['partnerKey']),
        ], $this->options['query']);
    }

    /**
     * 生成签名
     * @Author: hwj
     * @DateTime: 2022/4/23 11:22
     * @param $had
     * @param $key
     * @return string
     */
    protected function generateSign($had, $key)
    {
        return bin2hex(hash_hmac('sha256', $had, $key,true));
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/26 20:33
     * @param array $options
     * @return static
     */
    public function withOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:19
     * @param int $timeout
     * @return static
     */
    public function setTimeout($timeout = 60)
    {
        $this->options['timeout'] = $timeout;
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/27 11:30
     * @return array|mixed|\Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post()
    {
        return $this->setMethod('post')->run();
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/27 11:30
     * @return array|mixed|\Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get()
    {
        return $this->setMethod('get')->run();
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/27 11:29
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:19
     * @param Response $response
     * @return Response
     */
    public function setResponse(Response $response)
    {
        return $this->response = $response;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/27 11:14
     * @return array|mixed|\Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function run()
    {
        if (empty($this->httpClient)) {
            $this->httpClient = new Http();
        }

        $resource = $this->generateUrl();
        $response = $this->httpClient->request($this->method, $resource, $this->options);
        $this->setResponse($response);
        $data = @json_decode($response->getBody(), true);
        return is_array($data)? $data: $response->getBody();
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/27 10:47
     * @param $method
     * @return static
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:20
     * @param mixed $body
     * @param string $contentType
     * @return static
     */
    public function withBody(mixed $body, $contentType = 'application/json')
    {
        $this->options['body'] = is_array($body)? json_encode($body): $body;
        $this->options['headers']['Content-type'] = $contentType;
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:20
     * @param array $queryString
     * @return static
     */
    public function withQueryString(array $queryString)
    {
        $this->options['query'] = $queryString;
        return $this;
    }

    /**
     * @Author: hwj
     * @DateTime: 2022/4/23 11:20
     * @param array $headers
     * @return static
     */
    public function withHeaders(array $headers)
    {
        $this->options['headers'] = array_merge($this->options['headers'], $headers);
        return $this;
    }
}
