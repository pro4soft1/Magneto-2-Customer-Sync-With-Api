<?php

namespace Tecno\CustomerUpdate\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;
/**
 * Class Process
 *
 * @package \Tecno\CustomerUpdate\Model
 */
class Process
{
    public function __construct(protected ValidationPool $validationPool, protected Service $service, protected CustomerFactory $CustomerFactory, protected CustomerRepositoryInterface $customerRepository)
    {
    }

    /**
     * @param \Magento\Customer\Model\Data\Customer $customer
     *
     * @return bool
     * @throws \Exception
     */
    public function sendToApi($customer): bool
    {
        $customer = $this->CustomerFactory->create()->load($customer->getId());
        if ($this->canProcess($customer)) {
            return $this->service->send($customer);
        }
        return false;
    }

    private function canProcess($customer): bool
    {
        return $this->validationPool->validate($customer);
    }
}
