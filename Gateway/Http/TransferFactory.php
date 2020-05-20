<?php
/************************************************************
 * *
 *  * Copyright © Boolfly. All rights reserved.
 *  * See COPYING.txt for license details.
 *  *
 *  * @author    info@boolfly.com
 * *  @project   ZaloPay
 */
namespace Boolfly\ZaloPay\Gateway\Http;

/**
 * Class TransferFactory
 *
 * @package Boolfly\ZaloPay\Gateway\Http
 */
class TransferFactory extends AbstractTransferFactory
{
    /**
     * @inheritdoc
     */
    public function create(array $request)
    {
        return $this->transferBuilder
            ->setMethod('POST')
            ->setHeaders($this->getAuthorization()->getHeaders())
            ->setBody($request)
            ->setUri($this->getUrl())
            ->build();
    }

    /**
     * Get Url
     *
     * @return string
     */
    private function getUrl()
    {
        $prefix = $this->isSandboxMode() ? 'sandbox_' : '';
        $path   = $prefix . 'payment_url';

        return rtrim($this->config->getValue($path), '/') . '/' . $this->urlPath;
    }
}
