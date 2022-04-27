<?php


namespace PHPShopee\V2;


use PHPShopee\V2\Traits\ShopApi;

class Order extends ShopeeResource
{
    use ShopApi;

    protected $parentResource = '/api/v2/order';
}
