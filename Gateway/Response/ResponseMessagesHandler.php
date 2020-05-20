<?php
/************************************************************
 * *
 *  * Copyright © Boolfly. All rights reserved.
 *  * See COPYING.txt for license details.
 *  *
 *  * @author    info@boolfly.com
 * *  @project   ZaloPay
 */
namespace Boolfly\ZaloPay\Gateway\Response;

use Magento\Sales\Model\Order\Payment;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Helper\ContextHelper;
use Magento\Payment\Gateway\Response\HandlerInterface;
use Boolfly\ZaloPay\Gateway\Validator\AbstractResponseValidator;

/**
 * Class ResponseMessagesHandler
 *
 * @package Boolfly\ZaloPay\Gateway\Response
 */
class ResponseMessagesHandler implements HandlerInterface
{
    /**
     * @param array $handlingSubject
     * @param array $response
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function handle(array $handlingSubject, array $response)
    {
        $paymentDO = SubjectReader::readPayment($handlingSubject);
        /** @var Payment $payment */
        $payment = $paymentDO->getPayment();
        ContextHelper::assertOrderPayment($payment);

        $responseCode = $response[AbstractResponseValidator::RETURN_CODE];
        $messages     = $response[AbstractResponseValidator::RESPONSE_MESSAGE];
        $state        = $this->getState($responseCode);

        if ($state) {
            $payment->setAdditionalInformation(
                'approve_messages',
                $messages
            );
        } else {
            $payment->setIsTransactionPending(false);
            $payment->setIsFraudDetected(true);
            $payment->setAdditionalInformation('error_messages', $messages);
        }
    }

    /**
     * @param integer $responseCode
     * @return boolean
     */
    protected function getState($responseCode)
    {
        if ((string)$responseCode === '1' || (string)$responseCode === '2') {
            return false;
        }
        return true;
    }
}
