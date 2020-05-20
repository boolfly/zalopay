<?php
/************************************************************
 * *
 *  * Copyright © Boolfly. All rights reserved.
 *  * See COPYING.txt for license details.
 *  *
 *  * @author    info@boolfly.com
 * *  @project   ZaloPay
 */
namespace Boolfly\ZaloPay\Gateway\Request;

use Boolfly\ZaloPay\Gateway\Helper\Rate;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Payment\Gateway\ConfigInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ZaloAppInfoDataBuilder
 * @package Boolfly\ZaloPay\Gateway\Request
 */
class ZaloAppInfoDataBuilder extends AbstractDataBuilder implements BuilderInterface
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * ZaloAppInfoDataBuilder constructor.
     * @param ConfigInterface $config
     * @param DateTime        $dateTime
     */
    public function __construct(
        ConfigInterface $config,
        DateTime $dateTime
    ) {
        $this->config   = $config;
        $this->dateTime = $dateTime;
    }

    /**
     * @param array $buildSubject
     * @return array
     * @throws LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function build(array $buildSubject)
    {
        $payment          = SubjectReader::readPayment($buildSubject);
        $orderIncrementId = $payment->getOrder()->getOrderIncrementId();

        return [
            self::APP_ID => $this->getConfig(self::APP_ID),
            self::APP_TIME => $this->dateTime->timestamp() * 1000,
            self::APP_TRANS_ID => $this->getAppTransId($orderIncrementId),
            self::APP_USER => $this->getConfig(self::APP_USER)
        ];
    }

    /**
     * @param $orderIncrementId
     * @return string
     */
    private function getAppTransId($orderIncrementId)
    {
        return $this->dateTime->gmtDate('ymd') . '_' . $orderIncrementId;
    }

    /**
     * @return string
     */
    private function getExtraData()
    {
        return 'merchantName=' . $this->config->getValue('merchant_name');
    }

    /**
     * Get Config
     *
     * @param $path
     * @return mixed
     */
    private function getConfig($path)
    {
        return $this->config->getValue($path);
    }
}
