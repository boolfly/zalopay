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

use Magento\Payment\Gateway\Request\BuilderInterface;

/**
 * Class TransactionDataBuilder
 *
 * @package Boolfly\ZaloPay\Gateway\Request
 */
class TransactionDataBuilder extends AbstractDataBuilder implements BuilderInterface
{
    /**
     * Method
     */
    const METHOD = 'method';

    /**
     * @var string
     */
    private $requestType;

    /**
     * TransactionDataBuilder constructor.
     *
     * @param $requestType
     */
    public function __construct(
        $requestType
    ) {
        $this->requestType = $requestType;
    }

    /**
     * @inheritdoc
     */
    public function build(array $buildSubject)
    {
        return [];
    }
}
