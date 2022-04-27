<?php

namespace PHPShopee\V2;

use PHPShopee\V2\Traits\ShopApi;

class FirstMile extends ShopeeResource
{
    use ShopApi;

    protected $parentResource = '/api/v2/first_mile';
}
