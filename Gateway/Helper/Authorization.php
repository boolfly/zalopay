<?php
/************************************************************
 * *
 *  * Copyright © Boolfly. All rights reserved.
 *  * See COPYING.txt for license details.
 *  *
 *  * @author    info@boolfly.com
 * *  @project   ZaloPay
 */
namespace Boolfly\ZaloPay\Gateway\Helper;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Payment\Gateway\ConfigInterface;
use Boolfly\ZaloPay\Gateway\Request\AbstractDataBuilder;

/**
 * Class Authorization
 *
 * @package Boolfly\ZaloPay\Gateway\Helper
 */
class Authorization
{
    /**
     * @var string
     */
    protected $params;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var Json
     */
    private $serializer;

    /**
     * Authorization constructor.
     *
     * @param Json            $serializer
     * @param ConfigInterface $config
     */
    public function __construct(
        Json $serializer,
        ConfigInterface $config
    ) {
        $this->config     = $config;
        $this->serializer = $serializer;
    }

    /**
     * Get Mac string
     *
     * @param array $params
     * @return string
     */
    public function getMac(array $params)
    {
        return hash_hmac('sha256', implode('|', $params), $this->getKey1());
    }

    /**
     * Get Mac By Key 2
     *
     * @param string $transData
     * @return string
     */
    public function getMacKey2(string $transData)
    {
        return hash_hmac('sha256', $transData, $this->getKey2());
    }

    /**
     * @return array
     */
    public function getMacData()
    {
        return [
            AbstractDataBuilder::APP_ID,
            AbstractDataBuilder::APP_TRANS_ID,
            AbstractDataBuilder::APP_USER,
            AbstractDataBuilder::AMOUNT,
            AbstractDataBuilder::APP_TIME,
            AbstractDataBuilder::EMBED_DATA,
            AbstractDataBuilder::ITEM
        ];
    }

    /**
     * @return string
     */
    public function getParameter()
    {
        return $this->params;
    }

    /**
     * Get Header
     *
     * @return array
     */
    public function getHeaders()
    {
        return [
            'Content-Type: application/x-www-form-urlencoded'
        ];
    }

    /**
     * Get Key 2
     *
     * @return string
     */
    private function getKey1()
    {
        return $this->config->getValue(AbstractDataBuilder::KEY_1);
    }

    /**
     * Get Key 2
     *
     * @return string
     */
    private function getKey2()
    {
        return $this->config->getValue(AbstractDataBuilder::KEY_2);
    }
}
