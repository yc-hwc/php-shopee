<?php


namespace PHPShopee\V2;


use PHPShopee\V2\Traits\MerchantApi;

class GlobalProduct extends ShopeeResource
{
    use MerchantApi;

    protected $parentResource = '/api/v2/global_product';
}
