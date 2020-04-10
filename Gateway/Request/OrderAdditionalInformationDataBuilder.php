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
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Request\BuilderInterface;

/**
 * Class OrderAdditionalInformationDataBuilder
 *
 * @package Boolfly\ZaloPay\Gateway\Request
 */
class OrderAdditionalInformationDataBuilder extends AbstractDataBuilder implements BuilderInterface
{
    /**
     * Zalo Pay App
     */
    const ZALOPAY_APP = 'zalopayapp';

    /**
     * Desc Text
     */
    const DESCRIPTION_TEXT = 'ZaloPay Integration for Magento 2';

    /**
     * @var Json
     */
    private $serializer;

    /**
     * @var Rate
     */
    private $helperRate;

    /**
     * OrderAdditionalInformationDataBuilder constructor.
     *
     * @param Json $serializer
     * @param Rate $helperRate
     */
    public function __construct(
        Json $serializer,
        Rate $helperRate
    ) {
        $this->serializer = $serializer;
        $this->helperRate = $helperRate;
    }

    /**
     * @param array $buildSubject
     * @return array
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function build(array $buildSubject)
    {
        $payment = SubjectReader::readPayment($buildSubject);
        $order   = $payment->getPayment()->getOrder();

        return [
            self::EMBED_DATA => $this->serializer->serialize($this->getEmbedData()),
            self::AMOUNT => (int) $this->helperRate->getVndAmount($order, round((float)SubjectReader::readAmount($buildSubject), 2)),
            self::DESCRIPTION => self::DESCRIPTION_TEXT,
            self::BANK_CODE => self::ZALOPAY_APP
        ];
    }

    /**
     * @return array
     */
    private function getEmbedData()
    {
        return [
            'merchantinfo' => 'boolfly'
        ];
    }
}
