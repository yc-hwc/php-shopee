<?php


namespace PHPShopee\V2;


use PHPShopee\V2\Traits\PublicApi;

class Push extends ShopeeResource
{
    use PublicApi;

    protected $parentResource = '/api/v2/push';
}
