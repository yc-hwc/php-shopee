<?php

namespace PHPShopee;

use PHPShopee\Exception\SdkException;
use PHPShopee\V2\{FirstMile,Shop,Auth,GlobalProduct,MediaSpace,Product,Merchant,Order,
    Logistics,Payment,Discount,BundleDeal,AddOnDeal,Voucher,FollowPrize,TopPicks,ShopCategory,
    Returns,AccountHealth,Publics,Push
};

/**
 * @property-read FirstMile $firstMile
 * @property-read Shop $shop
 * @property-read Auth $auth
 * @property-read GlobalProduct $globalProduct
 * @property-read MediaSpace $mediaSpace
 * @property-read Product $product
 * @property-read Merchant $merchant
 * @property-read Order $order
 * @property-read Logistics $logistics
 * @property-read Payment $payment
 * @property-read Discount $discount
 * @property-read BundleDeal $bundleDeal
 * @property-read AddOnDeal $addOnDeal
 * @property-read Voucher $voucher
 * @property-read FollowPrize $followPrize
 * @property-read TopPicks $topPicks
 * @property-read ShopCategory $shopCategory
 * @property-read Returns $returns
 * @property-read AccountHealth $accountHealth
 * @property-read Publics $publics
 * @property-read Push $push
 *
 * @method FirstMile firstMile()
 * @method Shop shop()
 * @method Auth auth()
 * @method GlobalProduct globalProduct()
 * @method MediaSpace mediaSpace()
 * @method Product product()
 * @method Merchant merchant()
 * @method Order order()
 * @method Logistics logistics()
 * @method Payment payment()
 * @method Discount discount()
 * @method BundleDeal bundleDeal()
 * @method AddOnDeal addOnDeal()
 * @method Voucher voucher()
 * @method FollowPrize followPrize()
 * @method TopPicks topPicks()
 * @method ShopCategory shopCategory()
 * @method Returns returns()
 * @method AccountHealth accountHealth()
 * @method Publics publics()
 * @method Push push()
 */
class ShopeeSDK
{

    protected $defaultApiVersion = 'V2';

    protected $resources = [
        'firstMile',
        'shop',
        'auth',
        'globalProduct',
        'mediaSpace',
        'product',
        'merchant',
        'order',
        'logistics',
        'payment',
        'discount',
        'bundleDeal',
        'addOnDeal',
        'voucher',
        'followPrize',
        'topPicks',
        'shopCategory',
        'returns',
        'accountHealth',
        'publics',
        'push'
    ];

    public $config = [
        'shopeeUrl'   => '',
        'apiVersion'  => '',
        'partnerId'   => '',
        'partnerKey'  => '',
        'accessToken' => '',
        'shopId'      => '',
    ];

    public function __construct($config)
    {
        $this->config = array_merge($this->config,[
            'apiVersion' => $this->defaultApiVersion, // 默认api版本为v2
        ], $config);

        $this->defaultApiVersion = $this->config['apiVersion']?: $this->defaultApiVersion;
    }

    public function __get($resourceName)
    {
        return $this->$resourceName();
    }

    public function __call($resourceName, $arguments)
    {
        if (!in_array($resourceName, $this->resources)) {
            throw new SdkException(sprintf('Invalid resource name %s. Pls check the API Reference to get the appropriate resource name.', $resourceName));
        }

        $resourceClassName = __NAMESPACE__ . "\\" . $this->defaultApiVersion . "\\" . \ucfirst($resourceName);

        $resource = new $resourceClassName($this);

        return $resource;
    }

    public static function config($config)
    {
        return new ShopeeSDK($config);
    }
}
