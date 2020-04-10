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

use Magento\Payment\Gateway\Helper\SubjectReader;

/**
 * Class GetPayUrlValidator
 *
 * @package Boolfly\ZaloPay\Gateway\Validator
 */
class GetPayUrlValidator extends AbstractResponseValidator
{
    /**
     * @param array $validationSubject
     * @return \Magento\Payment\Gateway\Validator\ResultInterface
     */
    public function validate(array $validationSubject)
    {
        $response         = SubjectReader::readResponse($validationSubject);
        $errorMessages    = [];
        $validationResult = $this->validateReturnCode($response) && $this->validatePayUrl($response);

        if (!$validationResult) {
            $errorMessages = [__('Something went wrong when get pay url.')];
        }

        return $this->createResult($validationResult, $errorMessages);
    }

    /**
     * @param $response
     * @return boolean
     */
    protected function validatePayUrl($response)
    {
        return !empty($response[AbstractResponseValidator::PAY_URL]) && strlen($response[AbstractResponseValidator::PAY_URL]) > 0;
    }
}
