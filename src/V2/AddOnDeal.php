<?php


namespace PHPShopee\V2;


use PHPShopee\V2\Traits\ShopApi;

class AddOnDeal extends ShopeeResource
{
    use ShopApi;

    protected $parentResource = '/api/v2/add_on_deal';
}
