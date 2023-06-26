<?php

namespace Tecno\CustomerUpdate\Controller\Adminhtml\Customers;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Reports\Model\ResourceModel\Customer\CollectionFactory;
use Tecno\CustomerUpdate\Model\Config;
use Tecno\CustomerUpdate\Model\Process;

class Send extends Action implements HttpPostActionInterface
{
    public function __construct(
        Context                     $context,
        protected CollectionFactory $collectionFactory,
        protected Process           $process,
        protected ManagerInterface  $manager,
        protected Config            $config
    )
    {
        parent::__construct($context);
    }


    const SELECTED_CUSTOMERS_PARAM = 'selected';
    /**
     * Authorization level of a basic admin session
     */
    public const ADMIN_RESOURCE = 'Magento_Customer::sync_with_api';


    /**
     * @throws \Exception
     */
    public function execute()
    {
        try {
            $this->syncCustomersWithApi();
        } catch (\Exception $e) {
            throw $e;

        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        $this->messageManager->addSuccessMessage(sprintf(' Synced With Api Successfully Please Check The Api Endpoint %s', $this->config->getApiEndpoint()));
        return $resultRedirect;
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function syncCustomersWithApi()
    {
        $selectedCustomerIds = $this->_request->getParam(self::SELECTED_CUSTOMERS_PARAM);
        $customerCollection = $this->collectionFactory->create();
        $customerCollection->addFilter('synced', ['eq' => 0])
            ->addFieldToFilter('entity_id', ['in' => $selectedCustomerIds]);
        $customerCollection->addFieldToSelect('*');
        $customers = $customerCollection->getItems();
        if ($customers) {
            foreach ($customers as $customer) {
                $this->process->sendToApi($customer);
            }
        }
    }
}
