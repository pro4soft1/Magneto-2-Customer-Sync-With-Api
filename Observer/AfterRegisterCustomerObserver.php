<?php

namespace Tecno\CustomerUpdate\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

/**
 * Observes the `customer_register_success` event.
 */
class AfterRegisterCustomerObserver implements ObserverInterface
{
    public function __construct(protected \Tecno\CustomerUpdate\Model\Process $process, protected \Tecno\CustomerUpdate\Model\Config $config)
    {
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return $this
     * @throws \Exception
     */
    public function execute(Observer $observer)
    {
        $event = $observer->getEvent();
        /**
         * @var $customer \Magento\Customer\Model\Customer
         */
        if ($this->config->IsAllowedSyncAfterRegister()){
            $customer = $event->getCustomer();
            $this->process->sendToApi($customer);
        }
        return $this;
    }
}
