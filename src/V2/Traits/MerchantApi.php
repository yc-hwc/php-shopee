<?php


namespace PHPShopee\V2\Traits;


trait MerchantApi
{
    use Api;

    protected function setApiCommonParameters()
    {
        $shopeeSDK = &$this->shopeeSDK;
        $baseString = sprintf('%s%s%s%s', ...[
                $shopeeSDK->config['partnerId'],
                $this->uri,
                $this->timestamp,
                $shopeeSDK->config['accessToken'],
                $shopeeSDK->config['merchantId']
            ]
        );

        $this->options['query'] = array_merge([
            'partner_id'   => $shopeeSDK->config['partnerId'],
            'timestamp'    => $this->timestamp,
            'access_token' => $shopeeSDK->config['accessToken'],
            'merchant_id'  => $shopeeSDK->config['merchantId'],
            'sign'         => $this->generateSign($baseString, $shopeeSDK->config['partnerKey']),
        ], $this->options['query']);
    }
}
