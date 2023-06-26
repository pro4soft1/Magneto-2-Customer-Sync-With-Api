<?php


namespace Tecno\CustomerUpdate\Cron;

use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Framework\App\State;
use Tecno\CustomerUpdate\Model\Config;
use Tecno\CustomerUpdate\Model\Process;

class SyncCustomersCron
{

    public function __construct(protected State $state,
                                protected CollectionFactory $collection,
                                protected Process $process,
                                protected Config $config
                           )
    {
     }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(): void
    {
        $this->state->setAreaCode('adminhtml');
        $customerCollectionFactory = $this->collection->create();
        $customerCollectionFactory->addFilter('synced',['eq' => 0]);
        $customerCollectionFactory->addFieldToSelect('*');
        $customers = $customerCollectionFactory->getItems();
        if ($customers) {
            foreach ($customers as $customer) {
                try {
                    $this->process->sendToApi($customer);
                } catch (\Exception $exception) {
                    throw $exception;
                }
            }
        }
    }
}
