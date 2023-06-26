<?php

namespace Tecno\CustomerUpdate\Model\DataProvider;
/**
 * Class Customer
 *
 * @package \Tecno\CustomerUpdate\Model\DataProvider
 */
class Customer
{


    /**
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     *
     * @return array
     */
    public function prepareData($customer): array
    {
        return [
            'entity_id' => $customer->getId(),
            'store_id' => $customer->getStoreId(),
            'is_active' => $customer->getData('is_active'),
            'firstname' => $customer->getFirstname(),
            'lastname' => $customer->getLastname(),
            'email' => $customer->getEmail(),
        ];
    }

}
