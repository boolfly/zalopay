<?php
/************************************************************
 * *
 *  * Copyright © Boolfly. All rights reserved.
 *  * See COPYING.txt for license details.
 *  *
 *  * @author    info@boolfly.com
 * *  @project   Layered Navigation
 */
namespace Boolfly\ZaloPay\Plugin\Gateway\Command;

use Boolfly\ZaloPay\Gateway\Helper\Authorization;
use Boolfly\ZaloPay\Gateway\Request\AbstractDataBuilder;
use Magento\Payment\Gateway\Request\BuilderComposite;

/**
 * Class RefundGenerateMac
 *
 * @package Boolfly\ZaloPay\Plugin\Gateway\Request
 * @see BuilderComposite
 */
class RefundGenerateMac
{
    /**
     * @var Authorization
     */
    private $authorization;

    /**
     * PayUrlGenerateMac constructor.
     *
     * @param Authorization $authorization
     */
    public function __construct(
        Authorization $authorization
    ) {
        $this->authorization = $authorization;
    }

    /**
     * Generate Mac
     *
     * @param BuilderComposite $subject
     * @param $result
     */
    public function afterBuildRequestData($subject, $result)
    {
        if (is_array($result)) {
            $newParams = [];
            foreach ($this->getMacKeys() as $key) {
                if (!empty($result[$key])) {
                    $newParams[] = $result[$key];
                }
            }
            $result[AbstractDataBuilder::MAC] = $this->authorization->getMac($newParams);
        }

        return $result;
    }

    /**
     * @return array
     */
    protected function getMacKeys()
    {
        return [
            AbstractDataBuilder::APP_ID,
            AbstractDataBuilder::ZP_TRANS_ID,
            AbstractDataBuilder::AMOUNT,
            AbstractDataBuilder::DESCRIPTION,
            AbstractDataBuilder::TIMESTAMP
        ];
    }
}
