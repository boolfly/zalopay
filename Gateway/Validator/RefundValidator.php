<?php
/************************************************************
 * *
 *  * Copyright © Boolfly. All rights reserved.
 *  * See COPYING.txt for license details.
 *  *
 *  * @author    info@boolfly.com
 * *  @project   ZaloPay
 */
namespace Boolfly\ZaloPay\Gateway\Validator;

use Boolfly\ZaloPay\Gateway\Request\AbstractDataBuilder;
use Magento\Payment\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Validator\ResultInterface;

/**
 * Class RefundValidator
 *
 * @package Boolfly\ZaloPay\Gateway\Validator
 */
class RefundValidator extends AbstractResponseValidator
{
    /**
     * @param array $validationSubject
     * @return ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function validate(array $validationSubject)
    {
        $response      = SubjectReader::readResponse($validationSubject);
        $errorMessages = [];

        $validationResult = $this->validateRefundId($response)
            && $this->validateReturnCode($response);

        if (!$validationResult) {
            $errorMessages = [__('Transaction has been declined. Please try again later.')];
        }

        return $this->createResult($validationResult, $errorMessages);
    }

    /**
     * @param array $response
     * @return boolean
     */
    protected function validateRefundId(array $response)
    {
        return isset($response[AbstractResponseValidator::REFUND_ID])
            && $response[AbstractResponseValidator::REFUND_ID];
    }

    /**
     * @param array $response
     * @return boolean
     */
    protected function validateReturnCode(array $response)
    {
        return isset($response[self::RETURN_CODE])
            && ((string)$response[self::RETURN_CODE] === (string)self::RETURN_CODE_ACCEPT
            || (string)$response[self::RETURN_CODE] === (string)self::REFUND_CODE_ACCEPT);
    }
}
