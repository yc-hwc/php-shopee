<?php


namespace PHPShopee\V2;


use PHPShopee\V2\Traits\MerchantApi;

class Merchant extends ShopeeResource
{
    use MerchantApi;

    protected $parentResource = '/api/v2/merchant';
}
