<?php
/************************************************************
 * *
 *  * Copyright © Boolfly. All rights reserved.
 *  * See COPYING.txt for license details.
 *  *
 *  * @author    info@boolfly.com
 * *  @project   ZaloPay
 */
namespace Boolfly\ZaloPay\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\UrlInterface;
use Magento\Payment\Helper\Data as PaymentHelper;

/**
 * Class ZaloPayConfigProvider
 *
 * @package Boolfly\ZaloPay\Model
 */
class ZaloPayConfigProvider implements ConfigProviderInterface
{
    /**
     * ZaloPay Logo
     */
    const ZALOPAY_LOGO_SRC = 'https://static.zalopay.com.vn/stc/quydinh/ver181218/images/logozlp1.png';

    /**
     * @var ResolverInterface
     */
    protected $localeResolver;

    /**
     * @var PaymentHelper
     */
    protected $paymentHelper;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * ZaloPayConfigProvider constructor.
     *
     * @param ResolverInterface $localeResolver
     * @param PaymentHelper     $paymentHelper
     * @param UrlInterface      $urlBuilder
     */
    public function __construct(
        ResolverInterface $localeResolver,
        PaymentHelper $paymentHelper,
        UrlInterface $urlBuilder
    ) {
        $this->localeResolver = $localeResolver;
        $this->paymentHelper  = $paymentHelper;
        $this->urlBuilder     = $urlBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        $config = [
            'payment' => [
                'zalopay' => [
                    'redirectUrl' => $this->urlBuilder->getUrl('zalopay/payment/start'),
                    'logoSrc' => self::ZALOPAY_LOGO_SRC
                ]
            ]
        ];

        return $config;
    }
}
