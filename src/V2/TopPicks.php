<?php


namespace PHPShopee\V2;


use PHPShopee\V2\Traits\ShopApi;

class TopPicks extends ShopeeResource
{
    use ShopApi;

    protected $parentResource = '/api/v2/top_picks';
}
