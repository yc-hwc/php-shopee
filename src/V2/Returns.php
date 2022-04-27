<?php


namespace PHPShopee\V2;


use PHPShopee\V2\Traits\ShopApi;

class Returns extends ShopeeResource
{
    use ShopApi;

    protected $parentResource = '/api/v2/returns';
}
