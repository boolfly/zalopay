<?php
/************************************************************
 * *
 *  * Copyright © Boolfly. All rights reserved.
 *  * See COPYING.txt for license details.
 *  *
 *  * @author    info@boolfly.com
 * *  @project   ZaloPay
 */
namespace Boolfly\ZaloPay\Block;

use Magento\Framework\Phrase;
use Magento\Payment\Block\ConfigurableInfo;

/**
 * Class Info
 *
 * @package Boolfly\ZaloPay\Block
 */
class Info extends ConfigurableInfo
{
    /**
     * Returns label
     *
     * @param string $field
     * @return Phrase
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function getLabel($field)
    {
        switch ($field) {
            case 'transaction_type':
                return __('Transaction Type');
            case 'transaction_id':
                return __('Transaction ID');
            case 'response_code':
                return __('Response Code');
            case 'approve_messages':
                return __('Approve Messages');
            default:
                return parent::getLabel($field);
        }
    }
}
