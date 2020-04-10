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
 * Class AbstractDataBuilder
 * @package Boolfly\ZaloPay\Gateway\Request
 */
abstract class AbstractDataBuilder implements BuilderInterface
{
    /**@#+
     * Create Url path
     *
     * @const
     */
    const PAY_URL_PATH = 'v001/tpe/createorder';

    /**
     * Refund Url Path
     */
    const REFUND_TYPE = 'refundZaloPay';

    /**
     * Transaction Type: Refund
     */
    const REFUND = 'refund';

    /**
     * Transaction Id
     */
    const TRANSACTION_ID = 'transId';

    /**
     * App Id
     */
    const APP_ID = 'appid';

    /**
     * App Time
     */
    const APP_TIME = 'apptime';

    /**
     * Key 1
     */
    const KEY_1 = 'key1';

    /**
     * Key 2
     */
    const KEY_2 = 'key2';

    /**
     * App transaction Id
     */
    const APP_TRANS_ID = 'apptransid';

    /**
     * App user
     */
    const APP_USER = 'appuser';

    /**
     * Item information
     */
    const ITEM = 'item';

    /**
     * Embed data
     */
    const EMBED_DATA = 'embeddata';

    /**
     * Description
     */
    const DESCRIPTION = 'description';

    /**
     * Bank Code
     */
    const BANK_CODE = 'bankcode';

    /**
     * Amount
     */
    const AMOUNT = 'amount';

    /**
     * Mac
     */
    const MAC = 'mac';
}
