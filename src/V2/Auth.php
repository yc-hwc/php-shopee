<?php


namespace PHPShopee\V2;


use PHPShopee\V2\Traits\AuthApi;

class Auth extends ShopeeResource
{
    use AuthApi;

    protected $parentResource = '/api/v2/auth';
}
