<?php
/************************************************************
 * *
 *  * Copyright © Boolfly. All rights reserved.
 *  * See COPYING.txt for license details.
 *  *
 *  * @author    info@boolfly.com
 * *  @project   ZaloPay
 */
namespace Boolfly\ZaloPay\Controller\Payment;

use Boolfly\ZaloPay\Gateway\Helper\TransactionReader;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\Action as AppAction;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Payment\Gateway\Command\CommandPoolInterface;
use Magento\Payment\Gateway\Data\PaymentDataObjectFactory;
use Magento\Payment\Gateway\Helper\ContextHelper;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Payment\Model\MethodInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\OrderFactory;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\Serialize\Serializer\Json as SerializerJson;

/**
 * Class Ipn
 *
 * @package Boolfly\ZaloPay\Controller\Payment
 */
class Ipn extends AppAction implements CsrfAwareActionInterface
{
    /**
     * @var CommandPoolInterface
     */
    private $commandPool;

    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var MethodInterface
     */
    private $method;

    /**
     * @var PaymentDataObjectFactory
     */
    private $paymentDataObjectFactory;

    /**
     * @var OrderFactory
     */
    private $orderFactory;

    /**
     * @var SerializerJson
     */
    private $serializer;

    /**
     * Ipn constructor.
     *
     * @param Context                  $context
     * @param Session                  $checkoutSession
     * @param MethodInterface          $method
     * @param PaymentDataObjectFactory $paymentDataObjectFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param OrderFactory             $orderFactory
     * @param SerializerJson           $serializer
     * @param CommandPoolInterface     $commandPool
     */
    public function __construct(
        Context $context,
        Session $checkoutSession,
        MethodInterface $method,
        PaymentDataObjectFactory $paymentDataObjectFactory,
        OrderRepositoryInterface $orderRepository,
        OrderFactory $orderFactory,
        SerializerJson $serializer,
        CommandPoolInterface $commandPool
    ) {
        parent::__construct($context);
        $this->commandPool              = $commandPool;
        $this->checkoutSession          = $checkoutSession;
        $this->orderRepository          = $orderRepository;
        $this->method                   = $method;
        $this->paymentDataObjectFactory = $paymentDataObjectFactory;
        $this->orderFactory             = $orderFactory;
        $this->serializer               = $serializer;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            return;
        }
        /** @var Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $data       = [
            'errors' => true,
            'messages' => __('Something went wrong white execute.')
        ];
        try {
            $response = $this->getRequest()->getContent();
            if ($response && is_string($response)) {
                $response               = $this->serializer->unserialize($response);
                $response['trans_data'] = $this->serializer->unserialize($response['data']);
            }
            $orderIncrementId = TransactionReader::readOrderId($response);
            $order            = $this->orderFactory->create()->loadByIncrementId($orderIncrementId);
            $payment          = $order->getPayment();
            ContextHelper::assertOrderPayment($payment);
            if ($payment->getMethod() === $this->method->getCode()
                && $order->getState() === Order::STATE_PENDING_PAYMENT) {
                $paymentDataObject = $this->paymentDataObjectFactory->create($payment);
                $this->commandPool->get('ipn')->execute(
                    [
                        'payment' => $paymentDataObject,
                        'response' => $response,
                        'is_ipn' => true,
                        'amount' => $order->getTotalDue()
                    ]
                );
                $data = [
                    'errors' => false,
                    'messages' => __('Success')
                ];
            }
        } catch (\Exception $e) {
            $this->_objectManager->get('\Psr\Log\LoggerInterface')->critical($e->getMessage());
            $this->messageManager->addErrorMessage(__('Transaction has been declined. Please try again later.'));
            $resultJson->setHttpResponseCode(500);
        }

        return $resultJson->setData($data);
    }

    /**
     * Create exception in case CSRF validation failed.
     * Return null if default exception will suffice.
     *
     * @param RequestInterface $request
     *
     * @return InvalidRequestException|null
     */
    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    /**
     * Perform custom request validation.
     * Return null if default validation is needed.
     *
     * @param RequestInterface $request
     *
     * @return boolean|null
     */
    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return  true;
    }
}
